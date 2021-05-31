{{ Form::model($user_array, ['route' => ['rotas.add_remove_employee'], 'method' => 'get']) }}
<div class="row">        
    <div class="col-xs-12 col-sm-12 col-md-12">        
        {{ Form::hidden('id_array', $id_array) }}
        {{ Form::hidden('location', $location) }}
        @foreach ($user_array as $val)
            <div class="custom-control custom-checkbox d-inline-block mx-3">
                <input class="custom-control-input" id="{{ $val['profile_id'] }}" name="{{ $val['profile_id'] }}" type="checkbox" value="{{ $val['loaction_id'] }}" {{ ($val['has_location'] == 1) ? 'checked' : '' }}>
                <label for="{{ $val['profile_id'] }}" class="custom-control-label">{{ $val['name'] }}</label>
            </div>
        @endforeach
    </div>
    <div class="col-12">
        <div class="form-group text-right">
            <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
        </div>
    </div>
</div>
{{ Form::close() }}
