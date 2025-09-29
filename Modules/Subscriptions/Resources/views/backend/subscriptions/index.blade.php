@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <x-backend.section-header>
                <div>
                    <x-backend.quick-action url='{{ route("backend.$module_name.bulk_action") }}'>
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
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="ph ph-magnifying-glass"></i></span>
                        <input type="text" class="form-control form-control-sm dt-search"
                            placeholder="{{ __('messages.search') }}.." aria-label="Search"
                            aria-describedby="addon-wrapping">
                    </div>

                </x-slot>
            </x-backend.section-header>
        </div>
        <div class="card-body p-0">

            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>

    <div data-render="app">

        <x-backend.advance-filter>
            <x-slot name="title">
                <h4>{{ __('messages.lbl_advanced_filter') }}</h4>
            </x-slot>
            <select name="" id="" class="select2">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </x-backend.advance-filter>
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush
@push('after-scripts')
    <script src="{{ mix('modules/subscriptions/script.js') }}"></script>
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
                data: 'user_id',
                name: 'user_id',
                title: "{{ __('plan.lbl_name') }}"
            },
            {
                data: 'name',
                name: 'name',
                title: "{{ __('plan.plan_title') }}"
            },
            {
                data: 'plan',
                name: 'plan',
                title: "{{ __('plan.lbl_type_duration') }}",
                searchable: false,
                orderable: false,
            },
            {
                data: 'plan_type',
                name: 'plan_type',
                title: "{{ __('plan.Plan_Limitation') }}"
            },
            {
                data: 'amount',
                name: 'amount',
                title: "{{ __('plan.lbl_amount') }}"
            },
            {
                data: 'date',
                name: 'date',
                title: "{{ __('plan.lbl_start_date') }}"
            },
            {
                data: 'end_date',
                name: 'end_date',
                title: "{{ __('plan.end_date') }}"
            },
            {
                data: 'status',
                name: 'status',
                title: "{{ __('plan.status') }}"
            }, // Add this line
        ];


        let finalColumns = [
            ...columns,
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
            })
        })

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

        $(document).on('update_quick_action', function() {

        })
    </script>
@endpush
