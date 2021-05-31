<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employeesetting;
use App\Location;
use App\Profile;
use App\Settings;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;


use function GuzzleHttp\json_decode;

class EmployeesettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userId = Auth::user()->id;
        $user = Auth::user();
        $created_by = $user->get_created_by();

        $profile = Employee::whereRaw('is_delete = 0')->WhereRaw('id ='. $userId.'')->first();        
        $company_setting = [];
        $company_setting['company_currency_symbol_position'] = 'pre';
        if(!empty($profile->company_setting) && Auth::user()->type == 'company')
        {
            $setting = json_decode($profile->company_setting,true);            
            $company_setting['emp_show_rotas_price'] = (!empty($setting['emp_show_rotas_price'])) ? $setting['emp_show_rotas_price'] : 0 ;                
            $company_setting['emp_hide_rotas_hour']  = (!empty($setting['emp_hide_rotas_hour'])) ? $setting['emp_hide_rotas_hour'] : 0 ;                
            $company_setting['include_unpublished_shifts']  = (!empty($setting['include_unpublished_shifts'])) ? $setting['include_unpublished_shifts'] : 0 ;                
            $company_setting['emp_show_avatars_on_rota'] = (!empty($setting['emp_show_avatars_on_rota'])) ? $setting['emp_show_avatars_on_rota'] : 0 ;
            $company_setting['emp_only_see_own_rota'] = (!empty($setting['emp_only_see_own_rota'])) ? $setting['emp_only_see_own_rota'] : 0 ;
            $company_setting['emp_can_see_all_locations'] = (!empty($setting['emp_can_see_all_locations'])) ? $setting['emp_can_see_all_locations'] : 0 ;
            $company_setting['company_week_start'] = (!empty($setting['company_week_start'])) ? $setting['company_week_start'] : null ;
            $company_setting['company_time_format'] = (!empty($setting['company_time_format'])) ? $setting['company_time_format'] : null ;
            $company_setting['company_date_format'] = (!empty($setting['company_date_format'])) ? $setting['company_date_format'] : 'Y-m-d' ;
            $company_setting['company_currency_symbol'] = (!empty($setting['company_currency_symbol'])) ? $setting['company_currency_symbol'] : '$' ;
            $company_setting['company_currency_symbol_position'] = (!empty($setting['company_currency_symbol_position'])) ? $setting['company_currency_symbol_position'] : 'pre' ;
            $company_setting['leave_start_month'] = (!empty($setting['leave_start_month'])) ? $setting['leave_start_month'] : 1 ;                
            $company_setting['break_paid'] = (!empty($setting['break_paid'])) ? $setting['break_paid'] : 'paid' ;
            $company_setting['see_note'] = (!empty($setting['see_note'])) ? $setting['see_note'] : null ;
            $company_setting['enable_availability'] = (!empty($setting['enable_availability'])) ? $setting['enable_availability'] : 0 ;
            $company_setting['employees_can_set_availability'] = (!empty($setting['employees_can_set_availability'])) ? $setting['employees_can_set_availability'] : 0 ;
        }
        $settings = Utility::settings();
        return view('employeesetting.index',compact('profile','company_setting','settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employeesetting  $employeesetting
     * @return \Illuminate\Http\Response
     */
    public function show(Employeesetting $employeesetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employeesetting  $employeesetting
     * @return \Illuminate\Http\Response
     */
    public function edit(Employeesetting $employeesetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employeesetting  $employeesetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employeesetting $employeesetting, $id)
    {
        $user = Auth::user();
        $created_by = $user->get_created_by();
        
        $company_setting = Employee::find($id);
        if(Auth::user()->type == 'company')
        {
            if($request->form_type == 'rotas_setting')
            {
                $setting['emp_show_rotas_price'] = (!empty($request->emp_show_rotas_price)) ? $request->emp_show_rotas_price : 0 ;                  
                $setting['emp_hide_rotas_hour'] = (!empty($request->emp_hide_rotas_hour)) ? $request->emp_hide_rotas_hour : 0 ;                  
                $setting['include_unpublished_shifts'] = (!empty($request->include_unpublished_shifts)) ? $request->include_unpublished_shifts : 0 ;                  
                $setting['emp_show_avatars_on_rota'] = (!empty($request->emp_show_avatars_on_rota)) ? $request->emp_show_avatars_on_rota : 0 ;
                $setting['emp_only_see_own_rota'] = (!empty($request->emp_only_see_own_rota)) ? $request->emp_only_see_own_rota : 0 ;
                $setting['emp_can_see_all_locations'] = (!empty($request->emp_can_see_all_locations)) ? $request->emp_can_see_all_locations : 0 ;
                $setting['company_week_start'] = (!empty($request->company_week_start)) ? $request->company_week_start : '' ;
                $setting['company_time_format'] = (!empty($request->company_time_format)) ? $request->company_time_format : '' ;
                $setting['company_date_format'] = (!empty($request->company_date_format)) ? $request->company_date_format : 'Y-m-d' ;
                $setting['company_currency_symbol'] = (!empty($request->company_currency_symbol)) ? $request->company_currency_symbol : '$' ;
                $setting['company_currency_symbol_position'] = (!empty($request->company_currency_symbol_position)) ? $request->company_currency_symbol_position : 'pre' ;
                $setting['leave_start_month'] = (!empty($request->leave_start_month)) ? $request->leave_start_month : 01 ;
                $setting['break_paid'] = (!empty($request->break_paid)) ? $request->break_paid : 'paid' ;
                $setting['see_note'] = (!empty($request->see_note)) ? $request->see_note : '' ;                    
                $setting['employees_can_set_availability'] = (!empty($request->employees_can_set_availability)) ? $request->employees_can_set_availability : 0 ;                        
                
                if(!(empty($setting)))
                {
                    $company_setting->company_setting = json_encode($setting);
                }
                $company_setting->save();
            }

            $arrEnv = [
                'SITE_RTL' => !isset($request->SITE_RTL) ? 'off' : 'on',
            ];
            Utility::setEnvironmentValue($arrEnv);
            
            if($request->form_type == 'site_setting')
            {
                if(Auth::user()->type == 'company')
                {   
                    if(!empty($request->title_text) || !empty($request->footer_text) || !empty($request->default_language))
                    {
                        $post = $request->all();
                        unset($post['_token'], $post['logo'], $post['small_logo'], $post['favicon']);                    

                        if(!isset($request->display_landing_page))
                        {
                            $post['display_landing_page'] = 'off';
                        }


                        foreach($post as $key => $data)
                        {
                            \DB::insert('insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [$data,$key,$created_by,]);
                        }
                        if($request->logo)
                        {
                            echo 'if full logo';
                            $request->validate(['logo' => 'image|mimes:png|max:20480']);
                            $logoName = 'logo.png';
                            $path     = $request->file('logo')->storeAs('uploads/logo/', $logoName);
                            \DB::insert('insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [$logoName,'logo',$created_by,]);
                        }
                        if($request->favicon)
                        {
                            echo 'if favicon';
                            $request->validate(['favicon' => 'image|mimes:png|max:20480',]);                        
                            $favicon = 'favicon.png';
                            $path    = $request->file('favicon')->storeAs('uploads/logo/', $favicon);
                            \DB::insert('insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [$favicon,'favicon',$created_by,]);
                        }
                    }
                }
            }  
            return redirect()->back()->with('success', __('Setting Update Successfully'));
        }
        else
        {
            return redirect()->back()->with('Error', __('Permission denied'));
        } 
        
    }

    
    public function saveEmailSettings(Request $request, Employeesetting $employeesetting)
    {
        if(\Auth::user()->type == 'company')
        {
            $request->validate(
                [
                    'mail_driver' => 'required|string|max:50',
                    'mail_host' => 'required|string|max:50',
                    'mail_port' => 'required|string|max:50',
                    'mail_username' => 'required|string|max:50',
                    'mail_password' => 'required|string|max:50',
                    'mail_encryption' => 'required|string|max:50',
                    'mail_from_address' => 'required|string|max:50',
                    'mail_from_name' => 'required|string|max:50',
                ]
            );
            $arrEnv = [
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_NAME' => $request->mail_from_name,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            ];
            Utility::setEnvironmentValue($arrEnv);
            return redirect()->back()->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employeesetting  $employeesetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employeesetting $employeesetting)
    {
        //
    }

    public function testMail()
    {
        return view('employeesetting.test_mail');
    }

    public function testSendMail(Request $request)
    {
        if(\Auth::user()->type == 'company')
        {
            
            if(!empty($request->email))
            {            
                try
                {                    
                    Mail::to($request->email)->send(new TestMail());
                }
                catch(\Exception $e)
                {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }
            }
            return redirect()->back()->with('success', __('Email send Successfully.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
