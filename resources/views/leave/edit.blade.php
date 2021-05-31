{{ Form::model($leave, ['route' => ['holidays.update', $leave->id], 'method' => 'PUT','id' => 'leave_request_delete']) }}
    <div class="row">
        <div class="col-sm-12 col-md-7 col-sm-7">
            <div class="form-group">
                {{ Form::label('', __('Employee'), ['class' => 'form-control-label']) }}
                {!! Form::select('user_id[]', $employees_select, null, ['required' => true, 'multiple' => 'multiple', 'data-placeholder'=> 'Yours Placeholder' ,'class'=> 'form-control js-multiple-select']) !!}
            </div>
        </div>

        <div class="col-sm-12 col-md-5 col-lg-5">
            <div class="form-group">
                {{ Form::label('', __('Type'), ['class' => 'form-control-label']) }}                
                {!! Form::select('leave_type', ['1' => 'Holiday', '2' => 'Other Leave'], null, ['required' => true, 'data-placeholder'=> 'Yours Leave Type' ,'class'=> 'form-control js-single-select']) !!}
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                {{ Form::label('', __('Start Date'), ['class' => 'form-control-label']) }}
                {{ Form::date('start_date', null, ['class' => 'form-control leave_date_start' ,'required' => '']) }}
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                {{ Form::label('', __('End Date'), ['class' => 'form-control-label']) }}
                {{ Form::date('end_date', null, ['class' => 'form-control leave_date_due', 'required' => '']) }}
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                {{ Form::label('', __(''), ['class' => 'form-control-label']) }}
                <div class="custom-control custom-switch">
                    {{ Form::checkbox('paid_status', 'paid', (!empty($paid_status)) ? true : false , ['class' => 'custom-control-input', 'id' => 'customSwitch1dsad']) }}
                    <label class="custom-control-label form-control-label" for="customSwitch1dsad">{{__('Unpaid/Paid')}}</label>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                {{ Form::label('', __('Days'), ['class' => 'form-control-label']) }}
                {{ Form::number('days', null, ['class' => 'form-control leave_days', 'readonly' => true , 'disabled'=> true, 'required' => false]) }}
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                {{ Form::label('', __('Record Hours'), ['class' => 'form-control-label']) }}                
                {!! Form::select('leave_time_type', ['total' => 'Total', 'daily' => 'Daily'], (!empty($leave_time['leave_time_type'])) ? $leave_time['leave_time_type'] : null, ['required' => true, 'data-placeholder'=> 'Yours Time Type' ,'class'=> 'form-control js-single-select total_daily_hour']) !!}
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group total_all_hour " >
                {{ Form::label('', __('Total Hours'), ['class' => 'form-control-label']) }}
                {{ Form::number('leave_time1', (!empty($leave_time['leave_time1'])) ? $leave_time['leave_time1'] : null, ['class' => 'form-control', 'required' => false]) }}
            </div>
            <div class="form-group total_date_hour " >
                {!! (!empty($leave_time['leave_time_by_dail_hour'])) ? $leave_time['leave_time_by_dail_hour'] : null !!}
                <span class="clearfix"></span>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                {{ Form::label('', __('Message'), ['class' => 'form-control-label']) }}
                {{ Form::textarea('message', null, ['class' => 'form-control autogrow' ,'rows'=>'2' ,'style'=>'resize: none']) }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group text-right">
                <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
            </div>
        </div>
    </div>
{{ Form::close() }}
