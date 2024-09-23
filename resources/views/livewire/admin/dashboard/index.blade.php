@php
    function formatNumber($number, $decimals = 6)
    {
        $formattedNumber = number_format($number, $decimals);
        return rtrim(rtrim($formattedNumber, '0'), '.');
    }
@endphp
<div class="row">
    <!-- Website Analytics -->
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">{{ __('Dashboard') }} /</span>{{ __('Statistical') }}
    </h4>
    <div class="row">
        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body text-nowrap">
                            <h5 class="card-title mb-0">{{ isset($investor) ? $investor->fullname : '...' }} 🎉</h5>
                            <p class="mb-2">{{ __('The person who invests the most of the month') }}</p>
                            <h4 class="text-primary mb-1">
                                ${{ isset($total_amount) ? formatNumber($total_amount->total_amount) : 0 }}</h4>
                            <button data-kt-action="update" data-id={{ isset($investor) ? $investor->id : null }}
                                data-bs-toggle="modal" data-bs-target="#kt_modal_update1"
                                class="btn btn-primary waves-effect waves-light">{{ __('View Investor') }}</button>
                        </div>
                    </div>
                    <div class="col-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../../assets/img/illustrations/card-advance-sale.png" height="140"
                                alt="view sales">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 mb-4 col-lg-7 col-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title mb-0">{{ __('Statistics') }}</h5>
                        <small class="text-muted">{{ __('Updated 1 month ago') }}</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">${{ formatNumber($total_investment_amount) ?? 0 }}</h5>
                                    <small>{{ __('Investment Amount') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ count($total_investor) }}</h5>
                                    <small>{{ __('Total Investors') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-danger me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ count($total_plan) }}</h5>
                                    <small>{{ __('Total Plan') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">${{ formatNumber($total_withdraw_amount) ?? 0 }}</h5>
                                    <small>{{ __('Total Amount Withdrawn') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Website Analytics -->

    <!-- Earning Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">{{ __('Earning Reports') }}</h5>
                    <small class="text-muted">{{ __('Weekly Earnings Overview') }}</small>
                </div>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                    </button>
                </div>
                <!-- </div> -->
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 d-flex flex-column align-self-end">
                        <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                            <h1 class="mb-0">${{ formatNumber($total_profit) ?? 0 }}</h1>
                            <div class="badge rounded bg-label-success">+4.2%</div>
                        </div>
                        <small>{{ __('Total income in week') }}</small>
                    </div>
                    <div class="col-12 col-md-8">
                        <div id="weeklyEarningReports"></div>
                    </div>
                </div>
                <div class="border rounded p-3 mt-4">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-primary p-1">
                                    <i class="ti ti-currency-dollar ti-sm"></i>
                                </div>
                                <h6 class="mb-0">{{ __('Earnings') }}</h6>
                            </div>
                            <h4 class="my-2 pt-1">${{ formatNumber($total_profit) ?? 0 }}</h4>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i>
                                </div>
                                <h6 class="mb-0">{{ __('Profit') }}</h6>
                            </div>
                            <h4 class="my-2 pt-1">${{ formatNumber($total_earnings) ?? 0 }}</h4>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-brand-paypal ti-sm"></i>
                                </div>
                                <h6 class="mb-0">{{ __('Expense') }}</h6>
                            </div>
                            <h4 class="my-2 pt-1">${{ formatNumber($total_expense) ?? 0 }}</h4>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Earning Reports -->

    <!-- Support Tracker -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between pb-0">
                <div class="card-title mb-0">
                    <h5 class="mb-0">{{ __('Support Tracker') }}</h5>
                    <small class="text-muted">{{ __('Last 7 Days') }}</small>
                </div>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                        <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                            <h1 class="mb-0">${{ formatNumber($total_investment_amount_in_week) ?? 0 }}</h1>
                            <p class="mb-0">{{ __('Total deposits in 7 days') }}</p>
                        </div>
                        <ul class="p-0 m-0">
                            <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                                <div class="badge rounded bg-label-primary p-1"><i class="ti ti-currency-dollar"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">{{ __('Deposit pendding') }}</h6>
                                    <small
                                        class="text-muted">${{ formatNumber($total_amount_in_week_pendding) ?? 0 }}</small>

                                </div>
                            </li>
                            <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                                <div class="badge rounded bg-label-info p-1">
                                    <i class="ti ti-currency-dollar"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">{{ __('Deposit running') }}</h6>
                                    <small
                                        class="text-muted">${{ formatNumber($total_amount_in_week_running) ?? 0 }}</small>

                                </div>
                            </li>
                            <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                                <div class="badge rounded bg-label-info p-1">
                                    <i class="ti ti-currency-dollar"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">{{ __('Deposit success') }}</h6>
                                    <small
                                        class="text-muted">${{ formatNumber($total_amount_in_week_success) ?? 0 }}</small>

                                </div>
                            </li>
                            <li class="d-flex gap-3 align-items-center pb-1">
                                <div class="badge rounded bg-label-warning p-1"><i class="ti ti-currency-dollar"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">{{ __('Deposit cancel') }}</h6>
                                    <small
                                        class="text-muted">{{ formatNumber($total_amount_in_week_cancel) ?? 0 }}</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-8 col-md-12 col-lg-8">
                        <div id="supportTracker"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Support Tracker -->
</div>
