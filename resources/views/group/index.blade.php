@extends('layouts.main')

@section('content')
    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                    <!-- Page title + Go Back button -->
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Groups')}}</h5>
                    </div>
                    <!-- Additional info -->
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    <button type="button" class="btn btn-sm btn-white btn-icon-only rounded-circle" data-size="lg" data-ajax-popup="true" data-title="{{__('Add New Group')}}"
                            data-url="{{route('groups.create')}}"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span></button>

                    <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown">
                        <a href="#" class="text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right employee_menu_listt">
                            <a href="{{ url('employees') }}" onclick="window.location.href=this;" class="dropdown-item">{{__('View Employees')}}</a>
                            <a href="{{ url('past-employees') }}" onclick="window.location.href=this;" class="dropdown-item">{{__('Past Employees')}}</a>
                            <a href="{{ url('groups') }}" onclick="window.location.href=this;" class="dropdown-item">{{__('Edit Groups')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stats -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-muted mb-1">{{__('Total Employee')}}</h6>
                                <span class="h5 font-weight-bold mb-0">339</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon bg-gradient-warning text-white rounded-circle icon-shape">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <span class="badge badge-soft-success mr-2"><i class="fas fa-arrow-up"></i> 25%</span>
                            <span class="text-nowrap">Since last month</span>
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
                                <h6 class="text-muted mb-1">{{__('Present Employee')}}</h6>
                                <span class="h5 font-weight-bold mb-0">50</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon bg-gradient-primary text-white rounded-circle icon-shape">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <span class="badge badge-soft-warning mr-2"><i class="fas fa-arrow-up"></i> 10%</span>
                            <span class="text-nowrap">Since last day</span>
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
                                <h6 class="text-muted mb-1">{{__('Absent Employee')}}</h6>
                                <span class="h5 font-weight-bold mb-0">5</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon bg-gradient-danger text-white rounded-circle icon-shape">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <span class="badge badge-soft-danger mr-2"><i class="fas fa-arrow-down"></i> 5,85%</span>
                            <span class="text-nowrap">Since last day</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listing -->
        <div class="">
            <div class="employee_menu edit_group">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header actions-toolbar border-0">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <h6 class="d-inline-block mb-0 text-capitalize">{{__('Groups')}}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Group Name')}}</th>
                                <th class="text-center" scope="col">{{__('Employees')}}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $group)
                                <tr>
                                    <td> {{ $group->name }} </td>
                                    <td class="text-center"> {{ $group->getGroupEmployeeNo() }} </td>
                                    <td class="text-right">
                                        <!-- Actions -->
                                        <div class="actions ml-3">
                                            <a href="#" data-ajax-popup="true" data-title="{{__('Edit Group')}}" data-size="lg"
                                               data-url="{{route('groups.edit', $group->id)}}"
                                               class="action-item mr-2 "><i class="fas fa-pencil-alt"></i></a>

                                            <a href="#" class="action-item text-danger mr-2 emp_delete " data-toggle="tooltip" data-original-title="{{__('Delete')}}"
                                               data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                               data-confirm-yes="document.getElementById('delete-form-{{$group->id}}').submit();">
                                                <i class="fas fa-trash" data-toggle="tooltip" title="Delete"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['groups.destroy', $group->id],'id' => 'delete-form-'.$group->id]) !!}
                                            {!! Form::close() !!}
                                            <span class="clearfix"></span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
