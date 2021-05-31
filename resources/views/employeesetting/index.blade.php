@extends('layouts.main')
@section('page-title')
    {{ __('Setting') }}
@endsection
@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo = \App\Utility::getValByName('company_logo');
    $company_small_logo=\App\Utility::getValByName('company_small_logo');
    $company_favicon= \App\Utility::getValByName('company_favicon');
    $lang=\App\Utility::getValByName('default_language');
@endphp

@section('content')

    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{ __('Setting') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Listing -->        
        <div class="mt-4">
            <!-- rotas setting -->
            <div class="card">                
                <ul class="nav nav-tabs nav-overflow profile-tab-list" role="tablist">
                    <li class="nav-item ml-4">
                        <a href="#dashbord_setting" id="dashbord_setting_tab" class="nav-link active" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fas fa-user mr-2"></i>{{ __('Dashbord Setting') }}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#site_setting" id="site_setting_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="far fa-building mr-2"></i>{{ __('Site Setting') }}
                        </a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#email_setting" id="system_setting_tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fas fa-envelope mr-2"></i>{{ __('Email Setting') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="dashbord_setting" role="tabpanel" aria-labelledby="orders-tab">                        
                        <div class="card-body">
                            {{ Form::model($profile, ['route' => ['setting.update', $profile->id], 'method' => 'PUT', 'class'=>"permission_table_information" ]) }}
                                {{ Form::hidden('employee_id', $profile->user_id) }}
                                {{ Form::hidden('form_type', 'rotas_setting') }}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <h5 class=" h6 mb-1">{{ __('Rota Settings') }}</h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('emp_show_rotas_price', 1, (!empty($company_setting['emp_show_rotas_price'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'emp_show_rotas_price']); !!}
                                            {{ Form::label('emp_show_rotas_price', __('Show employee rotas price'), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('emp_show_avatars_on_rota', 1, (!empty($company_setting['emp_show_avatars_on_rota'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'emp_show_avatars_on_rota']); !!}
                                            {{ Form::label('emp_show_avatars_on_rota', __('Show employee avatars on rota'), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('emp_hide_rotas_hour', 1, (!empty($company_setting['emp_hide_rotas_hour'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'emp_hide_rotas_hour']); !!}
                                            {{ Form::label('emp_hide_rotas_hour', __('Hide employee rotas hour'), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('include_unpublished_shifts', 1, (!empty($company_setting['include_unpublished_shifts'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'include_unpublished_shifts']); !!}
                                            {{ Form::label('include_unpublished_shifts', __('Include unpublished shifts on the dashboard and report'), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('emp_only_see_own_rota', 1, (!empty($company_setting['emp_only_see_own_rota'])) ? 1 : 0, ['required' => false, 'class'=> 'custom-control-input','id' => 'emp_only_see_own_rota']); !!}
                                            {{ Form::label('emp_only_see_own_rota', __('Employees only see themselves on the rota'), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>                    
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('emp_can_see_all_locations', 1, (!empty($company_setting['emp_can_see_all_locations'])) ? 1 : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'emp_can_see_all_locations']); !!}
                                            {{ Form::label('emp_can_see_all_locations', __('Employees can view the rotas of locations they are not assigned to'), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                {{ Form::label('', __('Week Starts'), ['class' => 'form-control-label']) }}
                                                {!! Form::select('company_week_start', ['monday' => __('Monday'), 'tuesday' => __('Tuesday'), 'wednesday' => __('Wednesday'), 'thursday' => __('Thursday'), 'friday' => __('Friday'), 'saturday' => __('Saturday'), 'sunday' => __('Sunday')], (!empty($company_setting['company_week_start'])) ? $company_setting['company_week_start'] : null, ['required' => true, 'data-placeholder'=> __('Select Day') ,'class'=> 'form-control js-single-select']) !!}
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                {{ Form::label('', __('Time Format'), ['class' => 'form-control-label']) }}
                                                {!! Form::select('company_time_format', ['12'=>'12 '.__('Hour'), '24'=>'24 '.__('Hour')], (!empty($company_setting['company_time_format'])) ? $company_setting['company_time_format'] : null, ['required' => true, 'data-placeholder'=> 'Yours Time Type' ,'class'=> 'form-control js-single-select']) !!}
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                {{ Form::label('', __('Date Format'), ['class' => 'form-control-label']) }}
                                                {!! Form::select('company_date_format', ['Y-m-d' => date("Y-m-d"), 'd-m-Y' => date("d-m-Y"), 'M j, Y' => date('M j, Y'), 'd M Y' => date('d M Y'), 'D d F Y' => date('D d F Y')  ], (!empty($company_setting['company_date_format'])) ? $company_setting['company_date_format'] : null, ['required' => true, 'data-placeholder'=> __('Select Day') ,'class'=> 'form-control js-single-select']) !!}
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="row">
                                                    <div class="col-5">
                                                        {{ Form::label('', __('Currency Symbol'), ['class' => 'form-control-label']) }}
                                                        {{ Form::text('company_currency_symbol', (!empty($company_setting['company_currency_symbol'])) ? $company_setting['company_currency_symbol'] : '$' , ['class' => 'form-control']) }}
                                                    </div>
                                                    <div class="col-6 my-auto">
                                                        <div class="custom-control custom-radio d-inline-block mx-2">
                                                            <input type="radio" name="company_currency_symbol_position" value="pre" class="custom-control-input" id="company_currency_symbol_pre" {{ ($company_setting['company_currency_symbol_position'] == 'pre') ? 'checked' : '' }} >
                                                            <label class="custom-control-label" for="company_currency_symbol_pre">{{ __('Pre') }}</label>
                                                        </div>                                                                    
                                                        <div class="custom-control custom-radio d-inline-block mx-2">
                                                            <input type="radio" name="company_currency_symbol_position" value="post" class="custom-control-input" id="company_currency_symbol_post" {{ ($company_setting['company_currency_symbol_position'] == 'post') ? 'checked' : '' }} >
                                                            <label class="custom-control-label" for="company_currency_symbol_post">{{ __('Post') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">                                    
                                    <div class="col-xs-12 col-sm-6 col-md-2">
                                        {{ Form::label('leave_year_start', __('Leave Year Starts'), ['class' => 'form-control-label']) }}
                                        {!! Form::select('leave_start_month', 
                                                [ "01" =>  __('January'), "02" =>  __('February'), "03" =>  __('March'), "04" =>  __('April'), "05" =>  __('May'), "06" =>  __('June'), "07" =>  __('July'), "08" =>  __('August'), "09" =>  __('September'), "10" =>  __('October'), "11" =>  __('November'), "12" =>  __('December') ], 
                                                (!empty($company_setting['leave_start_month'])) ? $company_setting['leave_start_month'] : 1, ['required' => true, 'data-placeholder'=> __('Select Month') ,'class'=> 'form-control js-single-select']) !!}
                                        
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-2">
                                        {{ Form::label('breck_paid', __('Break'), ['class' => 'form-control-label']) }}
                                        <br>                                        
                                        <div class="btn-group btn-group-toggle border border-primary rounded" data-toggle="buttons">
                                            <label class="btn btn-primary {{ ($company_setting['break_paid'] == 'paid') ? 'active' : '' }}">
                                                <input type="radio" name="break_paid" value="paid" {{ ($company_setting['break_paid'] == 'paid') ? 'checked' : '' }}> {{ __('Paid') }}
                                            </label>
                                            <label class="btn btn-primary {{ ($company_setting['break_paid'] != 'paid') ? 'active' : '' }}">
                                                <input type="radio" name="break_paid" value="unpaid" {{ ($company_setting['break_paid'] == 'unpaid') ? 'checked' : '' }} > {{ __('Unpaid') }}
                                            </label>
                                        </div>                                                                                
                                    </div>                                    
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        {{ Form::label('', __('Shift Notes'), ['class' => 'form-control-label']) }}
                                        {!! Form::select('see_note', ['none' => __('Only admins and managers can see shift notes'), 'self' => __('Employees can only see notes for their own shifts and open shifts'),  'all' => __('Employees can see shift notes for everybody')], (!empty($company_setting['see_note'])) ? $company_setting['see_note'] : null, ['required' => false, 'class'=> 'form-control ']) !!}
                                    </div>                                                
                                </div>                                            

                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"><h5 class=" h6 mb-1">{{ __('Availability Preferences') }}</h5></div>                                                
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="custom-control custom-checkbox d-inline-block mx-2">
                                            {!! Form::checkbox('employees_can_set_availability', 1, (!empty($company_setting['employees_can_set_availability'])) ? $company_setting['employees_can_set_availability'] : 0 , ['required' => false, 'class'=> 'custom-control-input','id' => 'employees_can_set_availability']); !!}
                                            {{ Form::label('employees_can_set_availability', __("Employees can set their own availability preferences"), ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                </div>
        
                                <div class="text-right w-100">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="site_setting" role="tabpanel" aria-labelledby="orders-tab">
                        <div class="">
                            <div class="card-body">                                
                                {{ Form::model($settings, ['route' => ['setting.update', $profile->id], 'method' => 'PUT', 'class'=>"permission_table_information", 'enctype'=>"multipart/form-data" ]) }}                                
                                {{ Form::hidden('form_type', 'site_setting') }}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            {{ Form::label('logo', __('Logo'), ['class' => 'form-control-label']) }}
                                            <input type="file" name="logo" id="logo" class="custom-input-file">
                                            <label for="logo">
                                                <i class="fa fa-upload"></i>
                                                <span>{{ __('Choose a file') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-center my-auto">
                                        <div class="logo-div">
                                            <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" width="170px" class="img_setting">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">                                            
                                            {{ Form::label('favicon', __('Favicon'), ['class' => 'form-control-label']) }}
                                            <input type="file" name="favicon" id="favicon" class="custom-input-file">
                                            <label for="favicon">
                                                <i class="fa fa-upload"></i>
                                                <span>{{ __('Choose a file') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-center my-auto">
                                        <div class="logo-div">
                                            <img src="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" width="50px" class="img_setting">
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title_text" class = 'form-control-label'>{{ __('Title Text') }}</label>
                                        {{ Form::text('title_text', null, ['class' => 'form-control', 'required' => '', 'id'=>'title_text', 'placeholder' => __('Title Text') ]) }}                                        
                                    </div>
                                    <div class="form-group col-md-6">                                        
                                        {{ Form::label('', __('Footer Text'), ['class' => 'form-control-label']) }}
                                        {{ Form::text('footer_text', null, ['class' => 'form-control', 'required' => '', 'id'=>'footer_text', 'placeholder' => __('Footer Text') ]) }}                                                                                
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{ Form::label('', __('Default Language'), ['class' => 'form-control-label']) }}
                                        <div class="changeLanguage">
                                        @php
                                            $user = Auth::user();
                                            if ($user){
                                                $currantLang = $user->currentLanguage();
                                                $languages=\App\Utility::languages();
                                            }                                                                                                
                                        @endphp                                            
                                            <select name="default_language" id="default_language" class="form-control js-single-select" aria-hidden="true">
                                                @if(isset($languages) && !empty($languages) && count($languages))
                                                    @foreach($languages as $language)
                                                        <option value="{{ $language }}" {{ (Auth::user()->lang == $language) ? 'selected' : '' }}><span> {{Str::upper($language)}}</span></option>
                                                    @endforeach
                                                @endif
                                            </select>                                                
                                        </div>
                                    </div>
                                    <div class="form-group col-3 my-auto">
                                        {{ Form::label('', __('Landing Page Display'), ['class' => 'form-control-label']) }}
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="display_landing_page" id="display_landing_page" {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="display_landing_page"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-3 my-auto">
                                        <label class="form-control-label">{{ __('RTL') }}</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="SITE_RTL" id="SITE_RTL" {{ env('SITE_RTL') == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="SITE_RTL"></label>
                                        </div>                                            
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_link_1',__('Footer Link Title 1'), ['class' => 'form-control-label']) }}
                                        {{Form::text('footer_link_1',null,array('class'=>'form-control','placeholder'=>__('Enter Footer Link Title 1')))}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_value_1',__('Footer Link href 1'), ['class' => 'form-control-label']) }}
                                        {{Form::text('footer_value_1',null,array('class'=>'form-control','placeholder'=>__('Enter Footer Link 1')))}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_link_2',__('Footer Link Title 2'), ['class' => 'form-control-label']) }}
                                        {{Form::text('footer_link_2',null,array('class'=>'form-control','placeholder'=>__('Enter Footer Link Title 2')))}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_value_2',__('Footer Link href 2'), ['class' => 'form-control-label']) }}
                                        {{Form::text('footer_value_2',null,array('class'=>'form-control','placeholder'=>__('Enter Footer Link 2')))}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_link_3',__('Footer Link Title 3'), ['class' => 'form-control-label']) }}
                                        {{Form::text('footer_link_3',null,array('class'=>'form-control','placeholder'=>__('Enter Footer Link Title 3')))}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_value_3',__('Footer Link href 3'), ['class' => 'form-control-label']) }}
                                        {{Form::text('footer_value_3',null,array('class'=>'form-control','placeholder'=>__('Enter Footer Link 3')))}}
                                    </div>
                                </div>
                                <div class="text-right w-100">
                                    <input name="from" type="hidden" value="password">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="email_setting" role="tabpanel" aria-labelledby="orders-tab">
                        <div class="">
                            {{ Form::model($settings, ['route' => ['email.setting'], 'method' => 'POST', 'class'=>"permission_table_information", 'enctype'=>"multipart/form-data" ]) }}                                
                                {{ Form::hidden('form_type', 'email_setting') }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_driver',__('Mail Driver'), ['class' => 'form-control-label']) }}
                                            {{Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                            @error('mail_driver')
                                            <span class="invalid-mail_driver" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_host',__('Mail Host'), ['class' => 'form-control-label']) }}
                                            {{Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Driver')))}}
                                            @error('mail_host')
                                            <span class="invalid-mail_driver" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_port',__('Mail Port'), ['class' => 'form-control-label']) }}
                                            {{Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                            @error('mail_port')
                                            <span class="invalid-mail_port" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_username',__('Mail Username'), ['class' => 'form-control-label']) }}
                                            {{Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                            @error('mail_username')
                                            <span class="invalid-mail_username" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_password',__('Mail Password'), ['class' => 'form-control-label']) }}
                                            <input class="form-control" placeholder="{{ __('Enter Mail Password') }}" name="mail_password" type="password" value="{{ env('MAIL_PASSWORD') }}" id="mail_password">
                                            @error('mail_password')
                                            <span class="invalid-mail_password" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_encryption',__('Mail Encryption'), ['class' => 'form-control-label']) }}
                                            {{Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                            @error('mail_encryption')
                                            <span class="invalid-mail_encryption" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_from_address',__('Mail From Address'), ['class' => 'form-control-label']) }}
                                            {{Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                            @error('mail_from_address')
                                            <span class="invalid-mail_from_address" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('mail_from_name',__('Mail From Name'), ['class' => 'form-control-label']) }}
                                            {{Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                            @error('mail_from_name')
                                            <span class="invalid-mail_from_name" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <a href="#" data-url="{{route('test.mail' )}}" data-ajax-popup="true" data-title="{{__('Send Test Mail')}}" class="btn btn-sm btn-info rounded-pill">
                                                {{__('Send Test Mail')}}
                                            </a>
                                        </div>
                                        <div class="form-group col-6 text-right">
                                            {{Form::submit(__('Save Change'),array('class'=>'btn btn-sm btn-primary rounded-pill'))}}
                                        </div>
                                    </div>
                                </div>                                  
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
