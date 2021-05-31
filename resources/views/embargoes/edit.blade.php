{{ Form::model($embargo, ['route' => ['embargoes.update', $embargo->id], 'method' => 'PUT']) }}
<div class="row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('', __('Start Date'), ['class' => 'form-control-label']) }}
            {{ Form::date('start_date', null, ['class' => 'form-control start_date' ,'id' => 'date_between' ,'required' => '']) }}
            {{ Form::hidden('issue_by', Auth::user()->id, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('', __('End Date'), ['class' => 'form-control-label']) }}
            {{ Form::date('end_date', null, ['class' => 'form-control end_date', 'id' => 'date_between', 'required' => '']) }}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('', __('Message'), ['class' => 'form-control-label']) }}
            {{ Form::textarea('message', null, ['class' => 'form-control autogrow' ,'rows'=>'2' ,'style'=>'resize: none']) }}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('', __(' Employee'), ['class' => 'form-control-label']) }}
            {!! Form::select('employees[]', $employees_select, $embargo_employees, ['required' => false, 'multiple' => 'multiple', 'data-placeholder'=> 'Yours Placeholder' ,'class'=> 'form-control js-multiple-select']) !!}
        </div>
    </div>

    <div class="col-12">
        <div class="form-group text-right">
            <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
        </div>
    </div>
</div>
{{ Form::close() }}
