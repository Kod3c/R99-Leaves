@extends('layouts.main')
@section('page-title')
    {{ __('Profile') }}
@endsection
@section('content')
    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                    <!-- Page title + Go Back button -->
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{ __('Account settings') }}</h5>
                    </div>
                </div>                
            </div>
        </div>
        <!-- Listing -->
        <div class="row">
            <div class="col-lg-4 order-lg-2">
                <div class="card">
                    <div class="list-group list-group-flush profile_menu11" id="tabs">
                        <div data-href="#tabs-1" class="list-group-item text-primary">
                            <div class="media">
                                <i class="fas fa-user"></i>
                                <div class="media-body ml-3">
                                    <a href="#" class="stretched-link h6 mb-1">{{ __('Basic') }}</a>
                                    <p class="mb-0 text-sm">{{ __('Details about your Employee & Personal information') }}</p>
                                </div>
                            </div>
                        </div>
                        @if($userr->acount_type == 1)
                        <div data-href="#tabs-8" class="list-group-item">
                            <div class="media">
                                <i class="far fa-building"></i>
                                <div class="media-body ml-3">
                                    <a href="#" class="stretched-link h6 mb-1">{{ __('Company Details') }}</a>
                                    <p class="mb-0 text-sm">{{ __('Details about your Company information') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif                        
                        @if(!empty($userr->password))
                        <div data-href="#tabs-7" class="list-group-item">
                            <div class="media">
                                <i class="fas fa-user-lock"></i>
                                <div class="media-body ml-3">
                                    <a href="#" class="stretched-link h6 mb-1">{{ __('Password') }}</a>
                                    <p class="mb-0 text-sm">{{ __('Change Password') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(Auth::user()->acount_type == 1 || !(empty($manager_option['manager_add_employees_and_manage_basic_information'])))
                        <div data-href="#tabs-2" class="list-group-item">
                            <div class="media">
                                <i class="fas fa-globe"></i>
                                <div class="media-body ml-3">
                                    <a href="#" class="stretched-link h6 mb-1">{{ __('Location') }}</a>
                                    <p class="mb-0 text-sm">{{ __('Details about your Location information') }}</p>
                                </div>
                            </div>
                        </div>
                        <div data-href="#tabs-3" class="list-group-item">
                            <div class="media">
                                <i class="fas fa-tags"></i>
                                <div class="media-body ml-3">
                                    <a href="#" class="stretched-link h6 mb-1">{{ __('Roles') }}</a>
                                    <p class="mb-0 text-sm">{{ __('Details about your Roles information') }}</p>
                                </div>
                            </div>
                        </div>
                        <div data-href="#tabs-4" class="list-group-item {{ $manager_option['wage_salary_display'] }}">
                            <div class="media">
                                <i class="fas fa-money-bill-alt"></i>
                                <div class="media-body ml-3">
                                    <a href="#" class="stretched-link h6 mb-1">{{ __('Wage & Salary') }}</a>
                                    <p class="mb-0 text-sm">{{ __('Details about your Wage & Salary') }}</p>
                                </div>
                            </div>
                        </div>
                        <div data-href="#tabs-5" class="list-group-item">
                            <div class="media">
                                <i class="fas fa-calendar-times"></i>
                                <div class="media-body ml-3">
                                    <a href="#" class="stretched-link h6 mb-1">{{ __('Work Schedule') }}</a>
                                    <p class="mb-0 text-sm">{{ __('Details about your Work Schedule') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-8 order-lg-1">
                <div class="card bg-gradient-warning hover-shadow-lg border-0">
                    <div class="card-body py-3">
                        <div class="row row-grid align-items-center">
                            <div class="col-lg-8">
                                <div class="media align-items-center">
                                    <a href="#" class="avatar avatar-lg rounded-circle mr-3">
                                        <img class="avatar avatar-lg" id="blah" src="{{ asset(Storage::url($profile->DefaultProfilePic())) }}">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="text-white mb-0">
                                            {{ $profile->getUserName->first_name }}
                                            {{ $profile->getUserName->last_name }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs-1" class="tabs-card">
                    <div class="card">
                        @if(Auth::user()->acount_type == 1 || Auth::user()->acount_type == 2)
                        <ul class="nav nav-tabs nav-overflow profile-tab-list" role="tablist">
                            <li class="nav-item ml-4">
                                <a href="#personal" id="orders-tab" class="nav-link active" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                                    <i class="fas fa-user mr-2"></i>{{ __('Personal Detail') }}
                                </a>
                            </li>
                            <li class="nav-item ml-4">
                                <a href="#employee" id="plans-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                                    <i class="fas fa-briefcase mr-2"></i>{{ __('Employee Detail') }}
                                </a>
                            </li>
                        </ul>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="card-body">
                                    {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"personal_information", 'enctype' => 'multipart/form-data' ]) }}
                                        <div class="row">
                                            {{ Form::hidden('employee_id', $profile->user_id) }}
                                            {{ Form::hidden('form_type', 'personal') }}
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('First Name'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('first_name', $profile->getUserName->first_name, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Middle Name'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('middle_name', $profile->getUserName->middle_name, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Last Name'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('last_name', $profile->getUserName->last_name, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Gender'), ['class' => 'form-control-label']) }}
                                                    {!! Form::select('gender', ['male' => 'Male', 'female' => 'Female'], $profile->gender, ['data-placeholder'=> 'Select Gender' ,'class'=> 'form-control js-single-select']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Date of Birth'), ['class' => 'form-control-label']) }}
                                                    {{ Form::date('date_of_birth', $profile->date_of_birth, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Profile Image'), ['class' => 'form-control-label']) }}
                                                    <div>
                                                        <input type="file" name="profile_pic" id="imgInp" class="custom-input-file"/>
                                                        <label for="imgInp">
                                                            <i class="fa fa-upload"></i>
                                                            <span>{{ __('Choose a file…') }}</span>
                                                        </label>
                                                        @if ($errors->has('profile_pic'))
                                                            <span class="help-block text-danger fs-12">
                                                                <strong>{{ $errors->first('profile_pic') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="card-header w-100 p-0 mb-3"><h5 class="h6 mb-4">{{__('Emergency Contact')}}</h5></div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Emergency Contact Name'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('emergency_contact_name', $profile->emergency_contact_name, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Emergency Contact Phone Number'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('emergency_contact_no', $profile->emergency_contact_no, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Relationship to Employee'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('relationship_to_employee', $profile->relationship_to_employee, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="card-header w-100 p-0 mb-3"><h5 class="h6 mb-4">{{__('Contact Details')}}</h5></div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Address'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('address', $profile->address, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('City'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('city', $profile->city, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Country'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('county', $profile->city, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Postcode'), ['class' => 'form-control-label']) }}
                                                    {{ Form::number('postcode', $profile->postcode, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Email Address'), ['class' => 'form-control-label']) }}
                                                    {{ Form::text('email', $profile->getUserName->email, array('class'=>'form-control')) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Phone Number'), ['class' => 'form-control-label']) }}
                                                    {{ Form::number('phone', $profile->phone, ['class' => 'form-control'] ) }}
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-right">
                                            <input name="from" type="hidden" value="password">
                                            <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save')}}</button>
                                        </div>

                                    {{ Form::close() }}
                                </div>                                
                            </div>
                            <div class="tab-pane fade show " id="employee" role="tabpanel" aria-labelledby="plans-tab">                                
                                <div class="card-body">
                                    {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"employee_information" ]) }}
                                        {{ Form::hidden('employee_id', $profile->user_id) }}
                                        {{ Form::hidden('form_type', 'employee') }}
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Weekly Hours'), ['class' => 'form-control-label']) }}
                                                    {{ Form::number('weekly_hour', $profile->weekly_hour, ['class' => 'form-control','placeholder' => '0'] ) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Annual Holiday Allowance'), ['class' => 'form-control-label']) }}
                                                    <div class="row">
                                                        <div class="col-sm-7 ">
                                                            {{ Form::number('annual_holiday[time]', $profile->getAnnualHolidayTime(), ['class' => 'form-control','placeholder' => '0'] ) }}
                                                        </div>
                                                        <div class="col-sm-5">
                                                            {!! Form::select('annual_holiday[type]', ['day' => 'Day'], $profile->getAnnualHolidayTimeType(), ['class'=> 'form-control js-single-select']) !!}
                                                        </div>
                                                    </div>
                                                    <span class="clearfix"> </span>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Start Date'), ['class' => 'form-control-label']) }}
                                                    {{ Form::date('start_date', $profile->start_date, ['class' => 'form-control']) }}

                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Final Working Date'), ['class' => 'form-control-label']) }}
                                                    {{ Form::date('final_working_date', $profile->final_working_date, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Employment Type'), ['class' => 'form-control-label']) }}
                                                    {!! Form::select('employee_type', ["fulltime"=>"Full Time", "parttime"=>"Part Time", "fixedterm"=>"Fixed Term", "casual"=>"Casual", "apprentice_trainee"=>"Apprentice/Trainee", "agency"=>"Agency", "contractor_freelancer"=>"Contractor/Freelancer" , "temporary"=>"Temporary"] , $profile->employee_type, ['data-placeholder'=> 'Select Employee Type' ,'class'=> 'form-control js-single-select']) !!}
                                                </div>
                                            </div>
                                            @if(Auth::user()->acount_type == 2 || Auth::user()->acount_type == 1)
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('', __('Notes'), ['class' => 'form-control-label']) }}
                                                    {{ Form::textarea('note', $profile->note, ['class' => 'form-control autogrow' ,'rows'=>'3' ,'style'=>'resize: none']) }}                                                        
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                        </div>
                                    {{ Form::close() }}
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs-8" class="tabs-card  d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" h6 mb-0">{{ __('Company Details') }}</h5>
                        </div>
                        <div class="card-body">
                            {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"company_information" ]) }}
                                {{ Form::hidden('employee_id', $profile->user_id) }}
                                {{ Form::hidden('form_type', 'company_info') }}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', __('Comapany Name'), ['class' => 'form-control-label']) }}
                                            {{ Form::text('company_name', (!empty($userr->company_name)) ? $userr->company_name : null , ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', __('Company owner'), ['class' => 'form-control-label']) }}
                                            {!! Form::select('comapany_owner', ["you"=>"You"] , 'you', ['class'=> 'form-control']) !!}
                                        </div>
                                    </div>                                    
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', __('Company Telephone Number'), ['class' => 'form-control-label']) }}
                                            {!! Form::number('company_telephone_number', (!empty($company_detail['company_telephone_number'])) ? $company_detail['company_telephone_number'] : null, ['class'=> 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', __('Postcode'), ['class' => 'form-control-label']) }}
                                            {!! Form::text('company_postcode', (!empty($company_detail['company_postcode'])) ? $company_detail['company_postcode'] : null, ['class'=> 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('', __('Address'), ['class' => 'form-control-label']) }}
                                            {!! Form::text('comapany_address', (!empty($company_detail['comapany_address'])) ? $company_detail['comapany_address'] : null, ['class'=> 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', __('City'), ['class' => 'form-control-label']) }}
                                            {!! Form::text('company_city', (!empty($company_detail['company_city'])) ? $company_detail['company_city'] : null, ['class'=> 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('', __('Country'), ['class' => 'form-control-label']) }}
                                            {!! Form::text('comapany_county', (!empty($company_detail['comapany_county'])) ? $company_detail['comapany_county'] : null, ['class'=> 'form-control']) !!}
                                        </div>
                                    </div>                                    
                                </div>
                                <hr>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div id="tabs-2" class="tabs-card d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" h6 mb-0">{{ __('Location Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"loaction_information" ]) }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('', __('Set Location'), ['class' => 'form-control-label']) }}
                                        {!! Form::select('location_id[]', $all_location_option, $profile->location_id, ['required' => false, 'multiple' => 'multiple', 'data-placeholder'=> 'Select a Location' ,'class'=> 'form-control js-multiple-select']) !!}

                                        {{ Form::hidden('employee_id', $profile->user_id) }}
                                        {{ Form::hidden('form_type', 'loaction') }}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div id="tabs-3" class="tabs-card d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h6 mb-0">{{ __('Role Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"role_information" ]) }}
                                {{ Form::hidden('employee_id', $profile->user_id) }}
                                {{ Form::hidden('form_type', 'role') }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('', __('Set Role'), ['class' => 'form-control-label']) }}
                                            {!! Form::select('role_id[]', $role_options, $profile->role_id, ['required' => false, 'multiple' => 'multiple', 'data-placeholder'=> 'Select a Role' ,'class'=> 'form-control js-multiple-select']) !!}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                </div>
                                {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div id="tabs-4" class="tabs-card d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" h6 mb-0">{{ __('Salary Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"salary_information" ]) }}
                                {{ Form::hidden('employee_id', $profile->user_id) }}
                                {{ Form::hidden('form_type', 'salary') }}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"> {{ __('Default Wage / Salary') }} </label>
                                            <span class="clearfix"> </span>
                                            <div class="col-sm-5 col-md-5 float-left px-2">                                                
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            {{ \App\User::CompanycurrencySymbol() }}
                                                        </span>
                                                    </div>
                                                    {{ Form::number('default_salary[salary]', (!empty($profile->CustomDefaultSalary()['salary'])) ? $profile->CustomDefaultSalary()['salary']: null , ['class' => 'form-control'] ) }}                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-7 col-md-7 float-left px-2">
                                                {!! Form::select('default_salary[salary_per]', ['hourly' => 'Per Hour'], (!empty($profile->CustomDefaultSalary()['salary_per'])) ? $profile->CustomDefaultSalary()['salary_per']: null, ['class'=> 'form-control js-single-select']) !!}
                                            </div>
                                            <span class="clearfix"> </span>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="card-header w-100 p-0 mb-3">
                                    <h5 class="h6 mb-4">
                                        <span data-toggle="tooltip" title="Pay codes are used by payroll systems to identify which pay rate should be applied to a number of hours worked. Apply a pay code to a custom role rate and any hours worked by this employee will be labelled with this pay code.">
                                            {{  __('Custom Role Rates') }}
                                        </span>
                                    </h5>
                                </div>
                                <div class="row">
                                    @if (!empty($profile->role_id))
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            @foreach ($custom_role_rates as $key => $custom_role_rate)
                                                <div class="form-group" data_id="{{ $key }}">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <span class="float-left lh-50">{{ $custom_role_rate }} </span>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        {{ \App\User::CompanycurrencySymbol() }}
                                                                    </span>
                                                                </div>
                                                                {{ Form::number('salary['.$key.'][custom_salary_by_hour]', (!empty($salary_data[$key]['custom_salary_by_hour'])) ? $salary_data[$key]['custom_salary_by_hour'] : null , ['class' => 'form-control'] ) }}                                                                
                                                            </div>
                                                        </div>                                                        
                                                        <div class="col-2 text-left"> <span class="lh-50"> &nbsp; {{ __('Per Hour') }} </span>
                                                        </div>                                                    
                                                        <div class="col-3">
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        {{ \App\User::CompanycurrencySymbol() }}
                                                                    </span>
                                                                </div>
                                                                {{ Form::number('salary['.$key.'][custom_salary_by_shift]', (!empty($salary_data[$key]['custom_salary_by_shift'])) ? $salary_data[$key]['custom_salary_by_shift'] : null, ['class' => 'form-control'] ) }}                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-2"> <span class="lh-50"> &nbsp; {{ __('Per Shift') }} </span> </div>
                                                    </div>
                                                    <span class="clearfix"></span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="col-xs-12 col-sm-12 col-md-12"> {{ $custom_role_rates }}</div>
                                    @endif
                                </div>
                                <hr>
                                <div class="text-right">
                                    <input name="from" type="hidden" value="password">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                </div>
                                {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div id="tabs-5" class="tabs-card d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" h6 mb-0">{{ __('Work Schedule') }}</h5>
                        </div>
                        <div class="card-body">
                            <small>
                                {{ __("Use the work schedule to set your employee's regular days off. They will then display on the rota accordingly. Changes to work schedules will apply from the current day forwards.") }}
                            </small>
                            <br><br>
                            {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"work_table_information" ]) }}
                                {{ Form::hidden('employee_id', $profile->user_id) }}
                                {{ Form::hidden('form_type', 'work_table') }}
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', __('Monday'), ['class' => 'form-control-label']) }}
                                            {!! Form::select('work_schedule[monday]', ['working' => __('Working'), 'day_off' => __('Day Off')], (!empty($profile->WorkSchedule()['monday'])) ? $profile->WorkSchedule()['monday'] : NULL, ['data-placeholder'=> 'Work Schedule' ,'class'=> 'form-control js-single-select manager_manag_emp']) !!}                                            
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', __('Tuesday'), ['class' => 'form-control-label']) }}                                            
                                            {!! Form::select('work_schedule[tuesday]', ['working' => __('Working'), 'day_off' => __('Day Off')], (!empty($profile->WorkSchedule()['tuesday'])) ? $profile->WorkSchedule()['tuesday'] : NULL, ['data-placeholder'=> 'Work Schedule' ,'class'=> 'form-control js-single-select manager_manag_emp']) !!}                                                  
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', __('Wednesday'), ['class' => 'form-control-label']) }}                                            
                                            {!! Form::select('work_schedule[wednesday]', ['working' => __('Working'), 'day_off' => __('Day Off')], (!empty($profile->WorkSchedule()['wednesday'])) ? $profile->WorkSchedule()['wednesday'] : NULL, ['data-placeholder'=> 'Work Schedule' ,'class'=> 'form-control js-single-select manager_manag_emp']) !!}                                            
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', __('Thursday'), ['class' => 'form-control-label']) }}                                            
                                            {!! Form::select('work_schedule[thursday]', ['working' => __('Working'), 'day_off' => __('Day Off')], (!empty($profile->WorkSchedule()['thursday'])) ? $profile->WorkSchedule()['thursday'] : NULL, ['data-placeholder'=> 'Work Schedule' ,'class'=> 'form-control js-single-select manager_manag_emp']) !!}                                            
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', __('Friday'), ['class' => 'form-control-label']) }}                                            
                                            {!! Form::select('work_schedule[friday]', ['working' => __('Working'), 'day_off' => __('Day Off')], (!empty($profile->WorkSchedule()['friday'])) ? $profile->WorkSchedule()['friday'] : NULL, ['data-placeholder'=> 'Work Schedule' ,'class'=> 'form-control js-single-select manager_manag_emp']) !!}                                            
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', __('Saturday'), ['class' => 'form-control-label']) }}                                            
                                            {!! Form::select('work_schedule[saturday]', ['working' => __('Working'), 'day_off' => __('Day Off')], (!empty($profile->WorkSchedule()['saturday'])) ? $profile->WorkSchedule()['saturday'] : NULL, ['data-placeholder'=> 'Work Schedule' ,'class'=> 'form-control js-single-select manager_manag_emp']) !!}                                            
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('', __('Sunday'), ['class' => 'form-control-label']) }}                                            
                                            {!! Form::select('work_schedule[sunday]', ['working' => __('Working'), 'day_off' => __('Day Off')], (!empty($profile->WorkSchedule()['sunday'])) ? $profile->WorkSchedule()['sunday'] : NULL, ['data-placeholder'=> 'Work Schedule' ,'class'=> 'form-control js-single-select manager_manag_emp']) !!}                                            
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <input name="from" type="hidden" value="password">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                @if(Auth::user()->acount_type == 1 || Auth::user()->acount_type == 2)
                <div id="tabs-6" class="tabs-card d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" h6 mb-0">{{ __('Permission') }}</h5>
                        </div>
                        <div class="card-body">
                            {{ Form::model($profile, ['route' => ['profile.update', $profile->id], 'method' => 'PUT', 'class'=>"permission_table_information" ]) }}
                                {{ Form::hidden('employee_id', $profile->user_id) }}
                                {{ Form::hidden('form_type', 'manage_permission') }}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        {{ Form::label('', __('Locations Managed'), ['class' => 'form-control-label']) }}
                                        <br>
                                        @foreach ($location_option1 as $location_option1_data)
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manage_location_id[]', $location_option1_data['id'], (!empty($manage_location_select[$location_option1_data['id']])) ? true : null , ['required' => false, 'class'=> 'custom-control-input', 'id' => 'location_'.$location_option1_data['id']]); !!}
                                            {{ Form::label('location_'.$location_option1_data['id'], $location_option1_data['name'], ['class' => 'custom-control-label']) }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        {{ Form::label('', __('Permissions'), ['class' => 'form-control-label']) }}
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_add_edit_rotas', 1, (!empty($manager_option['manager_add_edit_delete_rotas'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_add_edit_rotas']); !!}
                                            {{ Form::label('manager_add_edit_rotas', __('Create,edit and delete rotas for locations they manage'), ['class' => 'custom-control-label']) }}
                                        </div>
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_manage_leave_and_approve_leave_requests_for_other', 1, (!empty($manager_option['manager_manage_leave_and_approve_leave_requests_for_other'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_manage_leave_and_approve_leave_requests_for_other']); !!}
                                            {{ Form::label('manager_manage_leave_and_approve_leave_requests_for_other', __('Manage leave and approve leave requests for others and approve leave requests for others'), ['class' => 'custom-control-label']) }}
                                        </div>
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_manually_add_leave_to_themselves', 1, (!empty($manager_option['manager_manually_add_leave_to_themselves'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_manually_add_leave_to_themselves']); !!}
                                            {{ Form::label('manager_manually_add_leave_to_themselves', __('Manually add leave to themselves'), ['class' => 'custom-control-label']) }}
                                        </div>
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_manage_leave_embargoes', 1, (!empty($manager_option['manager_manage_leave_embargoes'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_manage_leave_embargoes']); !!}
                                            {{ Form::label('manager_manage_leave_embargoes', __('Manage leave embargoes'), ['class' => 'custom-control-label']) }}
                                        </div>
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_add_employees_and_manage_basic_information', 1, (!empty($manager_option['manager_add_employees_and_manage_basic_information'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_add_employees_and_manage_basic_information']); !!}
                                            {{ Form::label('manager_add_employees_and_manage_basic_information', __('Add employees and manage basic information (email, locations, roles, allowances, etc)'), ['class' => 'custom-control-label']) }}
                                        </div>
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_view_and_edit_employee_salary', 1, (!empty($manager_option['manager_view_and_edit_employee_salary'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_view_and_edit_employee_salary']); !!}
                                            {{ Form::label('manager_view_and_edit_employee_salary', __('View and edit employee salary information'), ['class' => 'custom-control-label']) }}
                                        </div>
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_manage_roles', 1, (!empty($manager_option['manager_manage_roles'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_manage_roles']); !!}
                                            {{ Form::label('manager_manage_roles', __('Manage roles'), ['class' => 'custom-control-label']) }}
                                        </div>
                                        <br>
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('manager_view_reports', 1, (!empty($manager_option['manager_view_reports'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'manager_view_reports']); !!}
                                            {{ Form::label('manager_view_reports', __('View reports'), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input name="from" type="hidden" value="password">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                @endif

                <div id="tabs-7" class="tabs-card d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" h6 mb-0">{{ __('Change Password') }}</h5>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('update.password') }}" role="form">
                                @csrf 
                                {{ Form::hidden('employee_id', $profile->user_id) }}
                                @if($profile['id'] == Auth::id())
                                    {{ Form::hidden('form_type', 'set_own_password') }}
                                @else
                                    {{ Form::hidden('form_type', 'set_other_password') }}
                                @endif

                                @if($profile['id'] == Auth::id())
                                    <div class="row">                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('', __('Current Password'), ['class' => 'form-control-label']) }}                                                    
                                                {{ Form::password('current_password', ['class' => 'form-control','placeholder'=>"Enter Current Password", "id"=>"current_password"] ) }}                                                    
                                            </div>
                                            @error('current_password')
                                            <span class="invalid-current_password" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-{{ ($profile['id'] == Auth::id()) ? 6 : 12 }}">
                                            <div class="form-group">
                                                {{ Form::label('', __('New Password'), ['class' => 'form-control-label']) }}                                                    
                                                {{ Form::password('new_password', ['class' => 'form-control','placeholder'=>"Enter New Password", "id"=>"new_password"] ) }}                                                       
                                            </div>
                                            @error('new_password')
                                            <span class="invalid-new_password" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        @if($profile['id'] == Auth::id())
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('', __('Re-type New Password'), ['class' => 'form-control-label']) }}                                                    
                                                {{ Form::password('confirm_password', ['class' => 'form-control','placeholder'=>"Enter Re-type New Password", "id"=>"confirm_password"] ) }}                                                   
                                            </div>
                                            @error('confirm_password')
                                            <span class="invalid-confirm_password" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        @endif
                                    </div>
                                                                         
                                    
                                    <div class="card-footer text-right">
                                        <input class="btn btn-sm btn-primary rounded-pill" type="submit" value="Update">
                                    </div>
                                {{ Form::close() }}                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

