<div class="d-flex gap-2 align-items-center">
    @hasPermission('edit_customtemplate')
        <button type="button" class="fs-4 text-primary border-0 bg-transparent" 
                data-crud-id="{{$data->id}}" 
                title="{{__('Edit')}}" 
                data-bs-toggle="tooltip">
            <i class="ph ph-pencil-simple"></i>
        </button>
    @endhasPermission
    
    @hasPermission('delete_customtemplate')
    <a href="your-delete-route-url"
    id="delete-module_name-123"
    class="fs-4 text-danger"
    data-type="ajax"
    data-method="DELETE"
    data-token="your-csrf-token"
    data-bs-toggle="tooltip"
    title="Delete"
    data-confirm="{{ __('messages.are_you_sure?') }}  {{$data->template_name}} {{ __('messages.Custom_Template') }}">
    <i class="ph ph-trash"></i>
 </a>
 
     
    @endhasPermission
</div>
