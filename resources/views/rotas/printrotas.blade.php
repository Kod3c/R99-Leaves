
<form method="POST" action="{{ route('rotas.print') }}">
    @csrf
     <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
             {{ Form::hidden('week', $week) }}
             {{ Form::hidden('role_id', $role_id) }}
             {{ Form::hidden('create_by', $create_by) }}
             {{ Form::hidden('location_id', $location_id) }}
             {{ Form::label('', __('Select User'), ['class' => 'form-control-label']) }}
             <br>
             @foreach ($user_array as $key => $val)            
                 <div class="custom-control custom-checkbox d-inline-block mx-3">
                     <input class="custom-control-input user_checkbox" id="{{ 'emp_'.$val['id'] }}" name="user[{{ $key }}]" type="checkbox" value="{{ $val['id'] }}">
                     <label for="{{ 'emp_'.$val['id'] }}" class="custom-control-label">{{ $val['name'] }}</label>
                 </div>
             @endforeach
         </div>
         <div class="col-12">
             <div class="form-group text-right">
                 <input type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" value="{{ __('Save') }}" data-ajax-popup="true">
             </div>
         </div>
     </div>
</form>
 