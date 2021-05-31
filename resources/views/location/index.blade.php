@extends('layouts.main')

@section('page-title')
    {{ __('Location') }}
@endsection

@section('content')

    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{ __('Location') }}</h5>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    <button type="button" class="btn btn-sm btn-white btn-icon-only rounded-circle" data-size="lg" data-ajax-popup="true" data-title="{{__('Add New Location')}}" title="{{__('Add New Location')}}"
                            data-url="{{route('locations.create')}}"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span></button>
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
                            <th scope="col">{{__('Address')}}</th>
                            <th scope="col">{{__('Managers')}}</th>
                            <th class="text-center">{{__('Employees')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($locations)  && count($locations) > 0)
                                @foreach($locations as $location)
                                    <tr>
                                    <td> {{ $location->name }} </td>
                                    <td> {{ $location->address }} </td>
                                    <td>  {{ $location->countmanager($location->id) }} </td>
                                    <td class="text-center"> {{ $location->getCountEmployees() }} </td>
                                    <td class="text-right">
                                        <!-- Actions -->
                                        <div class="actions rtl-actions ml-3">
                                            <a href="#" data-ajax-popup="true" data-title="{{__('Edit Location')}}" data-size="lg"
                                            data-url="{{route('locations.edit', $location->id)}}"
                                            class="action-item mr-2 "><i class="fas fa-pencil-alt" data-toggle="tooltip" title="{{__('Edit Location')}}"></i></a>
                                            <a href="#" class="action-item text-danger mr-2 emp_delete " data-toggle="tooltip" data-original-title="{{__('Delete')}}" 
                                            data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                            data-confirm-yes="document.getElementById('delete-form-{{$location->id}}').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['locations.destroy', $location->id],'id' => 'delete-form-'.$location->id]) !!}
                                            {!! Form::close() !!}
                                            <span class="clearfix"></span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center">
                                            <i class="fas fa-map-marker-alt text-primary fs-40"></i>
                                            <h2>{{ __('Opps...') }}</h2>
                                            <h6> {!! __('No loaction found...!') !!} </h6>
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
