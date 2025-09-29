<div class="d-flex gap-2 align-items-center">
  <!-- <button type='button' data-assign-module="{{ $data->id }}" data-assign-target='#Employee_change_password' data-assign-event='employee_assign' class='btn btn-info-subtle btn-sm rounded text-nowrap' data-bs-toggle="tooltip" title="Change Password"><i class="ph ph-lock-key"></i></button> -->
      @hasPermission('edit_app_banner')
          <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="ph ph-pencil-simple"></i></button>
      @endhasPermission
      @hasPermission('delete_app_banner')
          <a href="{{route("backend.app-banners.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash"></i></a>
      @endhasPermission
  </div>



