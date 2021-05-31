{{ Form::model($employee, ['route' => ['employee.addpassword', $employee->id], 'method' => 'POST']) }}
    {{ Form::hidden('employee_id', $employee->id) }}
    {{ Form::hidden('form_type', 'manage_permission') }}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('', __('Set Password'), ['class' => 'form-control-label']) }}                               
                {{ Form::password('password', ['class' => 'form-control', 'required' => '']) }}
            </div>
        </div>
    </div>
    <div class="text-right">
        <input name="from" type="hidden" value="password">
        <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{ __('Save') }}</button>
    </div>
{{ Form::close() }}