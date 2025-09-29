@extends('backend.layouts.app', ['isNoUISlider' => true])

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/service/style.css') }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <x-backend.section-header>
                    <div>
                       
                        <x-backend.quick-action url="{{ route('backend.services.bulk_action') }}">
                            <div class="">
                                <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                    style="width:100%">
                                    <option value="">{{ __('messages.no_action') }}</option>
                                    <option value="change-status">{{ __('messages.status') }}</option>
                                    <option value="delete">{{ __('messages.delete') }}</option>
                                </select>
                            </div>
                            <div class="select-status d-none quick-action-field" id="change-status-action">
                                <select name="status" class="form-control select2" id="status" style="width:100%">
                                    <option value="1">{{ __('messages.active') }}</option>
                                    <option value="0">{{ __('messages.inactive') }}</option>
                                </select>
                            </div>
                        </x-backend.quick-action>
                    </div>
                    <x-slot name="toolbar">
                        <div>
                            <div class="datatable-filter">
                                <select name="column_status" id="column_status" class="select2 form-control"
                                    data-filter="select" style="width: 100%">
                                    <option value="">{{__('service.lbl_all')}}</option>
                                    <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                        {{ __('messages.inactive') }}</option>
                                    <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                        {{ __('messages.active') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="ph ph-magnifying-glass"></i></span>
                            <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
                            
                        </div>
                        @hasPermission('add_service')
                            <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('Create') }} {{ __($create_title) }}" class=" d-flex align-items-center gap-1">
                            {{ __('messages.new') }}</x-buttons.offcanvas>
                        @endhasPermission
                        
                    </x-slot>
                </x-backend.section-header>
        </div>
        <div class="card-body ">            
            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>
    <div data-render="app">
        <service-form-offcanvas create-title="{{ __('messages.create') }} {{ __($create_title) }}" default-image="{{default_feature_image()}}"
            edit-title="{{ __('messages.edit') }} {{ __($create_title) }}" :customefield="{{ json_encode($customefield) }}">
        </service-form-offcanvas>
        <gallery-form-offcanvas></gallery-form-offcanvas>
    </div>
   
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('modules/service/script.js') }}"></script>
    <script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>

    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>
        const columns = [{
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            {
                data: 'image',
                name: 'image',
                title:  "{{ __('service.lbl_image') }}",
                orderable: false,
                width: '0%'
            },
            {
                data: 'name',
                name: 'name',
                title: "{{ __('service.lbl_service_name') }}"
            },
         
            {
                data: 'category_id',
                name: 'category_id',
                title: "{{ __('service.lbl_category') }}"
            },
            { 
                data: 'updated_at', 
                name: 'updated_at',  
                title: "{{ __('service.lbl_updated_at') }}", 
                width: '15%',
                visible: false
            },
    
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true,
                title: "{{ __('service.lbl_status') }}",
                width: '5%'
            },
        ]


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('service.lbl_action') }}",
            width: '5%'
        }]

        const customFieldColumns = JSON.parse(@json($columns))

        let finalColumns = [
            ...columns,
            ...customFieldColumns,
            ...actionColumn
        ]


        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [[ 6, 'desc' ]],
                advanceFilter: () => {
                    return {
                      

                        
                    }
                }
            });

            // Event listener for category selection change
          
          
            $('#reset-filter').on('click', function(e) {
               
                window.renderedDataTable.ajax.reload(null, false);
            });

            // Initialize subcategory options based on the initial selected category
          
        });


        function resetQuickAction() {
            const actionValue = $('#quick-action-type').val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');

                if (actionValue == 'change-status') {
                    $('.quick-action-field').addClass('d-none');
                    $('#change-status-action').removeClass('d-none');
                } else {
                    $('.quick-action-field').addClass('d-none');
                }
            } else {
                $('#quick-action-apply').attr('disabled', true);
                $('.quick-action-field').addClass('d-none');
            }
        }

        $('#quick-action-type').change(function() {
            resetQuickAction()
        });
    </script>
@endpush
