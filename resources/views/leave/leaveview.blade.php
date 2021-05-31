{{ Form::model($leaverequest, ['route' => ['holidays.view-leave-response', $leaverequest->id], 'method' => 'POST','id' => 'leave_request_delete']) }}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">            
            <div class="form-group">
                {!! $string !!}
                {!! $request_message !!}
                {!! $approved_by_name !!}
                {!! $response_message !!}
            </div>
        </div>
        <div class="col-12 {{ $user_type }}">
            <div class="form-group text-right">

                <a href="#" data-ajax-popup="true" data-title="{{__('Edit Leave')}}" data-size="lg" data-url="{{route('holidays.edit', $leaverequest->id)}}" class="action-item ">
                    <input type="button" class="btn btn-sm btn-info rounded-pill mr-auto" value="{{ __('Edit') }}" data-ajax-popup="true">
                </a>

                <a href="#" class="action-item text-danger  leave_request_delete delete_leave_ppp" data-toggle="tooltip" data-original-title="{{__('Delete')}}"
                    data-confirm="{{ __('Are You Sure?') }}|{{ __('This action can not be undone. Do you want to continue?') }}"
                    data-confirm-yes="document.getElementById('delete-form-{{$leaverequest->id}}').submit();" >
                    <input type="button" class="btn btn-sm btn-danger rounded-pill mr-auto" value="{{ __('Delete') }}" data-ajax-popup="true">
                </a>

            </div>

        </div>
    </div>
{{ Form::close() }}

{!! Form::open(['method' => 'DELETE', 'route' => ['holidays.destroy', $leaverequest->id],'class' => 'delete_leave_form' ,'id' => 'delete-form-'.$leaverequest->id]) !!}
{!! Form::close() !!}
