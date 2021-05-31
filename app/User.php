<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'company_name',
        'type',
        'email',
        'email_verified_at',
        'password',
        'issue_by',
        'created_by',
        'acount_type',
        'manager_permission',
        'company_detail',
        'company_setting',
        'lang',
        'mode',
        'is_delete',
        'deleted_at',
        'deleted_by',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function currentLanguage()
    {
        return $this->lang;
    }
    public function get_created_by()
    {
        if (Auth::user()->type == 'company')
        {
            return Auth::user()->id;
        } else {
            return Auth::user()->created_by;
        }
    }

    public function getUserInfo()
    {
        return $this->hasOne('App\Profile','user_id','id');
    }

    public function getAddEmployeePermission()
    {
        $permission_add_employee = 0;
        if(Auth::user()->acount_type == 2 && !empty(Auth::user()->manager_permission))
        {
            $manager_permission = json_decode(Auth::user()->manager_permission,true);
            if(!empty($manager_permission))
            {
                $permission_add_employee = (!empty($manager_permission['manager_add_employees_and_manage_basic_information'])) ? 1 : 0;
            }
        }
        return $permission_add_employee;
    }

    public function getAddRolePermission()
    {
        $permission_add_role = 0;
        if(Auth::user()->acount_type == 2 && !empty(Auth::user()->manager_permission))
        {
            $manager_permission = json_decode(Auth::user()->manager_permission,true);
            if(!empty($manager_permission))
            {
                $permission_add_role = (!empty($manager_permission['manager_manage_roles'])) ? 1 : 0;
            }
        }
        return $permission_add_role;
    }

    public function getviewRepotsPermission()
    {
        $permission_view_reports = 0;
        if(Auth::user()->acount_type == 2 && !empty(Auth::user()->manager_permission))
        {
            $manager_permission = json_decode(Auth::user()->manager_permission,true);
            if(!empty($manager_permission))
            {
                $permission_view_reports = (!empty($manager_permission['manager_view_reports'])) ? 1 : 0;
            }
        }
        return $permission_view_reports;
    }

    public function getViewAvailabilities()
    {
        $user = Auth::user();
        $created_by = $user->get_created_by();
        $employee_data = Employee::whereRaw('id = '.$created_by.' ')->first();
        $viewavailabilities = 'd-none';
        if(!empty($employee_data->company_setting))
        {
            $setting = json_decode($employee_data->company_setting,true);            
            if(Auth::user()->acount_type == 1 || Auth::user()->acount_type == 2) { $viewavailabilities = 1; }
            if(Auth::user()->acount_type == 3 && !empty($setting) && $setting['employees_can_set_availability'] == 1)
            {            
                $viewavailabilities = 1;
            }
        }
        return $viewavailabilities;
    }

    public static function priceFormat($price = 0)
    {
        $user = Auth::user();
        $created_by = $user->get_created_by();
        $price = round($price,2);
        $value = '$ '.$price;
        $company_setting_data = User::Where('id',$created_by)->first();
        if(!(empty($company_setting_data->company_setting)))
        {
            $company_setting_array = json_decode($company_setting_data->company_setting,true);
            $currency_symbol = (!empty($company_setting_array['company_currency_symbol'])) ? $company_setting_array['company_currency_symbol'] : '$' ;
            $position = (!empty($company_setting_array['company_currency_symbol_position'])) ? $company_setting_array['company_currency_symbol_position'] : 'pre' ;

            if($position == 'post')            {
                $value = $price.' '.$currency_symbol;
            } else {
                $value = ' '.$currency_symbol.' '.$price;                
            }            
        }
        return $value;
    }

    public static function CompanycurrencySymbol()
    {
        $user = Auth::user();
        $created_by = $user->get_created_by();
        
        $value = '$';
        $company_setting_data = User::Where('id',$created_by)->first();
        if(!(empty($company_setting_data->company_setting)))
        {
            $company_setting_array = json_decode($company_setting_data->company_setting,true);
            $value = (!empty($company_setting_array['company_currency_symbol'])) ? $company_setting_array['company_currency_symbol'] : '$' ;
        }
        return $value;
    }
    
    public static function CompanyTimeFormat($time = '')
    {
        $user = Auth::user();
        $created_by = $user->get_created_by();

        $return = $time;
        $setting = User::Where('id',$created_by)->first();
        if(!(empty($setting->company_setting)))
        {
            $company_setting_array = json_decode($setting->company_setting,true);
            $time_format = (!empty($company_setting_array['company_time_format'])) ? $company_setting_array['company_time_format'] : '' ;
            if(!empty($time_format))            
            {
                if($time_format == 12)
                {
                    $return = date('h:i a', strtotime($time));
                }
                if($time_format == 24) 
                {
                    $return = date('H:i', strtotime($time));
                }
            }
        }
        return $return;
    }
    public static function CompanyDateFormat($default = 'Y-m-d')
    {
        $user = Auth::user();
        $created_by = $user->get_created_by();
        
        $value = (!empty($default)) ? $default : 'Y-m-d' ;
        $company_setting_data = User::Where('id',$created_by)->first();
        if(!(empty($company_setting_data->company_setting)))
        {
            $company_setting_array = json_decode($company_setting_data->company_setting,true);
            $value = (!empty($company_setting_array['company_date_format'])) ? $company_setting_array['company_date_format'] : $value ;
        }
        return $value;
    }

    public static function managerpermission()
    {
        $user = Auth::user();  
        $created_by = $user->get_created_by();
        $permission = Auth::user()->manager_permission;
        $manager_option = [];        
        if(!empty($permission) && Auth::user()->acount_type == 2)
        {            
            $manager_permission_array = json_decode($permission,true);                            
            if(!empty($manager_permission_array['manage_loaction']))
            {
                $manage_location = explode(',',$manager_permission_array['manage_loaction']);
                $manager_option['manager_location'] = $manage_location;
                foreach($manage_location as $manage_location_data)
                {
                    $manage_location_select[$manage_location_data] = true;
                }
            }
            $manager_option['manager_add_edit_delete_rotas'] = (!empty($manager_permission_array['manager_add_edit_delete_rotas'])) ? true : false;
            $manager_option['manager_manage_leave_and_approve_leave_requests_for_other'] = (!empty($manager_permission_array['manager_manage_leave_and_approve_leave_requests_for_other'])) ? true : false;            
            $manager_option['manager_manually_add_leave_to_themselves'] = (!empty($manager_permission_array['manager_manually_add_leave_to_themselves'])) ? true : false;            
            $manager_option['manager_manage_leave_embargoes'] = (!empty($manager_permission_array['manager_manage_leave_embargoes'])) ? true : false;            
            $manager_option['manager_add_employees_and_manage_basic_information'] = (!empty($manager_permission_array['manager_add_employees_and_manage_basic_information'])) ? true : false;            
            $manager_option['manager_view_and_edit_employee_salary'] = (!empty($manager_permission_array['manager_view_and_edit_employee_salary'])) ? true : false;            
            $manager_option['manager_manage_roles'] = (!empty($manager_permission_array['manager_manage_roles'])) ? true : false;            
            $manager_option['manager_view_reports'] = (!empty($manager_permission_array['manager_view_reports'])) ? true : false;
        }
        return $manager_option;
    }

    public static function companystaticSetting()
    {
        $user = Auth::user();
        $created_by = $user->get_created_by();

        $employee_data = Employee::whereRaw('id = '.$created_by.' ')->first();
        $setting = [];
        if(!empty($employee_data->company_setting))
        {
            $setting = json_decode($employee_data->company_setting,true);
        }

        return $setting;
    }

    public static function manger_employee($userId)
    {
        $id = $userId;        
        $emp = 0;
        $where = [];
        $where_str = '0 = 0';
        if(!empty(Auth::user()->manager_permission))
        {
            $permission_array = json_decode(Auth::user()->manager_permission, true);
            if(!empty($permission_array) && !empty($permission_array['manage_loaction']))
            {
                $location_id = explode(',', $permission_array['manage_loaction']);
                if(!empty($location_id))
                {
                    foreach ($location_id as $key => $value) {
                        $where[] = 'FIND_IN_SET("'.$value.'", location_id)';
                    }
                    
                    if(!empty($where))
                    {
                        $where_str = implode(' OR ',$where);
                    }                    
                }
            }
        }

        return  Profile::whereRaw($where_str)->pluck('user_id')->toArray();
    }
}
