@extends('layouts.main')
@section('page-title')
    {{ __('Deleted Employees') }}
@endsection
@section('content')
    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title mb-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                    <!-- Page title + Go Back button -->
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Deleted Employees')}}</h5>
                    </div>
                    <!-- Additional info -->
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown" title="{{__('Menu')}}">
                        <a href="#" class="text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right employee_menu_listt">
                            <a href="{{ url('employees') }}" onclick="window.location.href=this;" class="dropdown-item">{{__('View Employees')}}</a>
                            <a href="{{ url('past-employees') }}" onclick="window.location.href=this;" class="dropdown-item">{{__('Deleted Employees')}}</a>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->type == 'company')
            <!-- Stats -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-1">{{__('Current month new employee')}}</h6>
                                    <span class="h5 font-weight-bold mb-0">{{ $box['month_employee'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon bg-gradient-warning text-white rounded-circle icon-shape"><i class="fas fa-users"></i></div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-nowrap">{{ __('Total employee : ') }}  {{ $box['total_employee'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-1">{{__('Current month rotas')}}</h6>
                                    <span class="h5 font-weight-bold mb-0">{{ $box['month_rotas'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon bg-gradient-primary text-white rounded-circle icon-shape"><i class="far fa-calendar-alt"></i></div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-nowrap">{{ __('Total cost : ') }}{{ \App\User::CompanycurrencySymbol() }}{{ $box['month_rotas_cost'] }}</span> &nbsp;&nbsp;
                                <span class="text-nowrap">{{ __('Total time : ') }} {{ $box['month_rotas_time'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-1">{{__('Current month leave')}}</h6>
                                    <span class="h5 font-weight-bold mb-0">{{ $box['month_leave'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon bg-gradient-danger text-white rounded-circle icon-shape"><i class="fas fa-user-alt-slash"></i></div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-nowrap">{{ __('Company leave : ') }} {{ $box['month_comapany_leave_use'] }}</span> &nbsp;&nbsp;
                                <span class="text-nowrap">{{ __('Other leave : ') }} {{ $box['month_other_leave_use'] }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Listing -->
        <div class="employee_menu">
                <div class="card">

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Added')}}</th>
                                <th scope="col">{{__('Deleted')}}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($past_employees)  && count($past_employees) > 0)
                                @foreach($past_employees as $past_employee)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body ml-4">
                                                    <a href="#" class="name h6 mb-0 text-sm">{{$past_employee->first_name}} {{$past_employee->last_name}}</a> <br>
                                                </div>
                                            </div>
                                        </th>
                                        <td> {{$past_employee->email}} </td>
                                        <td> {{$past_employee->created_at}} </td>
                                        <td> {{$past_employee->deleted_at}} </td>
                                        <td class="text-right">
                                            <!-- Actions -->
                                            <div class="actions ml-3">
                                                <a href="#" class="action-item text-danger mr-2 emp_delete " data-toggle="tooltip" data-original-title="{{__('Restore')}}"
                                                data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                                data-confirm-yes="document.getElementById('restore-form-{{$past_employee->id}}').submit();">
                                                    <i class="fas fa-trash-restore-alt"></i>
                                                </a>
                                                {!! Form::open(['method' => 'POST', 'route' => ['employee.restore', $past_employee->id],'id' => 'restore-form-'.$past_employee->id]) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else 
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center">
                                            <i class="fas fa-users text-primary fs-40"></i>
                                            <h2>{{ __('Opps...') }}</h2>
                                            <h6> {!! __('No Employee found...!') !!} </h6>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    </div>
@endsection

