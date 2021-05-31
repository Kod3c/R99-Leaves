{{ Form::open(['url' => 'store-language']) }}

<div class="form-group">    
    {{ Form::label('', __('Language Code'), ['class' => 'form-control-label']) }}
    {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => __('Enter new Language Code'), 'required' => 'required']) }}
</div>

<div class="form-group text-right">
    <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
</div>
{{ Form::close() }}

