{{ Form::model($annual_holiday, ['route' => ['holidays.annual-leave-response', $annual_holiday->id], 'method' => 'POST']) }}
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('', __('Annual Holiday Allowance'), ['class' => 'form-control-label']) }}
                <div class="row">
                    <div class="col-sm-7 ">                        
                        {{ Form::number('leave[time]', $holiday['time'], ['class' => 'form-control'] ) }}                
                    </div>
                    <div class="col-sm-5 ">
                        {!! Form::select('leave[type]', ['day' => __('Day')], $holiday['type'], ['class'=> 'form-control js-single-select']) !!}
                    </div>
                </div>
                <span class="clearfix"> </span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            {{ Form::label('', __('Apply To'), ['class' => 'form-control-label']) }}
            <div class="form-group">                
                {!! Form::select('leave[apply_to]', ['all_year' => __('Default Allowance')], $holiday['apply_to'], ['class'=> 'form-control js-single-select']) !!}                
            </div>
        </div>
        <div class="col-12">
            <div class="form-group text-right">
                <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
            </div>
        </div>
    </div>
{{ Form::close() }}
