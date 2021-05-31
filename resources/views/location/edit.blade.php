{{ Form::model($location, ['route' => ['locations.update', $location->id], 'method' => 'PUT']) }}
    <div class="form-group">
        {{ Form::label('', __('Name'), ['class' => 'form-control-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'required' => '']) }}
    </div>
    <div class="form-group">
        {{ Form::label('', __('Address'), ['class' => 'form-control-label']) }}
        {{ Form::textarea('address', null, ['class' => 'form-control autogrow' ,'rows'=>'1' ,'style'=>'resize: none' ,'required' => '']) }}
    </div>
    <div class="form-group">
        {{ Form::label('', __(' Employee'), ['class' => 'form-control-label']) }}
        {!! Form::select('employees[]', $employees_select, null, ['required' => false, 'multiple' => 'multiple', 'data-placeholder'=> 'Yours Placeholder' ,'class'=> 'form-control js-multiple-select']) !!}
    </div>
    <div class="form-group text-right">
        <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
    </div>
{{ Form::close() }}
