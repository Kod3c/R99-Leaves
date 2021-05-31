{{ Form::open(['url' => 'roles', 'enctype' => 'multipart/form-data']) }}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('', __('Name'), ['class' => 'form-control-label']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => '']) }}
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">                
                {{ Form::label('', __('Default Break'), ['class' => 'form-control-label']) }}
                {{ Form::number('default_break', null, ['class' => 'form-control', 'placeholder' => __('0 Minutes')]) }}
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                {{ Form::label('', __('Colour'), ['class' => 'form-control-label']) }}
                {{ Form::input('color', 'color', '#eeeeee', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('', __(' Employee'), ['class' => 'form-control-label']) }}
                {!! Form::select('employees[]', $employees_select, null, ['required' => false, 'multiple' => 'multiple', 'data-placeholder'=> 'Yours Placeholder' ,'class'=> 'form-control js-multiple-select']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group text-right">
                <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
            </div>
        </div>
    </div>
{{ Form::close() }}
