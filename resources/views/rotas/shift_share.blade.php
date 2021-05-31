<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        {{ Form::hidden('loaction_id', $rota['loaction_id']) }}
        {{ Form::hidden('role_id', $rota['role_id']) }}
        {{ Form::hidden('create_by', $rota['create_by']) }}
        {{ Form::hidden('week', $rota['week']) }}
        {{ Form::hidden('user_array', $rota['user_array']) }}
        <div class="form-group">
            {{ __('Share links provide read-only access to your rotas. By default anyone with the link can view all past and future rotas for this location.') }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input set_expiry_date" id="customCheck2" value="yes" name="set_expiry_date">
                <label class="custom-control-label" for="customCheck2">{{ __('Set expiry date') }}</label>
            </div>            
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input set_password" id="customCheck1" value="yes" name="set_password">
                <label class="custom-control-label" for="customCheck1">{{ __('Only people with the password') }}</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 expiry_date_box" style="display: none;">
        <label for="" class="form-control-label">{{ __('Expiry Date') }}</label>
        <div class="form-group">
            <input type="date" name="expiry_date" class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 password_box" style="display: none;">
        <label for="" class="form-control-label">{{ __('Set Password') }}</label>
        <div class="form-group">
            <input type="password" name="share_password" class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12" id="copy_box" style="display: none;">
        <div class="form-group">
            <div class="input-group input-group-merge">
                <input type="link" class="form-control" id="click_link">
                <div class="input-group-prepend pointer" id="click_to_copy">
                    <span class="input-group-text"><i class="fas fa-copy"></i></span>
                </div>                
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group text-right">
            <input type="button" class="btn btn-sm btn-primary rounded-pill mr-auto create_link"
                value="{{ __('Create Link') }}" data-ajax-popup="true">
        </div>
    </div>
</div>