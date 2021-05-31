{{ Form::model($availability, ['route' => ['availabilities.update', $availability->id], 'method' => 'PUT']) }}
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="row">
                @if(Auth::user()->acount_type == 1)
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('', __('User'), ['class' => 'form-control-label']) }}
                        {!! Form::select('user_id', $filter_employees, null, ['required' => true,  'data-placeholder'=> 'Yours Placeholder' ,'class'=> 'form-control js-single-select']) !!}
                    </div>
                </div>
                @else
                    {!! Form::hidden('user_id', Auth::id() ) !!}
                @endif
                <div class="col-sm-12 col-md-6 col-lg-{{ (Auth::user()->acount_type == 1) ? '2' : '3' }}">
                    <div class="form-group">
                        {{ Form::label('', __('Name'), ['class' => 'form-control-label']) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'required' => '']) }}
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group">
                        {{ Form::label('', __('Start Date'), ['class' => 'form-control-label']) }}
                        {{ Form::date('start_date', null, ['class' => 'form-control', 'required' => true]) }}
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group">
                        {{ Form::label('', __('End Date'), ['class' => 'form-control-label']) }}
                        {{ Form::date('end_date', null, ['class' => 'form-control', 'required' => false]) }}
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-{{ (Auth::user()->acount_type == 1) ? '2' : '3' }}">
                    <div class="form-group">
                        {{ Form::label('', __('Repeat Every'), ['class' => 'form-control-label']) }}
                        {!! Form::select('repeat_week', ['1'=>'Week', '2'=> '2 Week', '3'=> '3 Week', '4'=> '4 Week'], null, ['required' => false, 'data-placeholder'=> 'Yours Placeholder' ,'class'=> 'form-control js-single-select']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12">
            <div id="schedule5" class="jqs-demo mb-3"></div>
        </div>
        <div class="col-sm-12">
            <div class="form-group text-right">
                <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
            </div>
        </div>
    </div>
{{ Form::close() }}
