{{ Form::model($leaverequest, ['route' => ['leave-request.response', $leaverequest->id], 'method' => 'POST', 'id' => '']) }}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {!! $requsst_string !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group"> <span class="request_message">"{{ $leaverequest->message }}"</span> </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('', __('Message'), ['class' => 'form-control-label']) }}
                {{ Form::textarea('response_message', null, ['class' => 'form-control autogrow' ,'rows'=>'2' ,'style'=>'resize: none']) }}
            </div>
        </div>        
        <div class="col-12">
            <div class="form-group">
                <label class="form-control-label"> </label>
                <div class="custom-control custom-switch">                    
                    {{ Form::checkbox('paid_status', 'paid', $paid_status, ['class' => 'custom-control-input' ,'id'=>'customSwitch2']) }}                    
                    <label class="custom-control-label" for="customSwitch2">Unpaid/Paid</label>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="form-group text-right">                
                {{ Form::hidden('leave_approval',null,['class' => 'leave_approval']) }}
                <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto approve_request_button" value="{{ __('Approve') }}" data-ajax-popup="true">
                <input type="submit" class="btn btn-sm btn-danger rounded-pill mr-auto deny_request_button" value="{{ __('Deny') }}" data-ajax-popup="true">
            </div>
        </div>
    </div>
{{ Form::close() }}
