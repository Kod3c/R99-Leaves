@extends('layouts.main')
@section('page-title')
    {{ __('Embargo') }}
@endsection
@section('content')
    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">                    
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Leave Embargoes')}}</h5>
                    </div>
                    
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    <button type="button" class="btn btn-sm btn-white btn-icon-only rounded-circle" data-size="lg" data-ajax-popup="true" data-title="{{__('Add New Embargoes')}}"
                    data-url="{{route('embargoes.create')}}"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span></button>

                    @if(Auth::user()->acount_type == 1 || Auth::user()->acount_type == 2 )
                    <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown" title={{ __('Menu') }}>
                        <a href="#" class="text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right employee_menu_listt dropdown-menulist-scroll">
                            <a href="{{ url('holidays') }}" onclick="window.location.href=this;" class="dropdown-item" id="view_employee">{{__('View All Leave')}}</a>
                            @if(Auth::user()->acount_type == 1 || $haspermission['embargoes'] == 1)
                            <a href="{{ url('embargoes') }}" onclick="window.location.href=this;" class="dropdown-item" id="removed_employee">{{__('Embargoes')}}</a>
                            @endif
                            @if(Auth::user()->acount_type == 1)
                            <a href="{{ url('rules') }}" onclick="window.location.href=this;" class="dropdown-item d-none" id="edit_group">{{__('Request Rules')}}</a>
                            @endif
                            @if(Auth::user()->acount_type == 1 || $haspermission['leave_request'] == 1)
                            <a href="{{ url('leave-request') }}" onclick="window.location.href=this;" class="dropdown-item" id="edit_group">{{__('Leave Request')}}</a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Date')}}</th>
                            <th scope="col">{{__('Applies To')}}</th>
                            <th scope="col">{{__('Message')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($embargoes)  && count($embargoes) > 0)
                                @foreach ($embargoes as $embargoe)
                                    <tr>
                                        <td> {!! $embargoe->getDateBetween() !!} </td>
                                        <td> {!! $embargoe->getCountEmployee() !!} </td>
                                        <td> {{ $embargoe->message }} </td>
                                        <td class="text-right">
                                            
                                            <div class="actions ml-3">
                                                <a href="#" data-ajax-popup="true" data-title="{{__('Edit Embargoe')}}" data-size="lg"
                                                data-url="{{route('embargoes.edit', $embargoe->id)}}"
                                                class="action-item mr-2 "><i class="fas fa-pencil-alt"></i></a>

                                                <a href="#" class="action-item text-danger mr-2 " data-toggle="tooltip" data-original-title="{{__('Delete')}}"
                                                data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                                data-confirm-yes="document.getElementById('delete-form-{{$embargoe->id}}').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['embargoes.destroy', $embargoe->id],'id' => 'delete-form-'.$embargoe->id]) !!}
                                            {!! Form::close() !!}
                                            <span class="clearfix"></span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <div class="text-center">
                                                <i class="fas fa-user text-primary fs-40"></i>
                                                <h2>{{ __('Opps...') }}</h2>
                                                <h6> {!! __('No embargoes found.') !!} </h6>
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

