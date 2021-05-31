{{ Form::model($rota, ['route' => ['rotas.shift.disable'], 'method' => 'post']) }}
<div class="row">        
    <div class="col-xs-12 col-sm-12 col-md-12">        
        {{ Form::hidden('rota_id', $rota->id) }}        
        {{ Form::hidden('shift_status', 'request') }}        
        <div class="form-group">
            {{ Form::label('', __("Can't work this shift ?"), ['class' => 'form-control-label']) }}
            {{ Form::textarea('shift_cancel_employee_msg', null, ['class' => 'form-control autogrow' ,'rows'=>'2' ,'style'=>'resize: none']) }}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group text-right">
            <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
        </div>
    </div>
</div>
{{ Form::close() }}
