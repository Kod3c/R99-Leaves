<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Location;
use App\Profile;
use App\Role;
use App\Rotas;
use App\User;
use App\Mail\SendRotas;
use App\Utility;
use Facade\FlareClient\Flare;
use Illuminate\Support\Facades\Session ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use KKomelin\TranslatableStringExporter\Core\Exporter;
use League\Flysystem\Adapter\Local;
use SebastianBergmann\Environment\Console;

use function GuzzleHttp\json_decode;

class RotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = 0)
    {
        
        if (Auth::user()->type == 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $userId = Auth::id();
        $user = Auth::user();
        $created_by = $user->get_created_by();
        $userType = Auth::user()->type;

        $where = ' 0 = 0 ';
        $locationnn = '';
        $emp_only_see_own_rota = 0;
        $employee_permission = [];

        $employee_data = Employee::whereRaw('id = ' . $created_by . ' ')->first();
        $setting = [];
        if (!empty($employee_data->company_setting)) {
            $setting = json_decode($employee_data->company_setting, true);
        }

        $first_location = '';
        if (Auth::user()->acount_type == 3) {
            if (!empty($employee_data->company_setting)) {
                $emp_only_see_own_rota = (!empty($setting['emp_only_see_own_rota'])) ? $userId : 0;
                $employee_permission['emp_only_see_own_rota'] = (!empty($setting['emp_only_see_own_rota'])) ? $userId : 0;
                $employee_permission['emp_can_see_all_locations'] = (!empty($setting['emp_can_see_all_locations'])) ? 1 : 0;
            }

            $profile = Profile::whereRaw('user_id = ' . $userId . ' ')->first();
            if (!empty($profile['location_id'])) {
                $location_id = explode(',', $profile['location_id']);
                $first_location = (!empty($location_id[0])) ? $location_id[0] : '';
                if ($employee_permission['emp_can_see_all_locations'] == 0) {
                    $where .= ' and id IN (' . $profile['location_id'] . ')';
                }
            }
        }

        if (Auth::user()->acount_type == 2 && !empty(Auth::user()->manager_permission)) {
            $profile = Profile::whereRaw('user_id = ' . $userId . ' ')->first();
            if (!empty($profile['location_id'])) {
                $locationnn = $profile['location_id'];
            }

            $manager_permission_array = json_decode(Auth::user()->manager_permission, true);
            if (!empty($manager_permission_array['manage_loaction'])) {
                $manage_location = $manager_permission_array['manage_loaction'];
                if ($locationnn == '') {
                    $locationnn =  $manage_location;
                } else {
                    $locationnn =  $locationnn . ',' . $manage_location;
                }
            }

            if (!empty($locationnn)) {
                $location_ids =  implode(',', array_unique(explode(',', $locationnn)));
                $where .= ' and id IN (' . $location_ids . ')';
            }
        }

        $location_option = [];
        $locations = Location::whereRaw('created_by = ' . $created_by . ' ')->whereRaw($where)->get();
        foreach ($locations as $location) {
            $location_option[$location->id] = $location->name;
        }

        $location = Location::where('created_by', $created_by)->first();

        if (empty($first_location)) {
            $first_location = (!empty($location->id)) ? $location->id : 0;
        }

        $employees = Rotas::getLocatioWiseUser($first_location, $emp_only_see_own_rota);

        $emp_setting = Auth::user()->employee_setting;
        $day_off = 'hide';
        $leave_display = 'hide';
        $availability_display = 'hide';
        if (!empty($emp_setting)) {
            $emp_setting = json_decode($emp_setting, true);
            $day_off = (!empty($emp_setting['day_off']) && $emp_setting['day_off'] == 'show') ? 'show' : 'hide';
            $leave_display = (!empty($emp_setting['leave_display']) && $emp_setting['leave_display'] == 'show') ? 'show' : 'hide';
            $availability_display = (!empty($emp_setting['availability_display']) && $emp_setting['availability_display'] == 'show') ? 'show' : 'hide';
        }

        $roles = Role::where('created_by', $created_by)->get();
        $role_option = [];
        $role_option[0] = __('Please select roll');
        if (count($roles) != 0) {
            foreach ($roles as $key => $role) {
                $role_option[$role->id] = $role->name;
            }
        }

        $date_formate = User::CompanyDateFormat('d M Y');
        $week = 0;

        $settings = User::companystaticSetting();
        $start_day = (!empty($settings['company_week_start'])) ? $settings['company_week_start'] : 'monday';
        $week_date = Rotas::getWeekArray($date_formate, $week, $start_day);

        $week_date['week_start'] = date('Y-m-d', strtotime($week_date[0]));
        $week_date['week_end'] = date('Y-m-d', strtotime($week_date[6]));
        return view('rotas.index', compact('location_option', 'role_option', 'roles', 'employees', 'week_date', 'created_by', 'first_location', 'day_off', 'leave_display', 'availability_display'));
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->id;
        $date = $request->date;
        $role_option[''] = __('Without Role');
        if(!empty($request->id))
        {
            $roles = Profile::where('user_id', $request->id)->first();
            if(!empty($roles) && !empty($roles->role_id))
            {
                $roles_id = explode(',', $roles->role_id);
                if(!empty($roles_id))
                {
                    foreach($roles_id as $role_id){
                        $role = Role::where('id', $role_id)->first();
                        if(!empty($role))
                        {
                            $role_option[$role->id] = $role->name;                            
                        }
                    }
                }
            }
        }

        $user = Auth::user();
        $created_by = $user->get_created_by();
        $location = Location::where('created_by', $created_by)->first();
        $first_location = (!empty($location->id)) ? $location->id : 0 ;

        return view('rotas.create',compact('role_option','user_id','date','first_location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $userId = Auth::id();
        $user = Auth::user();
        $created_by = $user->get_created_by();
        $start_time =  str_replace(':','.',$request->start_time);
        $end_time =  str_replace(':','.',$request->end_time);
        $time_override = Rotas::WhereRaw('user_id ='. $request->user_id)
                                ->WhereRaw('rotas_date = "'.$request->rotas_date.'"')
                                ->WhereRaw('(
                                        ( start_time = "'.$start_time.'" AND end_time = "'.$end_time.'" ) or 
                                        ("'.$start_time.'" BETWEEN start_time and end_time or "'.$end_time.'" BETWEEN start_time and end_time ) or 
                                        (start_time BETWEEN "'.$start_time.'" and "'.$end_time.'" or end_time BETWEEN "'.$start_time.'" and "'.$end_time.'" )
                                    )')
                                ->get()->toArray();
        if (count($time_override) == 0)
        {
            $diff_in_minutes = 0;
            $to = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
            $from = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
            if($from == $to) {
                $diff_in_minutes = 1440;
            } elseif($from > $to) {
                $diff_in_minutes = $to->diffInMinutes($from);
            } elseif($from < $to) {
                $to = $request->start_time;
                $to_array = explode(':', $to);
                $to_minutes = 1440 - ($to_array[0] * 60 + $to_array[1]);

                $from = $request->end_time;
                $from_array = explode(':', $from);
                $from_minutes = $from_array[0] * 60 + $from_array[1];

                $diff_in_minutes = $to_minutes + $from_minutes;
            }

            $rotas = new Rotas();
            $rotas['user_id']               = $request->user_id;
            $rotas['issued_by']             = $userId;
            $rotas['rotas_date']            = $request->rotas_date;
            $rotas['start_time']            = $request->start_time;
            $rotas['end_time']              = $request->end_time;
            $rotas['break_time']            = $request->break_time;
            $rotas['time_diff_in_minut']    = $diff_in_minutes;
            $rotas['role_id']               = (!empty($request->role_id)) ? $request->role_id : 0 ;
            $rotas['location_id']           = $request->location_id;
            $rotas['note']                  = $request->note;
            $rotas['publish']               = 0;
            $rotas['create_by']             = $created_by;            

            $rotas->save();
            $return['status'] = 'success';
            $return['msg'] = __('Shift add successfully');
            return response()->json($return);
        } else {
            $employee = Employee::where('id', $time_override[0]['user_id'])->first();
            $name = 'user';
            if(!empty($employee)) { $name = $employee->first_name; }

            $role_name = '';
            if(!empty($time_override[0]['role_id']) || $time_override[0]['role_id'] == 0) {
                $role = Role::where('id', $time_override[0]['role_id'])->first();
                if(!empty($role)) { $role_name = $role->name; }
            }

            $return['status'] = 'error';
            $return['msg'] =  __('This Shift clashes ') . '' . $name . ' ' . date("g:i a", strtotime($time_override[0]['start_time'])) . ' - ' . date("g:i a", strtotime($time_override[0]['end_time'])) . ' ' . $role_name . '' . __(' shift');            
            return response()->json($return);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\rotas  $rotas
     * @return \Illuminate\Http\Response
     */
    public function show(rotas $rotas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\rotas  $rotas
     * @return \Illuminate\Http\Response
     */
    public function edit(rotas $rotas,$id)
    {
        $rotas = Rotas::find($id);
        $user_id = $rotas->user_id;
        $date = $rotas->date;
        $role_option[''] = __('Without Role');
        if(!empty($rotas->user_id))
        {
            $roles = Profile::where('user_id', $rotas->user_id)->first();
            if(!empty($roles) && !empty($roles->role_id))
            {
                $roles_id = explode(',', $roles->role_id);
                if(!empty($roles_id))
                {
                    foreach($roles_id as $role_id){
                        $role = Role::where('id', $role_id)->first();
                        if(!empty($role))
                        {
                            $role_option[$role->id] = $role->name;
                        }
                    }
                }
            }
        }
        return view('rotas.edit',compact('role_option','rotas','user_id','date'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\rotas  $rotas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rotas $rotas,$id)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $created_by = $user->get_created_by();

        $start_time =  str_replace(':','.',$request->start_time);
        $end_time =  str_replace(':','.',$request->end_time);        
        $time_override = Rotas::
                                WhereRaw('id != '.$id.' ')
                                ->WhereRaw('user_id ='. $request->user_id.' ')
                                ->WhereRaw('rotas_date = "'.$request->rotas_date.'"')
                                ->WhereRaw('(
                                    ( start_time = "'.$start_time.'" AND end_time = "'.$end_time.'" ) or 
                                    ('.$start_time.' BETWEEN start_time and end_time or '.$end_time.' BETWEEN start_time and end_time ) or 
                                    (start_time BETWEEN '.$start_time.' and '.$end_time.' or end_time BETWEEN '.$start_time.' and '.$end_time.' )
                                )')
                                ->get()->toArray();
                                
        if(empty($time_override))
        {
            $diff_in_minutes = 0;
            $to = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
            $from = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
            if($from == $to) {
                $diff_in_minutes = 1440;
            } elseif($from > $to) {
                $diff_in_minutes = $to->diffInMinutes($from);
            } elseif($from < $to) {
                $to = $request->start_time;
                $to_array = explode(':', $to);
                $to_minutes = 1440 - ($to_array[0] * 60 + $to_array[1]);

                $from = $request->end_time;
                $from_array = explode(':', $from);
                $from_minutes = $from_array[0] * 60 + $from_array[1];

                $diff_in_minutes = $to_minutes + $from_minutes;
            }

            $rotas = Rotas::find($id);
            $rotas['start_time']            = $request->start_time;
            $rotas['end_time']              = $request->end_time;
            $rotas['break_time']            = $request->break_time;
            $rotas['time_diff_in_minut']    = $diff_in_minutes;            
            $rotas['role_id']               = (!empty($request->role_id)) ? $request->role_id : 0 ;
            $rotas['start_time']            = $request->start_time;
            $rotas['end_time']              = $request->end_time;
            $rotas['note']                  = $request->note;

            $rotas->save();
            $return['status'] = 'success';
            $return['msg'] = __('Shift update successfully');
            return response()->json($return);
        } else {

            $employee = Employee::where('id', $time_override[0]['user_id'])->first();
            $name = 'user';
            if(!empty($employee)) { $name = $employee->first_name; }

            $role_name = '';
            if(!empty($time_override[0]['role_id']) || $time_override[0]['role_id'] == 0) {
                $role = Role::where('id', $time_override[0]['role_id'])->first();
                if(!empty($role)) { $role_name = $role->name; }
            }
            $return['status'] = 'error';
            $return['msg'] =  __('This Shift clashes ') . '' . $name . ' ' . date("g:i a", strtotime($time_override[0]['start_time'])) . ' - ' . date("g:i a", strtotime($time_override[0]['end_time'])) . ' ' . $role_name . '' . __(' shift');            
            return response()->json($return);            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\rotas  $rotas
     * @return \Illuminate\Http\Response
     */
    public function destroy(rotas $rotas, $id)
    {        
        $rotas = Rotas::find($id);
        $rotas->delete();

        $return['status'] = 'success';
        $return['msg'] = __('Delete Succsefully');
        return response()->json($return);
    }
    
    
    public function clear_week()
    {
        $created_by = $_REQUEST['created_by'];
        $week = (!empty($_REQUEST['week'])) ? $_REQUEST['week'] : 0;
        $week = $week * 7;

        $employee_data = Employee::whereRaw('id = ' . $created_by . ' ')->first();
        $setting = [];
        if (!empty($employee_data->company_setting)) {
            $setting = json_decode($employee_data->company_setting, true);
        }
        $start_day = (!empty($setting['company_week_start'])) ? $setting['company_week_start'] : 'monday';
        $week_date = Rotas::getWeekArray('Y-m-d', $week, $start_day);

        $location_id    = (!empty($_REQUEST['location_id'])) ? $_REQUEST['location_id'] : 0;
        $created_by     = (!empty($_REQUEST['created_by'])) ? $_REQUEST['created_by'] : 0;
        $end_date       = (!empty($_REQUEST['end_date'])) ? $_REQUEST['end_date'] : 0;
        $start_date     = (!empty($_REQUEST['start_date'])) ?  $_REQUEST['start_date'] : 0;

        $rotas = Rotas::WhereRaw('location_id = ' . $location_id)
            ->WhereRaw('create_by = ' . $created_by)
            ->WhereRaw('rotas_date BETWEEN "' . $week_date[0] . '" AND "' . $week_date[6] . '"');
        $delete_satatus = $rotas->delete();
        if ($delete_satatus) {
            $array =  array('status' => 'success', 'msg' => __('Delete Succsefully'));
        } else {
            $array =  array('status' => 'error', 'msg' => __('Please Try Again.'));
        }
        return $array;
    }

    public function week_sheet()
    {
        $userId = Auth::id();
        $created_by = $_REQUEST['created_by'];
        $week1 = 0;
        if (!empty($_REQUEST['week'])) {
            $week1 = $_REQUEST['week'];
        }
        $week = $_REQUEST['week'];
        $location_id = !(empty($_REQUEST['location_id'])) ? $_REQUEST['location_id'] : '' ;
        if($location_id == '')
        {
            $array['status'] = 'error';
            $array['msg'] = __('Location no found');
            return $array;
        }
        
        $role_id = $_REQUEST['role_id'];
        $week = $week * 7;


        $employee_data = Employee::whereRaw('id = ' . $created_by . ' ')->first();
        $setting = [];
        if (!empty($employee_data->company_setting)) {
            $setting = json_decode($employee_data->company_setting, true);
        }


        $start_day = (!empty($setting['company_week_start'])) ? $setting['company_week_start'] : 'monday';
        $date_formate = User::CompanyDateFormat('d M Y');
        $week_date1 = Rotas::getWeekArray($date_formate, $week, $start_day);
        $week_date = Rotas::getWeekArray('Y-m-d', $week, $start_day);
        $week_date123 = Rotas::getWeekArray('d M Y', $week, $start_day);
        $where = '0 = 0 ';
        $emp_only_see_own_rota = 0;
        if (Auth::user()->acount_type == 3) {
            $employee_data = Employee::whereRaw('id = ' . $created_by . ' ')->first();
            if (!empty($employee_data->company_setting)) {
                $setting = json_decode($employee_data->company_setting, true);
                $emp_only_see_own_rota = (!empty($setting['emp_only_see_own_rota'])) ? $userId : 0;
            }
        }

        $table_date = [];
        $thead = '<thead> <tr class="text-center">
            <th></th>
            <th><span>' . __(date('D', strtotime($week_date1[0]))) . '</span><br><span>' . __($week_date1[0]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[1]))) . '</span><br><span>' . __($week_date1[1]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[2]))) . '</span><br><span>' . __($week_date1[2]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[3]))) . '</span><br><span>' . __($week_date1[3]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[4]))) . '</span><br><span>' . __($week_date1[4]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[5]))) . '</span><br><span>' . __($week_date1[5]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[6]))) . '</span><br><span>' . __($week_date1[6]) . '</span></th>
            </tr></thead>';
        $thead2 = '
            <th></th>
            <th><span>' . __(date('D', strtotime($week_date1[0]))) . '</span><br><span>' . __($week_date1[0]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[1]))) . '</span><br><span>' . __($week_date1[1]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[2]))) . '</span><br><span>' . __($week_date1[2]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[3]))) . '</span><br><span>' . __($week_date1[3]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[4]))) . '</span><br><span>' . __($week_date1[4]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[5]))) . '</span><br><span>' . __($week_date1[5]) . '</span></th>
            <th><span>' . __(date('D', strtotime($week_date1[6]))) . '</span><br><span>' . __($week_date1[6]) . '</span></th>';

        $employees = Rotas::getLocatioWiseUser($location_id, $emp_only_see_own_rota, $role_id);

        $tbody = '';
        if (count($employees) != 0) {
            foreach ($employees as $employee)
            {                
                $tbody .= $employee->getWorkSchedule($employee->id, $week1, $location_id);
            }            
        } else {
            $tbody = '<tr>
                        <td colspan="8">
                            <div class="text-center">
                                <i class="fas fa-map-marker-alt text-primary fs-40"></i>
                                <h2>' . __('Opps...') . '</h2>
                                <h6>' . __('User not assign this location.') . ' </h6>
                                <h6 class="d-none"> ' . __('Please assign user in this location.') . ' </h6>
                            </div>
                        </td>
                    </tr>';
        }

        // 2nd table in page bottom
        $week_exp = '';
        if(Auth::user()->type == 'company')
        {   
            $week_exp = Employee::getCompanyWeeklyUserSalary($week1, $created_by, $location_id, $role_id);
        }

        $array = array('table' => $thead . '<tbody>' . $tbody . '</tbody><tfoot class="bt2"></tfoot>', 'title' => $week_date1[0] . ' - ' . $week_date1[6], 'week_exp' => $week_exp, 'thead' => $thead2);
        return $array;
    }

    public function shift_copy()
    {  
        $array =  array('status'=>'error','msg'=> __('Please Try Again.'));

        $userId = Auth::id();      
        $user = Auth::user();
        $created_by = $user->get_created_by();

        $drag_rotas_data = Rotas::whereRaw('id = '.$_POST['rotas_id'])->first()->toArray();        
        $rotas_start_time = $drag_rotas_data['start_time'];
        $rotas_end_time = $drag_rotas_data['end_time'];        
        $rotas_role_id = $drag_rotas_data['role_id'];        

        $user_have_role = Profile::WhereRaw('user_id = '. $_REQUEST['drop_user_id'].' ')        
                                    ->WhereRaw(' FIND_IN_SET('.$rotas_role_id.', role_id) ')
                                    ->count();
        if(Auth::user()->type == 'company')
        {
            if ($user_have_role != 0 || $rotas_role_id == 0)
            {
                $time_override = Rotas::WhereRaw('user_id = '. $_REQUEST['drop_user_id'].' ')
                                    ->WhereRaw('rotas_date = "'.$_REQUEST['drop_date'].'"')
                                    ->WhereRaw('(
                                        ( start_time = "'.$rotas_start_time.'" AND end_time = "'.$rotas_end_time.'" ) or 
                                        ("'.$rotas_start_time.'" BETWEEN start_time and end_time or "'.$rotas_end_time.'" BETWEEN start_time and end_time ) or 
                                        (start_time BETWEEN "'.$rotas_start_time.'" and "'.$rotas_end_time.'" or end_time BETWEEN "'.$rotas_start_time.'" and "'.$rotas_end_time.'" )
                                        )')
                                    ->first();           
                                    
                $role_name = '';
                $role_color = 'border-color : rgb(132, 146, 166);';
                if(!empty($rotas_role_id) || $rotas_role_id == 0) {
                    $role = Role::where('id', $rotas_role_id)->first();
                    if(!empty($role)) {
                        $role_name = $role->name;
                        $role_color = 'border-color : '.$role->color.';';
                    }
                }

                if(empty($time_override))
                {   
                    $diff_in_minutes = 0;
                    $to = \Carbon\Carbon::createFromFormat('H:i', $rotas_start_time);
                    $from = \Carbon\Carbon::createFromFormat('H:i', $rotas_end_time);
                    if($from == $to)
                    {
                        $diff_in_minutes = 1440;
                    }
                    elseif($from > $to)
                    {
                        $diff_in_minutes = $to->diffInMinutes($from);
                    }
                    elseif($from < $to)
                    {
                        $to = $rotas_start_time;
                        $to_array = explode(':', $to);
                        $to_minutes = 1440 - ($to_array[0] * 60 + $to_array[1]);

                        $from = $rotas_end_time;
                        $from_array = explode(':', $from);
                        $from_minutes = $from_array[0] * 60 + $from_array[1];

                        $diff_in_minutes = $to_minutes + $from_minutes;
                    }
                    
                    $rotas = new Rotas();
                    $rotas->user_id               = $_REQUEST['drop_user_id'];
                    $rotas->issued_by             = $userId;
                    $rotas->rotas_date            = $_REQUEST['drop_date'];
                    $rotas->start_time            = $rotas_start_time;
                    $rotas->end_time              = $rotas_end_time;
                    $rotas->time_diff_in_minut    = $diff_in_minutes;
                    $rotas->role_id               = $drag_rotas_data['role_id'];
                    $rotas->location_id           = $_REQUEST['location_id'];
                    $rotas->note                  = $drag_rotas_data['note'];
                    $rotas->publish               = 0;
                    $rotas->create_by             = $created_by;
                    $rotas->save();
                    
                    $insert_id = $rotas->id;
                    $time = date('h:i a', strtotime($rotas_start_time)).' - '.date('h:i a', strtotime($rotas_end_time));
                    $shift = '<b class="text-dark">'.$time.'</b><br>
                                <span class="text-secondary"> '.$role_name.' </span>
                                <div class="float-right d-block">
                                    <a href="#" class="action-item only_rotas bg-transparent p-0  " data-toggle="tooltip" title="'.$drag_rotas_data['note'].'"><i class="fas fa-comment"></i></a>
                                    <a href="#" class=" action-item edit_rotas only_rotas bg-transparent p-0" data-ajax-popup="true" data-title="'.__('Edit Shift').'" data-size="md" data-url="'.route('rotas.edit', $insert_id).'">
                                        <i class="fas fa-pencil-alt" data-toggle="tooltip"  title="'.__('Edit Shift').'"></i>
                                    </a>
                                    
                                    <a href="#" class=" action-item delete_rotas only_rotas bg-transparent p-0" data-confirm="'. __('Are You Sure?') .'|'. __('This action can not be undone. Do you want to continue?') .'" data-confirm-yes=document.getElementById("delete-form-'.$insert_id.'").submit(); >
                                        <i class="fas fa-trash" data-toggle="tooltip" data-original-title="'.__('Delete').'" ></i>
                                    </a>
                                    <form method="POST" action="'.route('rotas.destroy',$insert_id).'" id="delete-form-'.$insert_id.'">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="'.csrf_token().'">
                                    </form>
                                </div>
                                <sapn class="clearfix">
                            </sapn>';


                    $array =  array('status'=>'success', 'msg'=> __('Shift Add Successfully'), 'shift' => $shift, 'insert_id' => $insert_id);
                }
                else
                {
                    $employee = Employee::where('id', $_REQUEST['drop_user_id'])->first();                
                    $name = (!empty($employee->first_name)) ? $employee->first_name : __(' employee ') ;                
                    $msg = __('This Shift clashes ').''.$name.' '.date("g:i a", strtotime($time_override['start_time'])).' - '.date("g:i a", strtotime($time_override['end_time'])).' '.$role_name.''.__(' shift');
                    $array =  array('status'=>'error', 'msg'=> $msg);
                }
            }
            else
            {
                $array =  array('status'=>'error', 'msg'=> __('Roles are different for both the user.'));
            }
        }
        else
        {
            $array =  array('status'=>'error', 'msg'=> __('Permission denied.'));
        }
        return $array;        
    }

    public function un_publish_week()
    {
        $array =  array('status' => 'error', 'msg' => __('Please Try Again'));
        $userId = Auth::id();
        $user = Auth::user();
        $created_by = $user->get_created_by();

        $week = (!empty($_REQUEST['week'])) ? $_REQUEST['week'] * 7 : 0 * 7;
        $created_by = $_REQUEST['created_by'];
        $location_id = $_REQUEST['location_id'];

        $employee_data = Employee::whereRaw('id = ' . $created_by . ' ')->first();
        $setting = [];
        if (!empty($employee_data->company_setting)) {
            $setting = json_decode($employee_data->company_setting, true);
        }
        $start_day = (!empty($setting['company_week_start'])) ? $setting['company_week_start'] : 'monday';
        $week_date = Rotas::getWeekArray('Y-m-d', $week, $start_day);
        $rotas = Rotas::whereRaw('location_id = ' . $location_id . '')->whereRaw('create_by = ' . $created_by . '')->whereRaw('rotas_date BETWEEN "' . $week_date[0] . '" AND "' . $week_date[6] . '" ')->get()->toArray();
        if (!empty($rotas)) {
            foreach ($rotas as $rota) {
                $rota_data = Rotas::find($rota['id']);
                $rota_data->publish = 0;
                $rota_data->save();
            }
            $array =  array('status' => 'success', 'msg' => __('Shift Un-Publish Successfully'));
        }
        return $array;
    }

    public function publish_week()
    {
        $array =  array('status' => 'success', 'msg' => __('Please Try Again'));
        $userId = Auth::id();
        $user = Auth::user();
        $created_by = $user->get_created_by();

        $week = (!empty($_REQUEST['week'])) ? $_REQUEST['week'] * 7 : 0 * 7;
        $created_by = $_REQUEST['created_by'];
        $location_id = $_REQUEST['location_id'];

        $employee_data = Employee::whereRaw('id = ' . $created_by . ' ')->first();
        $setting = [];
        if (!empty($employee_data->company_setting)) {
            $setting = json_decode($employee_data->company_setting, true);
        }
        $start_day = (!empty($setting['company_week_start'])) ? $setting['company_week_start'] : 'monday';
        $week_date = Rotas::getWeekArray('Y-m-d', $week, $start_day);
        $rotas = Rotas::whereRaw('location_id = ' . $location_id . '')->whereRaw('create_by = ' . $created_by . '')->whereRaw('rotas_date BETWEEN "' . $week_date[0] . '" AND "' . $week_date[6] . '" ')->get()->toArray();
        if (!empty($rotas)) {
            foreach ($rotas as $rota) {
                $rota_data = Rotas::find($rota['id']);
                $rota_data->publish = 1;
                $rota_data->save();
            }
            $array =  array('status' => 'success', 'msg' => __('Shift Publish Successfully'));
        }
        return $array;
    }

    public function add_dayoff()
    {
        $array =  array('status' => 'success', 'msg' => __('Please Try Again'));
        $date[] = $_REQUEST['date'];
        $click_day = date('l', strtotime($_REQUEST['date']));

        $date_status = '';
        if (!empty($_REQUEST['user_id']) && !empty($_REQUEST['date'])) {
            $profile = Profile::whereRaw('user_id = ' . $_REQUEST['user_id'] . '')->first();
            if (!empty($profile->custom_day_off)) {
                $date_array = json_decode($profile->custom_day_off, true);
                $date_inarray = in_array($_REQUEST['date'], $date_array);
                if ($date_inarray) {
                    $remove_date = array_diff($date_array, $date);
                    $date_array = (!empty($remove_date)) ? array_values($remove_date) : '';
                    $date_status = '';
                    $msg = __('Remove day off successfully');
                } else {
                    array_push($date_array, $_REQUEST['date']);
                    $date_status = 'add';
                    $date_status = '<div class="text-center text-danger day_off_leave cus_day_off_leave ui-sortable-handle" data-date="' . $_REQUEST['date'] . '" data-placement="top" data-html="true" data-toggle="tooltip" title="' . __('This is') . $profile->getUserName->first_name . __(' Day Off') . '">' . __(' Day Off') . '</div>';
                    $msg = __('Add day off successfully');
                }
            } else {
                $date_array[] = $_REQUEST['date'];
                $date_status = 'add';
                $date_status = '<div class="text-center text-danger day_off_leave cus_day_off_leave ui-sortable-handle" data-date="' . $_REQUEST['date'] . '" data-placement="top" data-html="true" data-toggle="tooltip" title="' . __('This is') . $profile->getUserName->first_name . __(' Day Off') . '">' . __(' Day Off') . '</div>';
                $msg = __('Add day off successfully');
            }

            $profile->custom_day_off = (!empty($date_array)) ? json_encode($date_array) : null;
            $profile->save();
            $array =  array('status' => 'success', 'msg' => $msg, 'date_status' => $date_status, 'date' => $_REQUEST['date']);
        }
        return response()->json($array);
    }

    public function add_remove_employee_popup(Request $request)
    {
        $location = $_REQUEST['loaction'];
        $create_by = $_REQUEST['create_by'];
        $users = User::where('id', $create_by)->orwhere('created_by', $create_by)->get();
        $user_array = [];
        $id_array = [];
        if (!empty($users)) {
            $id_array = array_column($users->toArray(), 'id');
            foreach ($users as $key => $user) {
                $has_location = Profile::whereRaw(' FIND_IN_SET(' . $location . ', location_id)')->where('user_id', $user['id'])->first();
                $user_array[$key]['name'] = (!empty($user['first_name'])) ? $user['first_name'] : $user['last_name'];
                $user_array[$key]['profile_id'] = (!empty($user['id'])) ? $user['id'] : 0;
                $user_array[$key]['has_location'] = (!empty($has_location)) ? true : false;
                $user_array[$key]['loaction_id'] = (!empty($location)) ? $location : 0;
            }
        }
        $id_array  = json_encode($id_array);
        $employee  = 'employee';
        return view('rotas.addremoveemployee', compact('user_array', 'id_array', 'employee', 'location'));
    }

    public function add_remove_employee(Request $request)
    {
        $request_data = $request->all();
        $id_array = $request->id_array;
        $location = $request->location;
        $location_arr[] = $request->location;

        unset($request_data['id_array']);
        unset($request_data['location']);

        $name = [];
        $add_data = [];
        if (!empty($request_data)) {
            foreach ($request_data as $key => $data) {
                $add_data[] =  $key;

                $user_data = Profile::whereRaw('user_id =' . $key . '')->first();
                if (!empty($user_data['location_id'])) {
                    $loation_array = explode(',', $user_data['location_id']);
                    if (!empty($loation_array) && !in_array($location, $loation_array)) {
                        array_push($loation_array, $location);
                    }
                    $user_data->location_id = implode(',', $loation_array);
                } else {
                    $user_data->location_id = $location;
                }
                $user_data->save();
            }
        }


        //remove employee
        $remove_datas = [];
        if (!empty($id_array)) {
            $id_array = json_decode($id_array, true);
            if (!empty($add_data)) {
                $remove_datas = array_diff($id_array, $add_data);
                if (!empty($remove_datas)) {
                    $remove_datas = array_values($remove_datas);
                }
            } else {
                $remove_datas = $id_array;
            }

            if (!empty($remove_datas)) {
                foreach ($remove_datas as $remove_data) {
                    $remove_location = Profile::whereRaw('user_id =' . $remove_data . '')->first();

                    $today_date = date("Y-m-d");
                    $has_rotas = Rotas::whereRaw('user_id =' . $remove_data . '')
                        ->whereRaw('rotas_date >= "' . $today_date . '"')
                        ->whereRaw('publish >= 1')
                        ->count();

                    if ($has_rotas == 0) {
                        if (!empty($remove_location['location_id'])) {
                            $re_loation_array = explode(',', $remove_location['location_id']);

                            if (!empty($re_loation_array) && in_array($location, $re_loation_array)) {
                                $key2 = array_search($location, $re_loation_array);

                                if (false !== $key2) {
                                    unset($re_loation_array[$key2]);
                                }

                                $remove_location->location_id = implode(',', $re_loation_array);
                                $remove_location->save();
                            }
                        }
                    } else {
                        $emp_data =  User::whereRaw('id=' . $remove_data . '')->first();
                        $name[] = $emp_data['first_name'];
                    }
                }
            }
        }
        $name = (!empty($name)) ? ' <br> <span class="text-danger">' . implode(', ', $name) . __(' has shift') : '</span>';
        return redirect()->back()->with('success', __('Employee Remove this location') . '' . $name);
    }

    public function send_email_rotas()
    {
        $week = 0;
        $location_id = $_REQUEST['location_id'];

        $user = Auth::user();
        $created_by = $user->get_created_by();

        $date = Employee::week_day_by_setting($week = 0, $created_by);

        $has_users = User::where('id', $created_by)->orwhere('created_by', $created_by)->get()->toArray();

        $all_role = Role::where('created_by', $created_by)->get()->toArray();
        $role_datas = [];
        if (!empty($all_role)) {
            foreach ($all_role as $role_data) {
                $role_datas[$role_data['id']] = $role_data['name'];
            }
        }

        $all_locations = Location::where('created_by', $created_by)->get()->toArray();
        $location_datas = [];
        if (!empty($all_locations)) {
            foreach ($all_locations as $all_location) {
                $location_datas[$all_location['id']] = $all_location['name'];
            }
        }

        if (!empty($has_users)) {
            foreach ($has_users as $has_user) {
                $rotas_data = Rotas::whereRaw('user_id =' . $has_user['id'] . '')->whereRaw('publish = 1')->whereRaw(' rotas_date BETWEEN "' . $date[0] . '" AND "' . $date[6] . '"')->get()->toArray();
                if (!empty($has_user['email'])) {
                    $smtp_error = '';
                    try {
                        Mail::to($has_user['email'])->send(new SendRotas($rotas_data, $role_datas, $location_datas, $has_user['id'], $date));
                    } catch (\Exception $e) {
                        $smtp_error = '<br><span class="text-danger">' . __('E-Mail has been not sent due to SMTP configuration') . '<span>';
                    }
                }
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => __('Mail Send Successfully') . $smtp_error
        ]);
    }

    public function print_rotas_popup(Request $request)
    {
        $week       = $request->week;
        $loaction   = $request->location_id;
        $create_by  = $request->created_by;
        $role_id    = $request->role_id;

        $where = ' 0 = 0 ';

        $location_id = $request->loaction;
        if ($location_id != 0 && !empty($location_id)) {
            $where .= ' AND FIND_IN_SET(' . $location_id . ', profiles.location_id) ';
        }

        $role_id = $request->role_id;
        if ($role_id != 0 && !empty($role_id)) {
            $where .= ' AND FIND_IN_SET(' . $role_id . ', profiles.role_id) ';
        }

        $create_by = $request->create_by;
        if ($create_by != 0 && !empty($create_by)) {
            $where .= ' AND users.created_by = ' . $create_by . ' ';
        }

        $users = Profile::join('users', 'users.id', '=', 'profiles.user_id')->whereraw($where)->get();

        $user_array = [];
        if ($users) {
            foreach ($users as $key => $user) {
                $user_array[$key]['id'] = $user->id;
                $user_array[$key]['name'] = $user->first_name . ' ' . $user->last_name;
            }
        }
        return view('rotas.printrotas', compact('user_array', 'week', 'location_id', 'create_by', 'role_id'));
    }

    public function printrotasInvoice(Request $request)
    {
        if (!empty($request->user)) {
            $user_array = $request->user;
            $week = $request->week;

            $settings = User::companystaticSetting();
            $start_day = (!empty($settings['company_week_start'])) ? $settings['company_week_start'] : 'monday';
            $week_date = Rotas::getWeekArray('Y-m-d', $week, $start_day);

            $company_date_format = (!empty($settings['company_date_format'])) ? $settings['company_date_format'] : 'd M Y';
            $week_date_formate = Rotas::getWeekArray($company_date_format, $week, $start_day);

            $users_name = [];
            if (!empty($user_array)) {
                foreach ($user_array as $key => $value) {
                    $user_data = User::where('id', $value)->first();
                    $users_name[$key]['id'] = $value;
                    $users_name[$key]['name'] = $user_data->first_name;
                }
            }


            $logo = asset(Storage::url('uploads/logo/'));
            $settting = Utility::settings(Auth::user()->get_created_by());
            $logo_path = $logo . '/' . $settting['company_logo'];

            return view('rotas.rotastable', compact('week_date_formate', 'week_date', 'users_name', 'logo_path'));
        } else {
            return redirect()->back()->with('errors', __('Please select User'));
        }
    }

    public function shift_cancel(Request $request, $id)
    {
        $rota = Rotas::find($id);
        return view('rotas.shift_cancel', compact('rota'));
    }

    public function shift_disable(Request $request)
    {
        $rota_id = $request->rota_id;
        $shift_status = $request->shift_status;
        $shift_cancel_employee_msg = $request->shift_cancel_employee_msg;

        $rota_id = Rotas::find($rota_id);
        $rota_id->shift_status = $request->shift_status;
        $rota_id->shift_cancel_employee_msg = $request->shift_cancel_employee_msg;
        $rota_id->save();

        return redirect()->back()->with('success', __('Shift unavailability request sent.'));
    }

    public function shift_disable_response(Request $request, $id)
    {
        $rota_id = $id;
        $rota = Rotas::find($id);
        $f_name = $rota->getrotauser->first_name;

        $name = (!empty(trim($f_name))) ? $f_name : __('User');

        $msg = $name . __(' has requested unavailability for this shift.');

        return view('rotas.shift_cancel_response', compact('rota', 'msg'));
    }

    public function shift_disable_reply(Request $request)
    {
        $rota = Rotas::find($request->rota_id);
        $rota->shift_status = $request->shift_status;
        $rota->shift_cancel_owner_msg = $request->shift_cancel_owner_msg;
        $rota->save();
        $stutas = ($request->shift_status == 'disable') ? __('Approve') : __('Deny');
        return redirect()->back()->with('success', __('Shift request ') . $stutas . '.');
    }

    public function share_rotas_popup(Request $request)
    {
        $rota['loaction_id']  = $request->loaction;
        $rota['role_id']      = $request->role_id;
        $rota['create_by']    = $request->create_by;
        $rota['week']         = $request->week;
        $rota['user_array']   = $request->user;
        return view('rotas.shift_share', compact('rota'));
    }

    public function share_rotas_link(Request $request)
    {
        $query_string['location'] = $request->location;
        $query_string['create_by'] = $request->create_by;
        $query_string['role_id'] = $request->role_id;
        $query_string['week'] = $request->week;
        $query_string['user_array'] = $request->user_array;
        $query_string['share_password'] = $request->share_password;
        $query_string['password_sts'] = (!empty($request->share_password)) ? 1 : 0;
        $query_string['expiry_date'] = $request->expiry_date;        

        $enc_url = Crypt::encrypt($query_string);
        $url = route('rotas.share', $enc_url);
        return response()->json([
            'status' => 'success',
            'message' => $url
        ]);
    }

    public function share_rotas(Request $request, $slug)
    {
        $decrypted_array = Crypt::decrypt($slug);
        $user_array     = $decrypted_array['user_array'];
        $location       = $decrypted_array['location'];
        $create_by      = $decrypted_array['create_by'];
        $role_id        = $decrypted_array['role_id'];
        $week           = $decrypted_array['week'];
        $password_sts   = $decrypted_array['password_sts'];
        $expiry_date    = $decrypted_array['expiry_date'];

        if (!empty($decrypted_array['share_password'])) {
            $password       = $decrypted_array['share_password'];
        } else {
            $password       = '';
        }

        $location = Location::find($location);

        $users_name = User::whereraw('id in (' . $user_array . ')')->get();
        if (empty($users_name)) {
            $users_name = [];
        }

        $week_date = Rotas::getWeekArray('Y-m-d', 0, 'monday');

        $logo = asset(Storage::url('uploads/logo/'));
        $settting = Utility::settings(0);
        $logo_path = $logo . '/' . $settting['company_logo'];

        $date = date('Y-m-d');
        $date_sts = 1;
        if( !empty($expiry_date) && $expiry_date < $date)
        {
            $date_sts = 0;            
            $msg = __('This link is expired.');
            return view('rotas.share_shift_table', compact('logo_path', 'msg', 'date_sts'));
        }


        if ($password_sts == 1) {            
            return view('rotas.share_shift_table', compact('logo_path', 'password_sts', 'slug', 'location', 'week_date','role_id', 'user_array', 'date_sts'));
        } else {
            $compact = ['logo_path', 'users_name', 'week_date', 'location', 'password_sts', 'role_id', 'user_array', 'date_sts'];
            return view('rotas.share_shift_table', compact($compact));
        }
    }

    public function slug_match(Request $request)
    {
        $confirm_password = $request->confirm_password;
        $slug = $request->slug;
        $decrypted_array = Crypt::decrypt($slug);

        if ($decrypted_array['share_password'] ==  $confirm_password) {
            $decrypted_array['password_sts'] = 0;
            $enc_url = Crypt::encrypt($decrypted_array);
            $return['status'] = 'success';
            $url = route("rotas.share", $enc_url);
            $return['url'] = $enc_url;
        } else {
            $return['status'] = 'error';
        }

        return response()->json($return);
    }

    public function rota_date_change(Request $request)
    {

        $s_date = $request->s_date;
        $e_date = $request->e_date;

        $week = $request->week * 7;
        $location_id = $request->location_id;
        $role_id = (!empty($request->role_id)) ? $request->role_id : 0;
        $user_array = $request->user_array;
        $week_date = Rotas::getWeekArray('Y-m-d', $week, 'monday');
        
        $customDates = Rotas::customDatesrange($s_date, $e_date, 'Y-m-d');
        // dd($week_date, $customDates);

        $th = '';

        foreach ($customDates as $date) {
            $th .= '<th>' . $date . '</th>';
        }


        $thead = '<thead><tr><th>' . __('Name') . '</th>' . $th . '</tr></thead>';

        if (!empty($user_array)) {
            $user_array = explode(',', $user_array);
            $tbody = '';
            $tr = '';
            if (!empty($user_array)) {
                foreach ($user_array as $key => $value) {
                    $tb = '';
                    foreach ($customDates as $date) {
                        $tb .= '<td>' . Rotas::getdaterotas($date, $value, $location_id, $role_id) . '</td>';
                    }
                    $user = User::find($value);
                    $tbody .= '
                        <tr>
                            <td>' . $user->first_name . '</td>'.$tb.'                            
                        </tr>';
                }
            } else {
                $tbody = '<tr> <td colspan="8"> <h2> <center> ' . __("No Data Found")  . '  </center> </h2> </td> </tr>';
            }
            $return['status'] = 1;
            $return['msg'] = $thead . $tbody;
            $return['date_title'] = $week_date[0] . ' - ' . $week_date[6];
        } else {
            $return['status'] = 0;
        }

        return response()->json($return);
    }

    public function hidedayoff(Request $request)
    {
        $day_off_sts = $request->hide_day_off;
        $userId = Auth::id();
        $user = Auth::user();

        $users = User::find($userId);
        if (!empty($users->employee_setting)) {
            $setting = json_decode($users->employee_setting, true);
            if (!empty($setting['day_off'])) {
                $setting['day_off'] = $day_off_sts;
                $users->employee_setting = json_encode($setting);
                $users->save();
            } else {
                $new_setting['day_off'] = $day_off_sts;
                $setting =  array_merge($new_setting, $setting);
                $users->employee_setting = json_encode($setting);
                $users->save();
            }
        } else {
            $setting['day_off'] = $day_off_sts;
            $users->employee_setting = json_encode($setting);
            $users->save();
        }

        return $users->employee_setting;
    }

    public function hideleave(Request $request)
    {
        $leave_display = $request->leave_display;
        $userId = Auth::id();
        $user = Auth::user();

        $users = User::find($userId);
        if (!empty($users->employee_setting)) {
            $setting = json_decode($users->employee_setting, true);
            if (!empty($setting['leave_display'])) {
                $setting['leave_display'] = $leave_display;
                $users->employee_setting = json_encode($setting);
                $users->save();
            } else {
                $new_setting['leave_display'] = $leave_display;
                $setting =  array_merge($new_setting, $setting);
                $users->employee_setting = json_encode($setting);
                $users->save();
            }
        } else {
            $setting['leave_display'] = $leave_display;
            $users->employee_setting = json_encode($setting);
            $users->save();
        }

        return $users->employee_setting;
    }

    public function hideavailability(Request $request)
    {
        $availability_display = $request->availability_display;
        $userId = Auth::id();
        $user = Auth::user();

        $users = User::find($userId);
        if (!empty($users->employee_setting)) {
            $setting = json_decode($users->employee_setting, true);
            if (!empty($setting['availability_display'])) {
                $setting['availability_display'] = $availability_display;
                $users->employee_setting = json_encode($setting);
                $users->save();
            } else {
                $new_setting['availability_display'] = $availability_display;
                $setting =  array_merge($new_setting, $setting);
                $users->employee_setting = json_encode($setting);
                $users->save();
            }
        } else {
            $setting['availability_display'] = $availability_display;
            $users->employee_setting = json_encode($setting);
            $users->save();
        }
        return $users->employee_setting;
    }
}
