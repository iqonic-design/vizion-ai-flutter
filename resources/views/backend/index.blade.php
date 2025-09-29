@extends('backend.layouts.app', ['isBanner' => false])

@section('title')
    {{ 'Dashboard' }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="row">
                @if ($data['cutout_pro_limit_over'] == 1)
                    <div class="col-12">
                        <div id="cutout_pro" class="alert alert-warning">
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span>Your cutout.pro account balance is insufficient. Please recharge your account to
                                    maintain service availability.</span>
                                <button onclick="Upgradeplan('cutout_pro')" class="btn btn-warning">Close</button>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($data['open_ai_limit_over'] == 1)
                    <div class="col-12">
                        <div id="open_ai" class="alert alert-warning">
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span>Your OpenAI account balance is insufficient. Please recharge your account to maintain
                                    service availability.</span>
                                <button onclick="Upgradeplan('open_ai')" class="btn btn-warning">Close</button>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($data['picsart_limit_over'] == 1)
                    <div class="col-12">
                        <div id="picsart" class="alert alert-warning">
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <span>Your Picsart account balance is insufficient. Please recharge your account to maintain
                                    service availability.</span>
                                <button onclick="Upgradeplan('picsart')" class="btn btn-warning">Close</button>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="row row-cols-xl-5 row-cols-md-3 row-cols-sm-2 row-cols-1">
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_users') }}</p>
                                    <h1 class="counter">{{ $data['totalUsersCount'] }}</h1>
                                </div>
                                <div class="icon flex-shrink-0">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-users font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="total-users"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span class="text-success font-size-14">{{ $data['percentageUsers'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_generate_word') }}</p>
                                    <h1 class="counter">{{ $data['totalWordCount'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-textbox font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="total-generated-word"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentageWordCountLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_active_subscription') }}</p>
                                    <h1 class="counter">{{ $data['activeSubscriptionCount'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-currency-circle-dollar font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="total-active-subscriptions"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span class="text-success font-size-14">{{ $data['lastMothsubsctiption'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_image') }}</p>
                                    <h1 class="counter">{{ $data['totalImageCount'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-images font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="total-images-generated"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentageImageCountLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_ai_writer') }}</p>
                                    <h1 class="counter">{{ $data['totalAIwriter'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-pen font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="total-ai-writer"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentageAIwriterLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_art_genertior') }}</p>
                                    <h1 class="counter">{{ $data['totalAIart'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-palette font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="ai-art-generated"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentageAIartLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_ai_code') }}</p>
                                    <h1 class="counter">{{ $data['totalAIcode'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-file-code font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="ai-code"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentageAIcodeLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_ai_image') }}</p>
                                    <h1 class="counter">{{ $data['totalAIimage'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-image font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="ai-images"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentageAIimageLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_ai_chat') }}</p>
                                    <h1 class="counter">{{ $data['totalAIchat'] }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-chat-circle-text font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="ai-chat"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentageAIchatLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="content">
                                    <p class="text-capitalize mb-1">{{ __('dashboard.total_revenue') }}</p>
                                    <h1 class="counter">{{ Currency::format($data['totalRevenue']) }}</h1>
                                </div>
                                <div class="icon">
                                    <div class="bg-primary-subtle text-primary card-icon-40 rounded-circle">
                                        <i class="ph ph-hand-coins font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div id="total-revenue"></div>
                                <div class="d-flex align-item-center justify-content-center gap-3 flex-wrap">
                                    <span
                                        class="text-success font-size-14">{{ $data['percentagerevenueLastMonth'] }}%</span>
                                    <span class="text-capitalize font-size-14">{{ __('dashboard.last_month') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-3 flex-wrap">
                                <h3 class="text-capitalize">{{ __('dashboard.total_revenue') }}</h3>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-group my-0 d-flex gap-2">
                                        <input type="text" name="revenue_date_range"
                                            value="{{ session('revenue_date_range') }}" id="revenuedateRangeInput"
                                            class="form-control revenue-date-range"
                                            placeholder="{{ __('dashboard.SelectDate') }}" readonly="readonly">

                                        <button id="refreshRevenuechart" class="btn btn-primary" data-toggle="tooltip"
                                            title="Reset">
                                            <i class="ph ph-arrow-counter-clockwise"></i>
                                        </button>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#"
                                            class="btn btn-primary dropdown-toggle total_revenue text-capitalize"
                                            id="dropdownTotalUsers3" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ __('dashboard.year') }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownTotalUsers3">
                                            <li><a class="revenue-dropdown-item dropdown-item cursor-pointer"
                                                    data-type="year">{{ __('dashboard.this_year') }}</a></li>
                                            <li><a class="revenue-dropdown-item dropdown-item cursor-pointer"
                                                    data-type="month">{{ __('dashboard.this_month') }}</a></li>
                                            <li><a class="revenue-dropdown-item dropdown-item cursor-pointer"
                                                    data-type="week">{{ __('dashboard.this_week') }}</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div id="revenue_loader" style="display: none;">
                                {{ __('dashboard.processing') }}
                            </div>
                            <div id="total-revenue-chart" class="total-revenue-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-3 flex-wrap">
                                <h3 class="text-capitalize">{{ __('dashboard.user_chart') }}</h3>
                                <div class="d-inline-flex align-items-center gap-3 flex-wrap">
                                    <div class="form-group my-0 d-flex gap-2">
                                        <input type="text" name="date_range" value="{{ session('date_range') }}"
                                            id="dateRangeInput" class="form-control user-date-range"
                                            placeholder="{{ __('dashboard.SelectDate') }}" readonly="readonly">

                                        <button id="refreshUserchart" class="btn btn-primary"
                                            data-toggle="tooltip"title="Reset"><i
                                                class="ph ph-arrow-counter-clockwise"></i></button>
                                    </div>


                                    <div class="flex-shrink-0">

                                        <div class="d-flex align-items-center gap-1">
                                            <span class="text-capitalize">{{ __('dashboard.total_users') }}</span>
                                            <h6 class="m-0" id="chart_newUsers">{{ $data['chart_newUsers'] }}
                                                <h6>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <span
                                                class="text-capitalize">{{ __('dashboard.Total_Subscribed_Users') }}</span>
                                            <h6 class="m-0" id="chart_activeUsers">{{ $data['chart_activeUsers'] }}
                                                <h6>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown">
                                            <a href="#"
                                                class="btn btn-primary dropdown-toggle total_users text-capitalize"
                                                id="dropdownTotalUsers1" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ __('dashboard.year') }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownTotalUsers1">
                                                <li><a class="user-dropdown-item dropdown-item cursor-pointer"
                                                        data-type="year">
                                                        {{ __('dashboard.this_year') }}</a></li>
                                                <li><a class="user-dropdown-item dropdown-item cursor-pointer"
                                                        data-type="month">
                                                        {{ __('dashboard.this_month') }}</a></li>
                                                <li><a class="user-dropdown-item dropdown-item cursor-pointer"
                                                        data-type="week">
                                                        {{ __('dashboard.this_week') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="userchart_loader" style="display: none;">
                                {{ __('dashboard.processing') }}

                            </div>

                            <div id="user-chart" class="user-chart"> </div>

                            <div id="user_chart_graph" class="user_chart_graph"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-3 flex-wrap">
                                <h3 class="text-capitalize">{{ __('dashboard.popular_content') }}</h3>

                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-group my-0 d-flex gap-2">
                                        <input type="text" name="content_date_range"
                                            value="{{ session('content_date_range') }}" id="contentdateRangeInput"
                                            class="form-control content-date-range"
                                            placeholder="{{ __('dashboard.SelectDate') }}" readonly="readonly">

                                        <button id="refreshContentchart" class="btn btn-primary"><i
                                                class="ph ph-arrow-counter-clockwise"
                                                data-toggle="tooltip"title="Reset"></i></button>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#"
                                            class="btn btn-primary dropdown-toggle popular_content text-capitalize"
                                            id="dropdownTotalUsers2" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ __('dashboard.year') }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownTotalUsers2">
                                            <li><a class="popular-dropdown-item dropdown-item cursor-pointer"
                                                    data-type="year">{{ __('dashboard.this_year') }}</a></li>
                                            <li><a class="popular-dropdown-item dropdown-item cursor-pointer"
                                                    data-type="month">{{ __('dashboard.this_month') }}</a></li>
                                            <li><a class="popular-dropdown-item dropdown-item cursor-pointer"
                                                    data-type="week">
                                                    {{ __('dashboard.this_week') }}</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div id="popular_loader" style="display: none;">
                                {{ __('dashboard.processing') }}
                            </div>
                            <div id="popular-content" class="popular-content"></div>
                            <div id="popular_content_data" class="popular_content_data"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-height">
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-3 flex-wrap">
                                <h3 class="text-capitalize">{{ __('dashboard.subscription') }}</h3>

                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-group my-0 d-flex justify-content-end gap-2">
                                        <input type="text" name="subscription_range"
                                            value="{{ session('subscription_range') }}" id="subscriptionRangeInput"
                                            class="form-control subscription-date-range"
                                            placeholder="{{ __('dashboard.SelectDate') }}" readonly="readonly">

                                        <button id="refreshSubscriptionchart" class="btn btn-primary d-none"
                                            data-toggle="tooltip"title="Reset"><i
                                                class="ph ph-arrow-counter-clockwise"></i></button>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <div class="dropdown">
                                            <a href="#"
                                                class="btn btn-primary dropdown-toggle subscription text-capitalize"
                                                id="dropdownTotalUsers4" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ __('dashboard.year') }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownTotalUsers4">
                                                <li><a class="subscription-dropdown-item  dropdown-item cursor-pointer"
                                                        data-type="year">{{ __('dashboard.this_year') }}</a></li>
                                                <li><a class="subscription-dropdown-item  dropdown-item cursor-pointer"
                                                        data-type="month">{{ __('dashboard.this_month') }}</a></li>
                                                <li><a class="subscription-dropdown-item  dropdown-item cursor-pointer"
                                                        data-type="week">{{ __('dashboard.this_week') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="subscription_loader" style="display: none;">
                                {{ __('dashboard.processing') }}
                            </div>
                            <div id="subscription_data" class="subscription_data"></div>
                            <div id="subscription" class="subscription"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-height">
                        <div class="card-body">
                            <h3 class="text-capitalize mb-5">{{ __('dashboard.recent_history') }}</h3>
                            <div class="table-responsive card-height-table">
                                <table id="datatable"
                                    class="table table-striped table-hover transaction_history_table dataTable">
                                    <thead>
                                        <tr class="bg-body">
                                            <th>
                                                <h6 class="m-0">{{ __('dashboard.user_name') }}</h6>
                                            </th>
                                            <th>
                                                <h6 class="m-0">{{ __('dashboard.Plan_Type') }}</h6>
                                            </th>

                                            <th>
                                                <h6 class="m-0">{{ __('dashboard.amount') }}</h6>
                                            </th>

                                            <th>
                                                <h6 class="m-0">{{ __('dashboard.Purchased_Date_Time') }}</h6>
                                            </th>
                                            <th>
                                                <h6 class="m-0">{{ __('dashboard.status') }}</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data['transactionHistory']->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">Data is not available</td>
                                            </tr>
                                        @else
                                            @foreach ($data['transactionHistory'] as $transaction)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex gap-3 align-items-center">
                                                            <img src="{{ optional(optional($transaction->subscription)->user)->profile_image ?? default_user_avatar() }}"
                                                                alt="avatar" class="avatar avatar-40 rounded-pill">
                                                            <div class="text-start">
                                                                <h6 class="m-0">
                                                                    {{ optional(optional($transaction->subscription)->user)->full_name ?? default_user_name() }}
                                                                </h6>
                                                                <span>{{ optional(optional($transaction->subscription)->user)->email ?? '--' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ optional(optional($transaction->subscription)->plan)->name ?? null }}
                                                    </td>
                                                    <td>{{ Currency::format($transaction->amount) }}</td>
                                                    <td>{{ $transaction->created_at }}</td>
                                                    <td>
                                                        <span
                                                            class="btn btn-sm 
                    {{ $transaction->subscription->status === 'inactive' ? 'btn-danger-subtle' : 'btn-success-subtle' }} 
                    pe-none">
                                                            {{ ucfirst($transaction->subscription->status ?? null) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-styles')
    <style>
        #chart-01 {
            min-height: 17.4rem !important;
        }

        #chart-04 {
            min-height: 300px !important;
        }

        #chart-03 {
            min-height: 300px !important;
        }

        @media (max-width: 991.98px) {
            #chart-04 {
                min-height: 250px !important;
            }

            #chart-03 {
                min-height: 200px !important;
            }
        }

        .dropdown-menu {
            max-height: 200px;
            /* Set maximum height for scroll */
            overflow-y: auto;
            /* Enable vertical scrollbar */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.css"
        integrity="sha512-tJYqW5NWrT0JEkWYxrI4IK2jvT7PAiOwElIGTjALSyr8ZrilUQf+gjw2z6woWGSZqeXASyBXUr+WbtqiQgxUYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.js"
        integrity="sha512-Kr1p/vGF2i84dZQTkoYZ2do8xHRaiqIa7ysnDugwoOcG0SbIx98erNekP/qms/hBDiBxj336//77d0dv53Jmew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const range_flatpicker = document.querySelectorAll('.user-date-range')
        let userDate ;
        Array.from(range_flatpicker, (elem) => {
            if (typeof flatpickr !== typeof undefined) {
                userDate =  flatpickr(elem, {
                    mode: "range",
                })
            }
        })

        const revnue_range_flatpicker = document.querySelectorAll('.revenue-date-range')
        let revenueDate;
        Array.from(revnue_range_flatpicker, (elem) => {
            if (typeof flatpickr !== typeof undefined) {
                revenueDate = flatpickr(elem, {
                    mode: "range",
                })
            }
        })

        const subscription_range_flatpicker = document.querySelectorAll('.subscription-date-range')
        let subscriptionDate;
        Array.from(subscription_range_flatpicker, (elem) => {
            if (typeof flatpickr !== typeof undefined) {
                subscriptionDate =   flatpickr(elem, {
                    mode: "range",
                })
            }
        })

        const content_range_flatpicker = document.querySelectorAll('.content-date-range')
        Array.from(content_range_flatpicker, (elem) => {
            if (typeof flatpickr !== typeof undefined) {
                contentDateRange=  flatpickr(elem, {
                    mode: "range",
                })
            }
        })


        //////////////////////////////////////////////  user chart /////////////////////////////////////////////////////////

        $(document).ready(function() {

            function total_users() {

                if (document.querySelectorAll('#total-users').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_user_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#total-users"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }



            }

            total_users()

            /////////////////////////////////////////////////////// total active subscriptions  ///////////////////////////////////////////////////////////////////////////////

            function total_active_subscriptions() {
                if (document.querySelectorAll('#total-active-subscriptions').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_subscription_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#total-active-subscriptions"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }

            total_active_subscriptions();

            ///////////////////////////////////////////////////////  total word genertor ///////////////////////////////////////////////////////////////

            function total_generated_word() {
                if (document.querySelectorAll('#total-generated-word').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_word_count_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#total-generated-word"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }

            total_generated_word();
            ///////////////////////////////////////////////////////////////// Total image gerator /////////////////////////////////////////////////////////////////////////
            function total_images_generated() {
                if (document.querySelectorAll('#total-images-generated').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_image_count_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#total-images-generated"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }

            total_images_generated();









            //////////////////////////////////////////////////////////////Total Uses of AI Writer /////////////////////////////////////////////////////////////////////


            function total_uses_ai_writer() {
                if (document.querySelectorAll('#total-ai-writer').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_ai_writer_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#total-ai-writer"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }
            total_uses_ai_writer()

            ////////////////////////////////////////////// uses of ai art/////////////////////////////////////////////////////////////////////////////////////////

            function total_uses_ai_art() {
                if (document.querySelectorAll('#ai-art-generated').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_ai_art_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#ai-art-generated"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }
            total_uses_ai_art()

            /////////////////////////////////////////////////////////// uses of ai code //////////////////////////////////////////////////////////////////////////
            function total_uses_ai_code() {
                if (document.querySelectorAll('#ai-code').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_ai_code_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#ai-code"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }
            total_uses_ai_code()


            /////////////////////////////////////////////////////////// uses of ai Image //////////////////////////////////////////////////////////////////////////
            function total_uses_ai_image() {
                if (document.querySelectorAll('#ai-images').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_ai_image_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#ai-images"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }
            total_uses_ai_image()
            ////////////////////////////////////////////////////////////  Ai Chat ///////////////////////////////////////////////////////

            function total_uses_ai_chat() {

                if (document.querySelectorAll('#ai-chat').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_ai_chat_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },
                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#ai-chat"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }
            total_uses_ai_chat()
            //////////////////////////////////////////////////////////// Total revenue /////////////////////////////////////////////////////////////////
            const formatCurrencyvalue = (value) => {
                if (window.currencyFormat !== undefined) {
                    return window.currencyFormat(value)
                }
                return value
            }

            function total_revenue() {

                if (document.querySelectorAll('#total-revenue').length) {
                    const variableColors = IQUtils.getVariableColor();
                    const colors = [variableColors.primary, variableColors.info];
                    const options = {
                        series: [{
                            name: '@lang('dashboard.Total')',
                            data: @json($data['last_month_revenue_graph_data'])
                        }],
                        chart: {
                            height: 120,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false,
                            },
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                                offsetX: -200,
                            },
                        },

                        legend: {
                            show: false,
                        },
                        xaxis: {
                            show: false,
                            labels: {
                                minHeight: 22,
                                maxHeight: 22,
                                show: false,
                                style: {
                                    colors: "#8A92A6",
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            lines: {
                                show: false
                            },
                        },
                        grid: {
                            show: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: "vertical",
                                shadeIntensity: 0,
                                gradientToColors: undefined,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .1,
                                colors: ["#3a57e8", "#4bc7d2"]
                            }
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function(val) {

                                    return formatCurrencyvalue(val);
                                }
                            }
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#total-revenue"), options);
                    chart.render();
                    //color customizer
                    document.addEventListener("theme_color", (e) => {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.info];

                        const newOpt = {
                            colors: colors,
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: colors, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    stops: [0, 50, 60],
                                    colors: colors,
                                }
                            },
                        }
                        chart.updateOptions(newOpt)
                    })

                    //Font customizer
                    document.addEventListener("body_font_family", (e) => {
                        let prefix =
                            getComputedStyle(document.body).getPropertyValue("--prefix") || "bs-";
                        if (prefix) {
                            prefix = prefix.trim();
                        }
                        const font_1 = getComputedStyle(document.body).getPropertyValue(
                            `--${prefix}body-font-family`
                        );
                        const fonts = [font_1.trim()];
                        const newOpt = {
                            chart: {
                                fontFamily: fonts,
                            },
                        };
                        chart.updateOptions(newOpt);
                    });
                }
            }
            total_revenue()


            ////////////////////////////////////////////////////   User Chart ////////////////////////////////////////////////////////////////////////////


            let chartInstance;

            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('#dateRangeInput').on('change', function() {

                var dateRangeValue = $('#dateRangeInput').val();

                var dates = dateRangeValue.split(" to ");

                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {

                    user_chart('Date', startDate, endDate);

                }


            });

            $('#refreshUserchart').on('click', function() {

                userDate.clear()
                

                user_chart('year');
            });

            var dateRangeValue = $('#dateRangeInput').val();

            if (dateRangeValue != '') {
                var dates = dateRangeValue.split(" to ");
                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {
                    user_chart('Date', startDate, endDate);
                }
            } else {

                user_chart('year');
            }



            // Modify the user_chart() function to render or update the chart
            function user_chart(type, startDate, endDate) {
                var Base_url = "{{ url('/') }}";
                var url = Base_url + "/app/get_users_chart_data/" + type;

                $("#userchart_loader").show();
                $("#user_chart_graph").text('');

                if (type == 'Date') {

                    $('#refreshUserchart').removeClass('d-none');

                } else {

                    $('#refreshUserchart').addClass('d-none');
                }

                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {

                        $("#chart_newUsers").text(response.data.chart_allUsers)
                        $("#chart_activeUsers").text(response.data.chart_activeUsers)


                        $("#userchart_loader").hide();
                        $(".total_users").text(type);


                        if (response.data.chart_allUsers == 0 && response.data.chart_activeUsers == 0) {

                            $("#user-chart").addClass('d-none');

                            $("#user_chart_graph").text('Data not available');


                        } else {


                            $("#user-chart").removeClass('d-none');


                            const variableColors = IQUtils.getVariableColor();
                            const colors = [variableColors.primary, variableColors.info];
                            const monthlyTotals = response.data.chartData;
                            const category = response.data.category;

                            const options = {
                                series: [{
                                    name: '@lang('dashboard.Total_Users')',
                                    data: monthlyTotals.all_user
                                }, {

                                    name: '@lang('dashboard.Active_Users')',
                                    data: monthlyTotals.active_user
                                }],
                                chart: {
                                    fontFamily: '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                    height: 300,
                                    type: 'area',
                                    toolbar: {
                                        show: false
                                    },
                                    sparkline: {
                                        enabled: false,
                                    },
                                },
                                colors: colors,
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 3,
                                },
                                yaxis: {
                                    show: true,
                                    labels: {
                                        show: true,
                                        style: {
                                            colors: "#8A92A6",
                                        },
                                        offsetX: -15,
                                        formatter: (value) => {
                                            return value
                                        }
                                    },
                                },
                                legend: {
                                    show: true,
                                },
                                xaxis: {
                                    labels: {
                                        minHeight: 22,
                                        maxHeight: 22,
                                        show: true,
                                        style: {
                                            colors: "#8A92A6",
                                        },
                                    },
                                    lines: {
                                        show: false
                                    },
                                    categories: category,
                                },
                                grid: {
                                    show: true,
                                    borderColor: 'var(--bs-body-bg)',
                                    strokeDashArray: 0,
                                    position: 'back',
                                    xaxis: {
                                        lines: {
                                            show: true
                                        }
                                    },
                                    yaxis: {
                                        lines: {
                                            show: true
                                        }
                                    },
                                },
                                fill: {
                                    type: 'solid',
                                    opacity: 0
                                },
                                tooltip: {
                                    enabled: true,
                                },
                            };

                            // If a chart instance exists, update it. Otherwise, create a new chart.
                            if (chartInstance) {
                                chartInstance.updateOptions(options);
                            } else {
                                chartInstance = new ApexCharts(document.querySelector("#user-chart"),
                                    options);
                                chartInstance.render();
                            }

                        }
                    }
                })
            }

            // Attach event listener to dropdown items to update the chart
            $(document).on('click', '.user-dropdown-item', function() {
                var type = $(this).data('type'); // Assuming you have a 'data-type' attribute set
                $('#dateRangeInput').val('');
                user_chart(type);
            });

            /////////////////////////////////////////////////////////////popular_content///////////////////////////////////////////////////////////////////////////

            let popularInstance;

            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('#contentdateRangeInput').on('change', function() {
                var dateRangeValue = $('#contentdateRangeInput').val();
                var dates = dateRangeValue.split(" to ");
                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {
                    popular_content('Date', startDate, endDate);
                }
            });

            $('#refreshContentchart').on('click', function() {
                
                contentDateRange.clear()
               

                popular_content('year');
            });

            var dateRangeValue = $('#contentdateRangeInput').val();

            if (dateRangeValue != '') {
                var dates = dateRangeValue.split(" to ");
                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {
                    popular_content('Date', startDate, endDate);
                }
            } else {
                popular_content('year');
            }

            // Function to generate a random color
            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            // Function to get stored colors from sessionStorage or generate new ones
            function getStoredOrGenerateColors(numColors) {
                let storedColors = sessionStorage.getItem('chartColors');

                // If colors are already stored, return them
                if (storedColors) {
                    return JSON.parse(storedColors);
                }

                // Otherwise, generate new colors
                let newColors = [];
                for (let i = 0; i < numColors; i++) {
                    newColors.push(getRandomColor());
                }

                // Store the generated colors in sessionStorage for future use
                sessionStorage.setItem('chartColors', JSON.stringify(newColors));

                return newColors;
            }

            function popular_content(type, startDate, endDate) {
                var Base_url = "{{ url('/') }}";
                var url = Base_url + "/app/get_popular_content_chart_data/" + type;

                $("#popular_loader").show();
                $("#popular_content_data").text('');

                if (type == 'Date') {
                    $('#refreshContentchart').removeClass('d-none');
                } else {
                    $('#refreshContentchart').addClass('d-none');
                }

                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        $("#popular_loader").hide();
                        $(".popular_content").text(type);

                        if (document.querySelectorAll('#popular-content').length) {
                            const monthlyTotals = response.chartData;
                            const category = response.category;

                            const series = [];

                            // Get stored colors or generate new ones
                            const dynamicColors = getStoredOrGenerateColors(Object.keys(monthlyTotals)
                                .length);

                            Object.keys(monthlyTotals).forEach((key, index) => {
                                const item = monthlyTotals[key];

                                if (Array.isArray(item.data)) {
                                    series.push({
                                        name: item.name,
                                        data: item.data.map(data => {
                                            return {
                                                x: data.x,
                                                y: data.y
                                            };
                                        })
                                    });
                                }
                            });

                            const options = {
                                series: series,
                                chart: {
                                    fontFamily: '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                    type: 'rangeBar',
                                    height: 305,
                                    toolbar: {
                                        show: false
                                    },
                                    sparkline: {
                                        enabled: false,
                                    },
                                },
                                colors: dynamicColors,
                                tooltip: {
                                    enabled: false
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: "30%",
                                        borderRadius: 10,
                                    }
                                },
                                legend: {
                                    show: true,
                                },
                                yaxis: {
                                    show: true,
                                    labels: {
                                        show: true,
                                        style: {
                                            colors: "#8A92A6",
                                        },
                                        offsetX: -15,
                                        formatter: (value) => {
                                            return value;
                                        }
                                    },
                                },
                                xaxis: {
                                    labels: {
                                        minHeight: 22,
                                        maxHeight: 22,
                                        show: true,
                                    },
                                    lines: {
                                        show: false
                                    },
                                    categories: category
                                },
                                grid: {
                                    show: true,
                                    borderColor: 'var(--bs-body-bg)',
                                    strokeDashArray: 10,
                                    position: 'back',
                                    xaxis: {
                                        lines: {
                                            show: false
                                        }
                                    },
                                    yaxis: {
                                        lines: {
                                            show: true
                                        }
                                    },
                                },

                            };

                            // console.log(popularInstance);

                            popularInstance = new ApexCharts(document.querySelector("#popular-content"), options);
                                    
                            popularInstance.render();


                            // if (popularInstance) {
                            // console.log('eee' , popularInstance);

                            //     // popularInstance.updateOptions(options);
                            //     // console.log(options);
                                
                            // } else {
                            //     popularInstance = new ApexCharts(document.querySelector(
                            //         "#popular-content"), options);
                            //         console.log(options);
                                    
                            //     popularInstance.render();
                            // }
                        }
                    }
                })
            };





            ///////////////////////////////////////////////////////////// Revenue chart //////////////////////////////////////////////////////////////////////////////

            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('#revenuedateRangeInput').on('change', function() {

                var dateRangeValue = $('#revenuedateRangeInput').val();

                var dates = dateRangeValue.split(" to ");

                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {

                    var dateRangeValue = $('#revenuedateRangeInput').val();

                    total_revenue_chart('Date', startDate, endDate);

                }

            });

            var dateRangeValue = $('#revenuedateRangeInput').val();

            if (dateRangeValue != '') {
                var dates = dateRangeValue.split(" to ");
                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {

                    total_revenue_chart('Date', startDate, endDate);
                }
            } else {

                total_revenue_chart('year');
            }

            $('#refreshRevenuechart').on('click', function() {

                revenueDate.clear()
               

                total_revenue_chart('year');
            });

            function formatCurrencyVue(value) {

                return formatCurrencyvalue(value);
            }
            let revenueInstance;

            function total_revenue_chart(type, startDate, endDate) {
                var Base_url = "{{ url('/') }}";
                var url = Base_url + "/app/get_revnue_chart_data/" + type;

                $("#revenue_loader").show();

                if (type == 'Date') {

                    $('#refreshRevenuechart').removeClass('d-none');
                } else {

                    $('#refreshRevenuechart').addClass('d-none');
                }

                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        $("#revenue_loader").hide();
                        $(".total_revenue").text(type);
                        if (document.querySelectorAll('#total-revenue-chart').length) {
                            const variableColors = IQUtils.getVariableColor();
                            const colors = [variableColors.primary, variableColors.info];
                            const monthlyTotals = response.data.chartData;
                            const category = response.data.category;
                            const options = {
                                series: [{
                                    name: '@lang('dashboard.total_revenue')',

                                    data: monthlyTotals
                                }],
                                chart: {
                                    fontFamily: '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                    height: 300,
                                    type: 'area',
                                    toolbar: {
                                        show: false
                                    },
                                    sparkline: {
                                        enabled: false,
                                    },
                                },
                                colors: colors,
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 3,
                                },
                                yaxis: {
                                    show: true,
                                    labels: {
                                        show: true,
                                        style: {
                                            colors: "#8A92A6",
                                        },
                                        offsetX: -15,
                                        formatter: (value) => {

                                            return formatCurrencyVue(value);
                                        }
                                    },
                                },
                                legend: {
                                    show: false,
                                },
                                xaxis: {
                                    labels: {
                                        minHeight: 22,
                                        maxHeight: 22,
                                        show: true,
                                    },
                                    lines: {
                                        show: false
                                    },
                                    categories: category
                                },
                                grid: {
                                    show: true,
                                    borderColor: 'var(--bs-body-bg)',
                                    strokeDashArray: 0,
                                    position: 'back',
                                    xaxis: {
                                        lines: {
                                            show: true
                                        }
                                    },
                                    yaxis: {
                                        lines: {
                                            show: true
                                        }
                                    },
                                },
                                fill: {
                                    type: 'solid',
                                    opacity: 0
                                },
                                tooltip: {
                                    enabled: true,
                                },
                            };
                            // const chart = new ApexCharts(document.querySelector("#total-revenue-chart"), options);
                            // chart.render();
                            // If a chart instance exists, update it. Otherwise, create a new chart.
                            if (revenueInstance) {
                                revenueInstance.updateOptions(options);
                            } else {
                                revenueInstance = new ApexCharts(document.querySelector(
                                    "#total-revenue-chart"), options);
                                revenueInstance.render();
                            }
                        }
                    }
                })
            };


            $(document).on('click', '.revenue-dropdown-item', function() {
                var type = $(this).data('type'); // Assuming you have a 'data-type' attribute set
                $('#revenuedateRangeInput').val('');
                total_revenue_chart(type);
            });



            //////////////////////////////////////////////////////////////////////////////////   subscription chart /////////////////////////////////////////////////////////



            let subscriptionInstance;

            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('#subscriptionRangeInput').on('change', function() {

                var dateRangeValue = $('#subscriptionRangeInput').val();


                var dates = dateRangeValue.split(" to ");

                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {

                    subscription('Date', startDate, endDate);

                }


            });

            $('#refreshSubscriptionchart').on('click', function() {

                subscriptionDate.clear()
               

                subscription('year');
            });

            var dateRangeValue = $('#subscriptionRangeInput').val();


            if (dateRangeValue != '') {

                var dates = dateRangeValue.split(" to ");
                var startDate = dates[0];
                var endDate = dates[1];

                if (startDate != null && endDate != null) {
                    subscription('Date', startDate, endDate);
                }
            } else {

                subscription('year');

            }


            function subscription(type, startDate, endDate) {
                var Base_url = "{{ url('/') }}";
                var url = Base_url + "/app/get_subscription_chart_data/" + type;

                $("#subscription_loader").show();
                $("#subscription_data").hide();

                if (type == 'Date') {
                    $('#refreshSubscriptionchart').removeClass('d-none')
                } else {
                    $('#refreshSubscriptionchart').addClass('d-none')
                }

                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {

                        $("#subscription_loader").hide();

                        $("#dropdownTotalUsers4").text(type);


                        if (response.data.free_user == 0 && response.data.paid_user == 0) {

                            $("#subscription").addClass('d-none');

                            $("#subscription_data").show().text('Data not available')
                                .addClass('text-center')
                                .css({
                                    'font-weight': 'bold',
                                    'font-size': '14px',
                                    'margin-top': '140px',
                                });

                        } else {

                            $("#subscription_data").text('');

                            $("#subscription").removeClass('d-none');

                            if (document.querySelectorAll('#subscription').length) {
                                const variableColors = IQUtils.getVariableColor();
                                const colors = [variableColors.primary, variableColors.info];
                                const monthlyTotals = response.data.chartData;
                                const category = response.data.category;
                                const options = {
                                    series: [{
                                            name: "Free",
                                            data: monthlyTotals.free
                                        },
                                        {
                                            name: "Paid",
                                            data: monthlyTotals.paid
                                        }
                                    ],
                                    chart: {
                                        fontFamily: '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                        height: 300,
                                        type: 'bar',
                                        toolbar: {
                                            show: false
                                        },
                                        sparkline: {
                                            enabled: false,
                                        },
                                    },
                                    colors: colors,
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        width: 3,
                                    },
                                    yaxis: {
                                        show: true,
                                        labels: {
                                            show: true,
                                            offsetX: -15,
                                            formatter: (value) => {
                                                return value;
                                            }
                                        },
                                    },
                                    legend: {
                                        show: false,
                                    },
                                    xaxis: {
                                        labels: {
                                            minHeight: 22,
                                            maxHeight: 22,
                                            show: true,
                                        },
                                        lines: {
                                            show: false
                                        },
                                        categories: category
                                    },
                                    grid: {
                                        show: false,
                                    },

                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: '90%',
                                            borderRadius: 10,
                                            endingShape: 'rounded'
                                        }
                                    },

                                    fill: {
                                        type: 'solid',
                                        opacity: 1
                                    },

                                    tooltip: {
                                        enabled: true,
                                    },
                                };
                                // const chart = new ApexCharts(document.querySelector("#subscription"), options);
                                // chart.render();

                                // If a chart instance exists, update it. Otherwise, create a new chart.
                                if (subscriptionInstance) {
                                    subscriptionInstance.updateOptions(options);
                                } else {
                                    subscriptionInstance = new ApexCharts(document.querySelector(
                                        "#subscription"), options);
                                    subscriptionInstance.render();
                                }
                            }

                        }
                    }
                })
            };


            $(document).on('click', '.subscription-dropdown-item', function() {
                var type = $(this).data('type'); // Assuming you have a 'data-type' attribute set
                subscription(type);
                $('#subscriptionRangeInput').val('');
            });

        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function Upgradeplan(type) {


            var Base_url = "{{ url('/') }}";

            var url = Base_url + "/app/upgrade_account/";

            $.ajax({
                url: url,
                method: "GET",
                data: {
                    type: type,

                },
                success: function(response) {

                    if (response.status == true)

                        $("#" + type).hide();

                }
            })




        }
    </script>
@endpush
