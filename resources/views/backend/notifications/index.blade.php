@extends('backend.layouts.app')

@section('title', __($module_title))

@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush

@section('content')
<div class="card mb-4">
    <div class="card-body p-0">
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped border notification-table">
                        <thead>
                            <tr>
                                <th>{{ __('notification.lbl_id') }}</th>
                                <th>{{ __('notification.type') }}</th>
                                <th>{{ __('notification.lbl_text') }}</th>
                                <th>{{ __('notification.lbl_customer') }}</th>
                                <th>{{ __('notification.lbl_update') }}</th>
                                <th>{{ __('notification.lbl_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @forelse($$module_name as $module_name_singular)
                                <?php
                                    $row_class = '';
                                    $span_class = '';
                                    if ($module_name_singular->read_at == '') {
                                        $row_class = 'table-info';
                                        $span_class = 'font-weight-bold';
                                    }
                                ?>

                                <input type="hidden" id="idData" value="{{$module_name_singular->id}}">

                                <tr class="{{$row_class}}">
                                    <td><span class="{{$span_class}}">{{ $counter++ }}</span></td>
                                    @if($module_name_singular->data['data']['notification_type'] == 'new_subscription')
                                        <td>
                                            <span class="{{$span_class}}">{{ ucfirst($module_name_singular->data['data']['notification_group']) }}</span>
                                        </td>
                                        @php
                                            $notification = \Modules\NotificationTemplate\Models\NotificationTemplateContentMapping::where('subject', $module_name_singular->data['subject'])->first();
                                            $notificationData = is_string($module_name_singular->data) ? json_decode($module_name_singular->data, true) : $module_name_singular->data;
                                       @endphp
                                        <td>

                                            {{-- {{dd($module_name_singular->data['subject'])}} --}}
                                            <div class="d-flex gap-3 align-items-center">
                                                <div class="text-start">
                                                    <a href="#">
                                                        {{-- <h6>{{ $module_name_singular->data['subject']['name']}}</h6> --}}
                                                        <h6>{{ $notificationData['subject'] ?? '' }}</h6>

                                                    </a>
                                                    {{-- <span class="font-weight-bold">{{ $notification->notification_message }}</span> --}}
                                                </div>
                                            </div>
                                        </td>
                                        @php
                                            $user = \App\Models\User::find($module_name_singular->data['data']['user_id']);
                                        @endphp
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                <img src="{{ $user->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-40 rounded-pill">
                                                <div class="text-start">
                                                    <h6 class="m-0">{{ $user->full_name ?? default_user_name() }}</h6>
                                                    <span>{{ $user->email ?? '--' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $module_name_singular->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{route("notification.remove", $module_name_singular->id)}}" id="delete-{{$module_name}}-{{$module_name_singular->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}">
                                                <i class="ph ph-trash"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <span class="{{$span_class}}">{{ ucwords(str_replace('_', ' ', $module_name_singular->data['data']['notification_group'])) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                <div class="text-start">
                                                    <a href="#">
                                                        <h6>{{ $module_name_singular->data['subject'] }}</h6>
                                                    </a>
                                                    <span class="font-weight-bold"> Your {{$module_name_singular->data['data']['service_name']}} account balance is insufficient. Please recharge your account to maintain service availability.</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                <div class="text-start">
                                                    <h6 class="m-0">{{ $module_name_singular->data['data']['user_name'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $module_name_singular->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{route("notification.remove", $module_name_singular->id)}}" id="delete-{{$module_name}}-{{$module_name_singular->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}">
                                                <i class="ph ph-trash"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; vertical-align: middle;">
                                        {{ __('No data found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
    <script src="{{ mix('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
    <script>
    $(document).on('click', 'a[data-method="DELETE"]', function (e) {
    e.preventDefault();

    let url = $(this).attr('href');
    let token = $(this).data('token');
    let confirmMessage = $(this).data('confirm') || "Are you sure?";

    Swal.fire({
        title: confirmMessage,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: { _token: token },
                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: response.message,
                        icon: "success",
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (err) {
                    Swal.fire("Error!", "Something went wrong while deleting.", "error");
                }
            });
            }
        });
    });

    </script>


@endpush
@endsection
