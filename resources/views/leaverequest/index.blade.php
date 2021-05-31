@extends('layouts.main')
@section('page-title')
    {{ __('Leave Request') }}
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
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Leave Requests')}}</h5>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    @if(Auth::user()->acount_type == 1 || Auth::user()->acount_type == 2 )
                    <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown" title="{{__('Menu')}}">
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
        <!-- Listing -->
        <div class="mt-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('Employee') }}</th>
                            <th scope="col">{{ __('Message') }}</th>
                            <th scope="col">{{ __('Requested') }}</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($leave_requests)  && count($leave_requests) > 0)
                                @foreach ($leave_requests as $leave_request)
                                    <tr>
                                        <td>
                                            <h5 class="m-0">
                                                {{ $leave_request->getUserIdName->first_name }}
                                                {{ $leave_request->getUserIdName->last_name }}
                                            </h5>
                                            <small><b>{{ $leave_request->getRequestdatebetween() }}</b></small>
                                        </td>
                                        <td> {{ $leave_request->message }} </td>
                                        <td> {{ $leave_request->getRequestdateFormet() }} </td>
                                        <td> {!! $leave_request->getRequestResponse() !!} </td>
                                        <td>
                                            {{-- Reply By Admin --}}
                                            <button type="button" class="btn-white rounded-circle border-0 {{ $leave_request->getLeaveApprovalStatus() }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Leave Request Reply')}}"
                                            data-url="{{route('leave-request.reply',$leave_request->id)}}"
                                            ><span class="btn-inner--icon action-item"><i class="fas fa-reply pointer"></i></span></button>

                                            {{-- Edit By UserUser Or Employee --}}
                                            <button type="button" class="btn-white rounded-circle border-0 {{ $leave_request->getLeaveApprovalStatus() }}">
                                                <span class="btn-inner--icon action-item">
                                                    <a href="#" data-ajax-popup="true" data-title="{{__('Edit Request')}}" data-size="lg"
                                                data-url="{{route('leave-request.edit', $leave_request->id)}}"
                                                class="action-item "><i class="fas fa-pencil-alt"></i></a>
                                                </span>
                                            </button>

                                            {{-- Delete By User Or Employee --}}
                                            <button type="button" class="btn-white rounded-circle border-0 {{ $leave_request->getLeaveApprovalStatus() }}">
                                                <span class="btn-inner--icon action-item text-danger">
                                                    <a href="#" class="action-item text-danger" data-toggle="tooltip" data-original-title="{{__('Delete')}}"
                                                    data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="document.getElementById('delete-form-{{$leave_request->id}}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                    </a>
                                                </span>
                                            </button>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['leave-request.destroy', $leave_request->id],'id' => 'delete-form-'.$leave_request->id]) !!}
                                        {!! Form::close() !!}
                                        </td>

                                    </tr>
                                @endforeach
                            @else 
                            <tr>
                                <td colspan="4">
                                    <div class="text-center">
                                        <i class="fas fa-user-slash text-primary fs-40"></i>
                                        <h2>{{ __('Opps...') }}</h2>
                                        <h6> {!! __('No leave request found...!') !!} </h6>
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
        });
    </script>
@endpush

