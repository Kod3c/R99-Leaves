@extends('layouts.main')
@section('page-title')
    {{ __('Availability') }}
@endsection
@section('availabilitylink')    
    <link rel="stylesheet" href="{{ asset('assets/libs/jquery-schedule-master/dist/jquery.schedule.css')}}">    
@endsection

@section('content')
    <!-- Page content -->
    <div class="page-content">
        <!-- Page title -->
        <div class="page-title">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                    <div class="d-inline-block">
                        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{ __('Availability') }}</h5>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                    <button type="button" class="btn btn-sm btn-white btn-icon-only rounded-circle add_schedule" title="{{__('Add New Availability')}}" data-size="xl" data-ajax-popup="true" data-title="{{__('Add New Availability Pattern')}}"
                    data-url="{{route('availabilities.create')}}"><span class="btn-inner--icon"><i class="fas fa-plus"></i></span></button>

                    @if(Auth::user()->acount_type == 1)
                    <div class='w-30'>
                        {!! Form::select('user_id', $filter_employees, null, ['required' => true,  'data-placeholder'=> 'Yours Placeholder' ,'class'=> 'form-control js-single-select search-user-ava']) !!}
                    </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center avalabilty_table">
                        <thead>
                        <tr>
                            @if(Auth::user()->type == 'company')
                                <th scope="col">{{ __('Name') }}</th>
                            @endif
                            <th scope="col">{{ __('Title') }}</th>
                            <th scope="col">{{ _('Effective Dates') }}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>        
                            @if(!empty($availabilitys) && count($availabilitys) > 0)
                                @foreach ($availabilitys as $availability)
                                    <tr data-id="{{ $availability->user_id }}">
                                        @if(Auth::user()->type == 'company')
                                            <td> {{ $availability->getUserInfo->first_name }} {{ $availability->getUserInfo->last_name }}</td>
                                        @endif
                                        <td> {{ $availability->name }}</td>
                                        <td> {{ $availability->getAvailabilityDate() }} </td>
                                        <td class="text-right rtl-actionsi">                                        
                                            <button type="button" class="btn-white rounded-circle border-0 edit_schedule" data-availability-json="{{ $availability->availability_json }}">
                                                <span class="btn-inner--icon action-item">
                                                    <a href="#" data-ajax-popup="true" data-title="{{__('Edit Request')}}" data-size="xl"
                                                    data-url="{{route('availabilities.edit', $availability->id)}}"
                                                    class="action-item "><i class="fas fa-pencil-alt" data-toggle="tooltip" title="{{ __('Edit') }}"></i></a>
                                                </span>
                                            </button>

                                            <button type="button" class="btn-white rounded-circle border-0">
                                                <span class="btn-inner--icon action-item text-danger">
                                                    <a href="#" class="action-item text-danger" data-toggle="tooltip" data-original-title="{{__('Delete')}}"
                                                    data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="document.getElementById('delete-form-{{$availability->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </span>
                                            </button>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['availabilities.destroy', $availability->id],'id' => 'delete-form-'.$availability->id]) !!}
                                            {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                            <tr>
                                @if(Auth::user()->type == 'company')                                    
                                <td colspan="4">
                                @else
                                <td colspan="3">
                                @endif
                                    <div class="text-center">
                                        <i class="fas fa-file text-primary fs-40"></i>
                                        <h2>{{ __('Opps...') }}</h2>
                                        <h6> {!! __('No availability found...!') !!} </h6>
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

@section('availabilityscriptlink')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script id="add_schedule" src="{{ asset('assets/libs/jquery-schedule-master/dist/jquery.schedule.js')}}" data-src="{{ asset('assets/libs/jquery-schedule-master/dist/jquery.schedule.js')}}"></script>
    <script id="edit_schedule" src="{{ asset('assets/libs/jquery-schedule-master/dist/jquery.scheduleedit.js')}}" data-src="{{ asset('assets/libs/jquery-schedule-master/dist/jquery.scheduleedit.js')}}"  ></script>
    <script>
    function availabilitytablejs(){
        $('#schedule4').jqs({
            periodColors: [
                ['rgba(0, 200, 0, 0.5)', '#0f0', '#000'],
                ['rgba(200, 0, 0, 0.5)', '#f00', '#000'],
            ],
            periodTitle: '',
            periodBackgroundColor: 'rgba(0, 200, 0, 0.5)',
            periodBorderColor: '#000',
            periodTextColor: '#fff',
            periodRemoveButton: 'Remove please !',
            onRemovePeriod:function (period, jqs) { },
            onAddPeriod:function (period, jqs) { },
            onClickPeriod:function (period, jqs) { },
            onDuplicatePeriod:function (event, period, jqs) { },
            onPeriodClicked:function (event, period, jqs) { }
        });
    }

    function editavailabilitytablejs(data = []) {
        $('#schedule5').jqs({
            data: data,
            days: 7,
            periodColors: [
                ['rgba(0, 200, 0, 0.5)', '#0f0', '#000'],
                ['rgba(200, 0, 0, 0.5)', '#f00', '#000'],
            ],
            periodTitle: '',
            periodBackgroundColor: 'rgba(0, 200, 0, 0.5)',
            periodBorderColor: '#000',
            periodTextColor: '#fff',
            periodRemoveButton: 'Remove please !',            
            onRemovePeriod:function (period, jqs) { },
            onAddPeriod:function (period, jqs) { },
            onClickPeriod:function (period, jqs) { },
            onDuplicatePeriod:function (event, period, jqs) { },
            onPeriodClicked:function (event, period, jqs) { }
        });
    }
    </script>
@endsection

@push('pagescript')
<script>
    $(document).ready(function() {
        $(document).on('change','.search-user-ava', function () {
            var value = $(this).val();
            $('.avalabilty_table tbody>tr').hide();
            if(value == 'all0')
            {
                $('.avalabilty_table tbody>tr').show();
            }
            else
            {
                $('.avalabilty_table tbody>tr[data-id="'+value+'"]').show();
            }
        });
    });
</script>
@endpush
