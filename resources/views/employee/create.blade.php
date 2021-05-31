{{ Form::open(['url' => 'employees', 'enctype' => 'multipart/form-data']) }}
    <div class="form-group">
        <div class="row">
            <div class="col-6">
                {{ Form::label('', __('First Name'), ['class' => 'form-control-label']) }}
                {{ Form::text('first_name', null, ['class' => 'form-control', 'required' => '']) }}
            </div>
            <div class="col-6">
                {{ Form::label('', __('Last Name'), ['class' => 'form-control-label']) }}
                {{ Form::text('last_name', null, ['class' => 'form-control', 'required' => '']) }}
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('', __('Email'), ['class' => 'form-control-label']) }}
        {{ Form::email('email', null, ['class' => 'form-control', 'required' => '']) }}
    </div>
    <div class="form-group">
        {{ Form::label('', __('Employee Role'), ['class' => 'form-control-label']) }}
        {!! Form::select('role_id[]', $role_select, null, ['required' => false, 'multiple' => 'multiple', 'class' => 'form-control js-multiple-select']) !!}
    </div>
    <div class="form-group">
        {{ Form::label('', __('Location'), ['class' => 'form-control-label']) }}
        {!! Form::select('location_id[]', $location_select, null, ['required' => false, 'multiple' => 'multiple', 'class'=> 'form-control js-multiple-select']) !!}
    </div>
    <div class="form-group text-right">
        <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
    </div>
{{ Form::close() }}
