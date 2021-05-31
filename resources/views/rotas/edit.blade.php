{{ Form::model($rotas, ['route' => ['rotas.update', $rotas->id], 'method' => 'PUT', 'class' => 'rotas_edit_frm']) }}
{{-- <form method="post" class='rotas_ctrate_location rotas_edit_frm'> --}}
    <div class="row">
        {{ Form::input('hidden', 'u_url', route('rotas.update', $rotas->id)) }}
        {{ Form::input('hidden', 'rotas_id', $rotas->id) }}
        {{ Form::input('hidden', 'user_id', $user_id) }}
        {{ Form::input('hidden', 'rotas_date', $date) }}
        {{ Form::input('hidden', 'location_id', null, array('id' => 'rotas_ctrate_location')) }}
        <div class="col-4">
            <div class="form-group">
                {{ Form::label('', __('Start Time'), ['class' => 'form-control-label']) }}
                {{ Form::input('time', 'start_time', null, array('class' => 'form-control start_time rotas_time', 'required' => true)) }}
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                {{ Form::label('', __('End Time'), ['class' => 'form-control-label']) }}
                {{ Form::input('time', 'end_time', null, array('class' => 'form-control end_time rotas_time', 'required' => true)) }}
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                {{ Form::label('', __('Break'), ['class' => 'form-control-label']) }}
                {{ Form::input('number', 'break_time', null, array('class' => 'form-control', 'required' => true)) }}
            </div>            
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('', __('Role'), ['class' => 'form-control-label']) }}
                {!! Form::select('role_id', $role_option,  null, ['data-placeholder'=> __('Select Role') ,'class'=> 'form-control js-single-select']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('', __('Note'), ['class' => 'form-control-label']) }}
                {{ Form::textarea('note', null, ['class' => 'form-control autogrow' ,'rows'=>'2' ,'style'=>'resize: none']) }}
                <small>{{ __('Employees can only see notes for their own shifts') }}</small>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group text-right">
                {{-- <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto rotas_edit_btn" value="{{ __('Save') }}" data-ajax-popup="true"> --}}
                <input type="button" class="btn btn-sm btn-primary rounded-pill mr-auto rotas_edit_btn" value="{{ __('Save') }}" data-ajax-popup="true">
            </div>
        </div>
    </div>
{{-- </form> --}}
{{ Form::close() }}
