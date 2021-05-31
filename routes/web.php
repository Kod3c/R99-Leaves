<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/register/{lang?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('/login/{lang?}', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/reset/password/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('password.request');


Route::get('/', ['as' => 'home','uses' => 'HomeController@index'])->middleware(['XSS']);

Route::resource('/home', 'HomeController')->middleware(['auth','XSS']);
Route::post('/dashboard/location_filter', ['as' => 'dashboard.location_filter','uses' => 'HomeController@location_filter'])->middleware(['auth','XSS']);
Route::resource('/dashboard', 'HomeController')->middleware(['auth','XSS']);
Route::post('dayview_filter', 'DailyViewController@dayview_filter')->name('dayview_filter')->middleware(['XSS']);
Route::resource('/day', 'DailyViewController')->middleware(['auth','XSS']);
Route::post('userviewfilter', 'UserViewController@userviewfilter')->name('userviewfilter')->middleware(['XSS']);
Route::resource('/user-view', 'UserViewController')->middleware(['auth','XSS']);

Route::post('hideavailability', 'RotasController@hideavailability')->name('hideavailability')->middleware(['auth','XSS']);
Route::post('hideleave', 'RotasController@hideleave')->name('hideleave')->middleware(['auth','XSS']);
Route::post('hidedayoff', 'RotasController@hidedayoff')->name('hidedayoff')->middleware(['auth','XSS']);
Route::post('rotas/print', 'RotasController@printrotasInvoice')->name('rotas.print')->middleware(['XSS']);
Route::post('/rota-date-change', ['as' => 'rota.date.change','uses' => 'RotasController@rota_date_change'])->middleware(['XSS']);
Route::post('/slug-match', ['as' => 'slug.match','uses' => 'RotasController@slug_match'])->middleware(['XSS']);
Route::get('/rotas/share/{slug}', ['as' => 'rotas.share','uses' => 'RotasController@share_rotas'])->middleware(['XSS']);
Route::post('/rotas/share_rotas_link', ['as' => 'rotas.share_rotas_link','uses' => 'RotasController@share_rotas_link'])->middleware(['auth','XSS']);
Route::get('/rotas/share_rotas_popup', ['as' => 'rotas.share_popup','uses' => 'RotasController@share_rotas_popup'])->middleware(['auth','XSS']);
Route::post('/rotas/shift_disable_reply', ['as' => 'rotas.shift.disable.reply','uses' => 'RotasController@shift_disable_reply'])->middleware(['auth','XSS']);
Route::get('/rotas/shift_disable_response/{id}', ['as' => 'rotas.shift.response','uses' => 'RotasController@shift_disable_response'])->middleware(['auth','XSS']);
Route::post('/rotas/shift_disable', ['as' => 'rotas.shift.disable','uses' => 'RotasController@shift_disable'])->middleware(['auth','XSS']);
Route::get('/rotas/shift_cancel/{id}', ['as' => 'rotas.shift.cancel','uses' => 'RotasController@shift_cancel'])->middleware(['auth','XSS']);
Route::get('/rotas/print_rotas_popup', ['as' => 'rotas.print_rotas_popup','uses' => 'RotasController@print_rotas_popup'])->middleware(['auth','XSS']);

Route::post('/rotas/send_email_rotas', ['as' => 'rotas.send_email_rotas','uses' => 'RotasController@send_email_rotas'])->middleware(['auth','XSS']);
Route::get('/rotas/add_remove_employee', ['as' => 'rotas.add_remove_employee','uses' => 'RotasController@add_remove_employee'])->middleware(['auth','XSS']);
Route::get('/rotas/add_remove_employee_popup', ['as' => 'rotas.add_remove_employee_popup','uses' => 'RotasController@add_remove_employee_popup'])->middleware(['auth','XSS']);
Route::post('/rotas/add_dayoff', ['as' => 'rotas.add_dayoff','uses' => 'RotasController@add_dayoff'])->middleware(['auth','XSS']);
Route::post('/rotas/shift_copy', ['as' => 'rotas.shift_copy','uses' => 'RotasController@shift_copy'])->middleware(['auth','XSS']);
Route::post('/rotas/publish_week', ['as' => 'rotas.publish_week','uses' => 'RotasController@publish_week'])->middleware(['auth','XSS']);
Route::post('/rotas/un_publish_week', ['as' => 'rotas.un_publish_week','uses' => 'RotasController@un_publish_week'])->middleware(['auth','XSS']);
Route::post('/rotas/clear_week', ['as' => 'rotas.clear_week','uses' => 'RotasController@clear_week'])->middleware(['auth','XSS']);
Route::post('/rotas/week_sheet', ['as' => 'rotas.week_sheet','uses' => 'RotasController@week_sheet'])->middleware(['auth','XSS']);
Route::resource('/rotas', 'RotasController')->middleware(['auth','XSS']);

Route::post('/change-password', 'ProfileController@updatePassword')->name('update.password');
Route::get('/profile/{id?}', ['as' => 'profile','uses' => 'ProfileController@index'])->middleware(['auth','XSS']);
Route::resource('/profile', 'ProfileController')->middleware(['auth','XSS']);

Route::post('/employee/addpassword/{id}', ['as' => 'employee.addpassword','uses' => 'EmployeeController@addpassword'])->middleware(['auth','XSS']);
Route::get('/employee/set_password/{id}', ['as' => 'employee.set_password','uses' => 'EmployeeController@set_password'])->middleware(['auth','XSS']);
Route::get('/employee/manage_permission/{id}', ['as' => 'employee.manage_permission','uses' => 'EmployeeController@manage_permission'])->middleware(['auth','XSS']);
Route::post('employee/restore/{id}', ['as' => 'employee.restore','uses' => 'EmployeeController@restore'])->middleware(['auth','XSS']);
Route::post('employee/send-invitation/{id}', ['as' => 'employee.send_invitation','uses' => 'EmployeeController@send_invitation'])->middleware(['auth','XSS']);
Route::resource('/employees', 'EmployeeController')->middleware(['auth','XSS']);

Route::get('/change/mode',['as' => 'change.mode','uses' =>'EmployeeController@changeMode']);

Route::resource('/locations', 'LocationController')->middleware(['auth','XSS']);

Route::resource('/roles', 'RoleController')->middleware(['auth','XSS']);

Route::resource('/past-employees', 'PastemployeesController')->middleware(['auth','XSS']);

Route::resource('/groups', 'GroupController')->middleware(['auth','XSS']);

Route::get('/holidays/annual-leave/{id}', ['as' => 'holidays.annual_leave','uses' => 'LeaveController@annual_leave'])->middleware(['auth','XSS']);
Route::get('/holidays/view-leave-response/{id}', ['as' => 'holidays.view-leave-response','uses' => 'LeaveController@view_leave_response'])->middleware(['auth','XSS']);
Route::get('/holidays/view-leave/{id}', ['as' => 'holidays.view_leave','uses' => 'LeaveController@view_leave'])->middleware(['auth','XSS']);
Route::post('/holidays/annual-leave-response/{id}', ['as' => 'holidays.annual-leave-response','uses' => 'LeaveController@annual_leave_response'])->middleware(['auth','XSS']);
Route::post('/holidays/leave_sheet', ['as' => 'holidays.leave_sheet','uses' => 'LeaveController@leave_sheet'])->middleware(['auth','XSS']);
Route::resource('/holidays', 'LeaveController')->middleware(['auth','XSS']);

Route::resource('/embargoes', 'EmbargoController')->middleware(['auth','XSS']);

Route::resource('/rules', 'RulesController')->middleware(['auth','XSS']);

Route::get('/leave-request/reply/{id}', ['as' => 'leave-request.reply','uses' => 'LeaveRequestController@reply'])->middleware(['auth','XSS']);
Route::post('/leave-request/response/{id}', ['as' => 'leave-request.response','uses' => 'LeaveRequestController@reply_response'])->middleware(['auth','XSS']);
Route::post('/leave-request/response-delete/{id}', ['as' => 'leave-request.response-delete','uses' => 'LeaveRequestController@response_delete'])->middleware(['auth','XSS']);
Route::resource('/leave-request', 'LeaveRequestController')->middleware(['auth','XSS']);

Route::get('/reports/{id?}', ['as' => 'reports','uses' => 'ReportController@index'])->middleware(['auth','XSS']);
Route::resource('/reports', 'ReportController')->middleware(['auth','XSS']);

Route::resource('/availabilities', 'AvailabilityController')->middleware(['auth','XSS']);

Route::post('email-setting', 'EmployeesettingController@saveEmailSettings')->name('email.setting');
Route::get('test-mail', 'EmployeesettingController@testMail')->name('test.mail');
Route::post('test-mail', 'EmployeesettingController@testSendMail')->name('test.send.mail');

Route::get('/leave-request/reply/{id}', ['as' => 'leave-request.reply','uses' => 'LeaveRequestController@reply'])->middleware(['auth','XSS']);
Route::get('/setting/saveBusinessSettings', ['as' => 'setting.saveBusinessSettings','EmployeesettingController@saveBusinessSettings'])->middleware(['auth','XSS']);
Route::resource('/setting', 'EmployeesettingController')->middleware(['auth','XSS']);

Route::group([ 'middleware' => ['auth','XSS',], ], function () {
    Route::get('change-language/{lang}', 'LanguageController@changeLanguage')->name('change.language');
    Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language');
    Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data');
    Route::get('create-language', 'LanguageController@createLanguage')->name('create.language');
    Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language');
    Route::delete('lang/{lang}',['as' => 'lang.destroy','uses' =>'LanguageController@destroyLang']);
});