@extends('layouts.main')

@section('page-title')
    {{ __('Day View') }}
@endsection

@section('content')
<style>
.ui-datepicker-calendar {
    display: none;
}
</style>
    <div class="page-content">
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col d-flex align-items-center">
                    <h5 class="fullcalendar-title h4 d-inline-block font-weight-400 mb-0 text-white">{{ $cur_year.'-'.$cur_month }}
                    </h5> &nbsp;&nbsp;
                    <div class="btn-group" role="group" aria-label="Basic example" data-month="{{ $cur_month }}" data-year="{{ $cur_year }}">
                        <a class="btn btn-sm btn-neutral date_sub date_click">
                            <i class="fas fa-angle-left"></i>
                        </a>
                        <a class="btn btn-sm btn-neutral date_add date_click">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right rtl-home-menu rtl-home-menu">
                    <div class="d-inline-block">
                        <a href="#" class="btn btn-sm btn-white btn-icon-only rounded-circle shadow-sm day_view_filter_btn" title="filter"> <i
                                class="fa fa-filter"></i> </a>
                    </div>

                    <div class="d-inline-block">
                        <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-1" data-toggle="dropdown"
                            title="{{ __('View') }}">
                            <a href="#" class="text-dark" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right employee_menu_listt dropdown-menulist-scroll">
                                <a href="{{ url('dashboard') }}"
                                    class="dropdown-item {{ Request::segment(1) == 'dashboard' ? 'calender_active' : '' }}"
                                    onclick="window.location.href=this;">{{ __('Calendar View') }}</a>
                                <a href="{{ url('day') }}"
                                    class="dropdown-item {{ Request::segment(1) == 'day' ? 'calender_active' : '' }}"
                                    onclick="window.location.href=this;">{{ __('Daily View') }}</a>
                                <a href="{{ url('user-view') }}" 
                                    class="dropdown-item {{ Request::segment(1) == 'user-view' ? 'calender_active' : '' }}"
                                    onclick="window.location.href=this;">{{ __('User View') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card day_view_filter" style="display: none;">
            <div class="card-body p-3 m-0 mt-2">
                <div class="row">
                    <div class="form-group col-md-3 mb-0">
                        {{ Form::label('', __('Date'), ['class' => 'form-control-label']) }}
                        <input type="month" class="rota_date form-control h_40i" style="height: 40px;" id="datepicker" value="{{ $cur_year.'-'.$cur_month }}">
                    </div>
                    <div class="form-group col-md-3 mb-0 cus_select_h_40">
                        {{ Form::label('', __('Employee'), ['class' => 'form-control-label']) }}
                        {!! Form::select('emp_name[]', $employee_data, null, ['required' => false, 'multiple' => 'multiple', 'class'=> 'form-control js-multiple-select emp_name']) !!}
                    </div>
                    <div class="form-group col-md-3 mb-0 cus_select_h_40">
                        {{ Form::label('', __('Location'), ['class' => 'form-control-label']) }}
                        {!! Form::select('loaction_name[]', $location_option, null, ['required' => false, 'multiple' => 'multiple', 'class'=> 'form-control js-multiple-select loaction_name']) !!}
                    </div>
                    <div class="form-group col-md-3 mb-0 cus_select_h_40">
                        {{ Form::label('', __('Role'), ['class' => 'form-control-label']) }}
                        {!! Form::select('role_name[]', $role_option, null, ['required' => false, 'multiple' => 'multiple', 'class'=> 'form-control js-multiple-select role_name']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="card  m-0 mt-4">
            <!-- Card header -->
            <div class="card-header actions-toolbar border-0">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <h6 class="d-inline-block mb-0">{{ __('User View') }}</h6>
                    </div>
                    <div class="col text-right">
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive day_view_tbl">
                <table class="table align-items-center">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Time') }}</th>
                            <th>{{ __('Break') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Revenue') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($rotas) && count($rotas) != 0)
                            @foreach ($rotas as $rota)
                                <tr>
                                    <th>
                                        <div class="media align-items-center">
                                            <div>
                                                <div class="avatar-parent-child">
                                                    <img src="{{ asset(Storage::url($rota->userprofile($rota->user_id))) }}"
                                                        class="avatar  rounded-circle">
                                                </div>
                                            </div>
                                            <div class="media-body ml-4">
                                                <a href="#"
                                                    class="d-block name h6 mb-0 text-sm">{{ !empty($rota->getrotauser->first_name) ? $rota->getrotauser->first_name : '' }}</a>
                                                <div class="d-inline-block day_view_dot"
                                                    style="background-color: {{ $rota->getrotarole->color }}"></div>
                                                <small class="d-inline-block font-weight-bold">{{ $rota->getrotarole->name }}</small>
                                            </div>
                                        </div>
                                    </th>
                                    <td> {{ $rota->rotas_date }} </td> 
                                    <td> {{ \App\User::CompanyTimeFormat($rota->start_time) }} -
                                        {{ \App\User::CompanyTimeFormat($rota->end_time) }} </td>
                                    <td> {{ $rota->break_time . __('Min') }} </td>
                                    <td> {{ $rota->getrotalocation->name }} </td>
                                    <td> {{ $rota->rota_cost($rota) }} </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <div class="text-center">
                                        <i class="fas fa-calendar-times text-primary fs-40"></i>
                                        <h2>{{ __('Opps...') }}</h2>
                                        <h6> {!! __('No rotas found.') !!} </h6>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection

@push('pagescript')
    <script>



        $(document).on('click', '.day_view_filter_btn', function(e) {
            $('.day_view_filter').slideToggle(500);
        });

        $(document).on('click', '.date_click', function(e) {
            var rota_date = $('.rota_date').val()+'-01';
            var rota_date12 = $('.rota_date').val();
            var futureMonth = rota_date12;
            if($(this).hasClass('date_sub'))
            {
               var futureMonth = moment(rota_date).subtract(1, 'month').format("YYYY-MM");               
            }
            if($(this).hasClass('date_add'))
            {
                var futureMonth = moment(rota_date).add(1, 'month').format("YYYY-MM");
            }
            $('.rota_date').val(futureMonth);
            $('.fullcalendar-title').html(futureMonth);
            $('.rota_date').trigger('change');
        });
        
        $(document).on('change', '.emp_name', function(e) {
            var date_type = 'date';
            dayviewfilter(date_type);
        });
        
        $(document).on('change', '.loaction_name', function(e) {
            var date_type = 'date';
            dayviewfilter(date_type);
        });
        
        $(document).on('change', '.role_name', function(e) {
            var date_type = 'date';
            dayviewfilter(date_type);
        });
        
        $(document).on('change', '.rota_date', function(e) {
            var date_type = 'date';
            dayviewfilter(date_type);
        });

        function dayviewfilter(date_type = 'date') {
            var date = $('.rota_date').val();
            var emp_name = $('.emp_name').val();
            var loaction_name = $('.loaction_name').val();
            var role_name = $('.role_name').val();

            var data = {
                date            : date,
                date_type       : date_type,
                emp_name        : emp_name,
                loaction_name   : loaction_name,
                role_name       : role_name,
            }

            $.ajax({
                url: '{{ route('userviewfilter') }}',
                method: 'POST',
                data: data,
                success: function (data)
                {
                    $('.day_view_tbl').html(data.returnHTML);                    
                }
            });
        }

    </script>
@endpush
