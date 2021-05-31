@extends('layouts.main')
@section('page-title')
    {{ __('Leave') }}
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
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{__('Leave')}}</h5>
                    </div> &nbsp;&nbsp;&nbsp;
                    <div class="d-inline-block text-white">
                        <i class="fa fa-caret-left weak-prev-left weak-prev1 weak_go1"></i>
                        &nbsp;<span class="weak_go_html1 weak_go_html2">{{ $week_date[0].' - '.$week_date[6] }}</span>&nbsp;
                        <i class="fa fa-caret-right weak-prev-left weak-left1 weak_go1"></i>
                        <input type="hidden" data-start="{{ $week_date['week_start'] }}" data-end="{{ $week_date['week_end'] }}"  class="week_last_daye1">
                        <input type="hidden" value="0" data-created-by="{{ $created_by }}" class="week_add_sub1">
                    </div>
                    <!-- Additional info -->
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">                                       

                    @if(Auth::user()->acount_type == 1 || $haspermission['leave_request'] == 1)
                        @if($leave_status_requests > 0)
                            <a href="{{ url('leave-request') }}" class="btn btn-sm btn-white btn-icon-only w-auto px-3"><span class="btn-inner--icon">{{ $leave_status_requests.' '.__('Leave requests available') }}</span></a>
                        @endif
                    @endif
                    
                    <button type="button" class="btn btn-sm btn-white btn-icon-only rounded-circle" title="{{__('Add New Leave')}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Add Employee Leave')}}"
                        data-url="{{route('holidays.create')}}"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                    </button>

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
                <div class="card-wrapper project-timesheet overflow-auto">
                    <table class="table ajax-table">
                        <thead>
                        <tr class="text-center week_go_table1">
                            <th></th>
                            <th>{{ __('Holiday Allowance') }}</th>
                            <th>{{ __('Holiday Used') }}</th>
                            <th>{{ __('Holiday Remaining') }}</th>
                            <th><span>{{ date('D', strtotime($week_date[0])) }}</span><br><span>{{ $week_date[0] }}</span></th>
                            <th><span>{{ date('D', strtotime($week_date[1])) }}</span><br><span>{{ $week_date[1] }}</span></th>
                            <th><span>{{ date('D', strtotime($week_date[2])) }}</span><br><span>{{ $week_date[2] }}</span></th>
                            <th><span>{{ date('D', strtotime($week_date[3])) }}</span><br><span>{{ $week_date[3] }}</span></th>
                            <th><span>{{ date('D', strtotime($week_date[4])) }}</span><br><span>{{ $week_date[4] }}</span></th>
                            <th><span>{{ date('D', strtotime($week_date[5])) }}</span><br><span>{{ $week_date[5] }}</span></th>
                            <th><span>{{ date('D', strtotime($week_date[6])) }}</span><br><span>{{ $week_date[6] }}</span></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($employees)  && count($employees) > 0)
                                @foreach ($employees as $employee)
                                    <tr class="text-center" data-id="{{ $employee->id }}">
                                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        <td><span class="create_time_sheet">{!! $employee->getAnnualHoliday($employee->id) !!}</span></td>
                                        <td><span class="create_time_sheet">{!! $employee->getUsedHoliday($employee->id) !!}</span></td>
                                        <td><span class="create_time_sheet">{!! $employee->getRemaingHoliday($employee->id) !!}</span></td>
                                        {!! $employee->getHasLeave($employee->id,0) !!}
                                    </tr>
                                @endforeach
                            @else 
                            <tr>
                                <td colspan="11">
                                    <div class="text-center">
                                        <i class="fas fa-user-slash text-primary fs-40"></i>
                                        <h2>{{ __('Opps...') }}</h2>
                                        <h6> {!! __('No data found...!') !!} </h6>
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
        
        $('body').on('click','.delete_leave_ppp', function () {            
            $( ".delete_leave_form" ).submit();
            loadConfirm();
        });
        $(document).on('click','.weak_go1', function () {
            ajaxLeaveTimesheetTableView();
        });
    });

    function ajaxLeaveTimesheetTableView() {
        var start_date = $('.week_last_daye1').attr('data-start');
        var end_date = $('.week_last_daye1').attr('data-end');
        var week = $('.week_add_sub1').val();
        var created_by = $('.week_add_sub1').attr('data-created-by');
        var data = {
            start_date: start_date,
            end_date: end_date,
            week: week,
            created_by: created_by,
        }

        $.ajax({
            url: '{{ route('holidays.leave_sheet') }}',
            method: 'post',
            data: data,
            success: function (data)
            {
                $('.ajax-table').html(data.table);
                $('.weak_go_html1').html(data.title);
            }
        });
    }

    function callleaveweekfunction(week = 0)
    {   
        var created_by = $('.week_add_sub1').attr('data-created-by');
        var data = {
            week: week,
            created_by: created_by,
        }

        $.ajax({
            url: '{{ route('holidays.leave_sheet') }}',
            method: 'post',
            data: data,
            success: function (data)
            {
                $('.ajax-table').html(data.table);
                $('.weak_go_html1').html(data.title);
            }
        });
    }
</script>
@endpush
