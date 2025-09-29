<div class="d-flex gap-2 align-items-center">
@hasPermission('view_send_notification')
 @if(auth()->user()->hasRole('admin') )
<button type='button' data-assign-module="{{ $data->id }}" data-assign-target='#user_send_push_notification' data-assign-event='employee_assign' class='fs-4 text-success-emphasis border-0 bg-transparent text-nowrap' data-bs-toggle="tooltip" title="Send Push Notification"> <i class="ph ph-paper-plane-tilt"></i></button>
@endif
@endhasPermission


@hasPermission('view_change_password')
<button type='button' data-assign-module="{{ $data->id }}" data-assign-target='#Employee_change_password' data-assign-event='employee_assign' class='fs-4 text-success border-0 bg-transparent' data-bs-toggle="tooltip" title="Change Password"><i class="ph ph-lock-key"></i></button>
@endhasPermission 
@hasPermission('edit_user')
        <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="ph ph-pencil-simple"></i></button>
    @endhasPermission 
 @hasPermission('delete_user') 
        <a href="{{route("backend.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }} : {{$data->full_name}}"> <i class="ph ph-trash"></i></a>
    @endhasPermission 
</div>



