@extends('layouts.main')

@section('page-title')
    {{ __('Employee') }}
@endsection

@section('content')
    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title mb-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                   
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Employees')}}</h5>
                    </div>
                   
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    <button type="button" class="btn btn-sm btn-white btn-icon-only rounded-circle" title="{{__('Add New Employee')}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Add New Employee')}}"
                            data-url="{{route('employees.create')}}"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span></button>

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
                            <span class="text-nowrap">{{ __('Total cost : ') }} {{ \App\User::CompanycurrencySymbol() }} {{ $box['month_rotas_cost'] }}</span> &nbsp;&nbsp;
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
        
        <div class="employee_menu view_employee">
                <div class="card">                    
                    <div class="card-header actions-toolbar border-0">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <h6 class="d-inline-block mb-0 text-capitalize">{{__('Employee')}}</h6>
                            </div>
                            <div class="col text-right">
                                <div class="actions rtl-actions">                                  
                                    <div class="rounded-pill d-inline-block search_round">
                                        <div class="input-group input-group-sm input-group-merge input-group-flush">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" id="user_keyword" class="form-control form-control-flush search-user" placeholder="{{ __('Search User') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-items-center employee_tableese">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Locations')}}</th>
                                <th scope="col">{{__('Role')}}</th>
                                <th scope="col">{{__('Wage / Salary')}}</th>
                                <th scope="col">{{__('Weekly Hours')}}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($employees)  && count($employees) > 0)                                
                                    @foreach($employees as $employee)
                                        <tr data-name="{{$employee->first_name}} {{$employee->last_name}}">
                                            <th>
                                                <a href="#" class="name h6 mb-0 text-sm">{{$employee->first_name}} {{$employee->last_name}}</a> <br>
                                                @if($employee->type == 'company')
                                                    <span class="badge badge-xs badge-primary"> {{  __('Administrator') }} </span>
                                                @elseif($employee->acount_type == 1)
                                                    <span class="badge badge-xs badge-success"> {{  __('Admin') }} </span>
                                                @elseif($employee->acount_type == 2)
                                                    <span class="badge badge-xs badge-info"> {{  __('Manager') }} </span>
                                                @endif
                                            </th>
                                            <td> {{$employee->email}} </td>
                                            <td> {{$employee->getLocatopnName($employee->id)}} </td>
                                            <td> {!! $employee->getDefaultEmployeeRole($employee->id) !!}  </td>
                                            <td> {{ $employee->getwagesalary($employee->id) }} </td>
                                            <td> {{ $employee->getweeklyhours($employee->id) }} </td>
                                            <td class="text-right">
                                                <div class="actions rtl-actions ml-3">
                                                    @if($employee->type != 'company' && Auth::user()->type == 'company')
                                                    <button type="button" class="btn-white rounded-circle border-0 {{ ($employee->password == '') ? 'd-none' : '' }} bg-transparent">
                                                        <a href="#" data-ajax-popup="true" data-title="{{__('Manage user type')}}" data-size="lg"
                                                        data-url="{{ route('employee.manage_permission',$employee->id) }}"
                                                        class="action-item"><i class="fas fa-cogs" data-toggle='tooltip' title="{{__('Manage user type')}}"></i>
                                                        </a>
                                                    </button>
                                                    @endif

                                                    @if($employee->password == '')
                                                    <button type="button" class="btn-white rounded-circle border-0 {{ ($employee->password != '') ? 'd-none' : '' }} bg-transparent">
                                                        <a href="#" data-ajax-popup="true" data-title="{{__('Manage type')}}" data-size="lg"
                                                        data-url="{{ route('employee.set_password',$employee->id) }}"
                                                        class="action-item">                                                        
                                                        <i class="fas fa-key" data-toggle='tooltip' title="{{__('Set Password')}}"></i> 
                                                        </a>
                                                    </button>                                                    
                                                    @endif

                                                    <button type="button" class="btn-white rounded-circle border-0 bg-transparent">
                                                        <a href="{{ url('profile/'.$employee->id.'') }}" class="action-item" data-toggle="tooltip" title="{{__('Edit')}}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    </button>

                                                    @if ( $employee->acount_type != 1)
                                                    <button type="button" class="btn-white rounded-circle border-0 {{ ($employee->acount_type == 1) ? 'd-none' : '' }} bg-transparent">
                                                        <a href="#" class="action-item text-danger" data-toggle="tooltip" data-original-title="{{__('Delete')}}"
                                                        data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </button>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['employees.destroy', $employee->id],'id' => 'delete-form-'.$employee->id]) !!}
                                                    {!! Form::close() !!}
                                                    @endif               
                                                    <span class="clearfix"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else 
                                <tr>
                                    <td colspan="7">
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

@push('pagescript')
<script>
    $(document).ready(function() {
        $(document).on('keyup','.search-user', function () {
            var value = $(this).val();
            $('.employee_tableese tbody>tr').each(function( index ) {
                var name = $(this).attr('data-name');
                if(name.includes(value)) {
                    $(this).show();
                } else  {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endpush
