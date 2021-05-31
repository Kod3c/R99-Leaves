    {{ Form::model($rota, ['route' => ['rotas.shift.disable.reply'], 'method' => 'post']) }}
<div class="row">        
    <div class="col-xs-12 col-sm-12 col-md-12">        
        {{ Form::hidden('rota_id', $rota->id) }}        
        <p>{{ $msg }}</p>
        <div class="form-group">
            {{ Form::label('', __("Unavailability Reason"), ['class' => 'form-control-label']) }}
            {{ Form::textarea('shift_cancel_employee_msg', null, ['class' => 'form-control autogrow' ,'rows'=>'2' ,'style'=>'resize: none', 'readonly' => true, 'disabled' => true]) }}            
        </div>

        <div class="form-group">
            {{ Form::label('', __("Reply"), ['class' => 'form-control-label']) }}
            {{ Form::textarea('shift_cancel_owner_msg', null, ['class' => 'form-control autogrow' ,'rows'=>'2' ,'style'=>'resize: none']) }}
        </div>
        <div class="form-group">
            {{ Form::label('', __("Unavailability Requested"), ['class' => 'form-control-label']) }}
            <br>
            <div class="btn-group btn-group-toggle rounded border border-primary" data-toggle="buttons">
                <label class="btn btn-sm btn-primary active">
                    <input type="radio" name="shift_status"  checked value="disable"> {{ __('Approve') }}
                </label>
                <label class="btn btn-sm btn-primary">
                    <input type="radio" name="shift_status"  value="enable"> {{ __('Deny') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group text-right">
            <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
        </div>
    </div>
</div>
{{ Form::close() }}
