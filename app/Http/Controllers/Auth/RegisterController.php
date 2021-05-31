<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Profile;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Utility;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stripe\Plan;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([            
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company_name' => $data['company_name'],
            'type' => 'company',
            'email' => $data['email'],
            'acount_type' => 1,
            'created_by' => 0,
            'password' => Hash::make($data['password']),
            'company_setting' => '{"emp_show_rotas_price":"1","emp_show_avatars_on_rota":0,"emp_only_see_own_rota":0,"emp_can_see_all_locations":0,"company_week_start":"monday","company_time_format":"12","company_date_format":"","company_currency_symbol":"$","company_currency_symbol_position":"pre","see_note":"none","employees_can_set_availability":"1"}',
        ]);            
        $insert_id = $user->id;
        
        $profile = new Profile();        
        $profile->user_id = $insert_id;
        $profile->save();
        return $user;
    }

    public function showRegistrationForm($lang = '')
    {
        if ($lang == '') {
            $settings = Utility::settings();
            $lang = $settings['default_user_language'];
        }

        \App::setLocale($lang);

        return view('auth.register', compact('lang'));
    }
}
