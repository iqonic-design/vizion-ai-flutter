@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/category/style.css') }}">
@endpush

@section('content')
    <div class="card">
    <div class="card-header">
        <x-backend.section-header>
            <div>
              <x-backend.quick-action url='{{route("backend.reports.bulk_action")}}'>
                {{-- <x-backend.quick-action> --}}
                <div class="">
                  <select name="action_type" class="form-control select2 col-12" id="quick-action-type" style="width:100%">
                      <option value="">{{ __('messages.no_action') }}</option>
                      <option value="delete">{{ __('messages.delete') }}</option>
                  </select>
                </div>

              </x-backend.quick-action>
            </div>
            <x-slot name="toolbar">

                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="ph ph-magnifying-glass"></i></span>
                  <input type="text" class="form-control form-control-sm dt-search" placeholder="{{ __('messages.search')}}.." aria-label="Search" aria-describedby="addon-wrapping">

                </div>

            </x-slot>





          </x-backend.section-header>
    </div>
        <div class="card-body p-0">
          <table id="datatable" class="table table-striped border table-responsive">
          </table>
        </div>
    </div>


@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('modules/category/script.js') }}"></script>


    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>

    const columns = [
            {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            // { data: 'image', name: 'image', title: "{{ __('category.lbl_image') }}", width: '5%', orderable: false,},
            {
            data: 'user_id',
            name: 'user_id',
            title: "{{__('customer.lbl_name')}}",
            orderable: true,
            searchable: true,
        },
            { data: 'tool_type', name: 'tool_type',  title: "{{ __('category.lbl_system_service') }}", width: '15%'},
            { data: 'reason', name: 'reason',  title: "{{ __('category.reason') }}",width: '15%' },
        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: "{{ __('category.lbl_action') }}", width: '5%'}
        ]


        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [[ 2, 'desc' ]],
            })
        })




      function resetQuickAction () {
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

      $('#quick-action-type').change(function () {
        resetQuickAction()
      });

      $(document).on('update_quick_action', function() {
        // resetActionButtons()
      })

    </script>
@endpush
