@extends('layouts.main')
@section('page-title')
    {{ __('Role') }}
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
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Role')}}</h5>
                    </div>
                    <!-- Additional info -->
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    <button type="button" class="btn btn-sm btn-white btn-icon-only rounded-circle" data-size="lg" data-ajax-popup="true" data-title="{{__('Add New Role')}}" title="{{__('Add New Role')}}"
                            data-url="{{route('roles.create')}}"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span></button>
                    </a>
                </div>
            </div>
        </div>
        <!-- Listing -->
        <div class="mt-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Default Break')}}</th>
                            <th scope="col" class="text-center">{{__('Employees')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($roles)  && count($roles) > 0)
                                @foreach($roles as $role)
                                    <tr>
                                        <td> <i class="fas fa-circle" style="color: {{ $role->color }}"></i> {{ $role->name }} </td>
                                        <td> {{ $role->getDefaultBreack() }} {{__('Minutes')}} </td>
                                        <td class="text-center"> {{ $role->getCountEmployees() }} </td>
                                        <td class="text-right">
                                            <!-- Actions -->
                                            <div class="actions rtl-actions ml-3">
                                                <a href="#" data-ajax-popup="true" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-size="lg"
                                                data-url="{{route('roles.edit', $role->id)}}"
                                                class="action-item mr-2 "><i class="fas fa-pencil-alt"></i></a>

                                                @if (empty($role->hasshift()))
                                                    <a href="#" class="action-item text-danger mr-2 emp_delete " data-toggle="tooltip" data-original-title="{{__('Delete')}}"
                                                    data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="document.getElementById('delete-form-{{$role->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id' => 'delete-form-'.$role->id]) !!}
                                                    {!! Form::close() !!}
                                                @else
                                                    <a href="#" class="action-item text-danger mr-2 emp_delete hasshiftyes"><i class="fas fa-trash"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                            <tr>
                                <td colspan="4">
                                    <div class="text-center">
                                        <i class="fas fa-user-tag text-primary fs-40"></i>
                                        <h2>{{ __('Opps...') }}</h2>
                                        <h6> {!! __('No Role found...!') !!} </h6>
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
    $(document).on('click','.hasshiftyes', function () {
        show_toastr('Error', '{{__("This role has shifts. So remove all shifts of this role.")}}', 'error');
    });
</script>
@endpush
