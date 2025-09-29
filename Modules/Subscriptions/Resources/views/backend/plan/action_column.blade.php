<div class="d-flex gap-2 align-items-center">
    @hasPermission('edit_subscriptions_plan')
        <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="ph ph-pencil-simple"></i></button>
    @endhasPermission
    @hasPermission('delete_subscriptions_plan')
        <a href="{{route("backend.subscription.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger btn-sm" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }} : {{$data->name}}"> <i class="ph ph-trash"></i></a>
    @endhasPermission
</div>



