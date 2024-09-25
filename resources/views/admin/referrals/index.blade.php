@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <div>
            <h4 class="py-3 mb-2">
                <span class="text-muted fw-light">{{ __('Referral Manage') }} /</span> {{ __('Referral List') }}
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('Referral List') }}</h5>
                </div>
                <div class="col-md-2 ml-auto mr-3" style="margin-left:auto;margin-right:25px">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                            placeholder="{{ __('Search...') }}" aria-label="Search..."
                            aria-describedby="basic-addon-search31" fdprocessedid="pjzbzc">
                    </div>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="table dataTable" id="referralDatatable">
                        <thead>
                            <tr>
                                <th>{{ __('Referrer name') }}</th>
                                <th>{{ __('Email Address') }}</th>
                                <th>{{ __('Number of referrals') }}</th>
                                <th>{{ __('Total amount received') }}</th>
                                <th>{{ __('Created Date') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        $(document).on("DOMContentLoaded", function() {
            var dt_basic_table = $('#referralDatatable');
            var dt_basic = null;
            if (dt_basic_table.length) {
                const initAction = () => {
                    function formatNumber(num) {
                        return new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(num);
                    }

                    function formatDate(dateStr) {
                        const dateObj = new Date(dateStr);
                        const formattedDate = dateObj.toLocaleString("en-US", {
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                            hour: "2-digit",
                            minute: "2-digit",
                            second: "2-digit",
                            hour12: true
                        });
                        return formattedDate;
                    }
                    dt_basic = dt_basic_table.DataTable({
                        searchDelay: 500,
                        serverSide: true,
                        processing: true,
                        stateSave: true,
                        order: [
                            [4, 'desc']
                        ],
                        displayLength: 10,
                        lengthMenu: [10, 25, 50, 75, 100],
                        ajax: {
                            url: '{{ route('referral.list') }}',
                            type: "POST",
                            data: function(data) {
                                data._token = "{{ csrf_token() }}";
                            },
                        },
                        columns: [{
                                data: 'fullname'
                            },
                            {
                                data: 'email'
                            },
                            {
                                data: 'total_referals'
                            },
                            {
                                data: 'total_amount_received'
                            },
                            {
                                data: 'created_at'
                            },
                        ],
                        columnDefs: [{
                                targets: 0,
                                render: function(data, type, row) {
                                    return `<a href="#" class="text-primary text-hover-primary btn-show-detail">  ${data ?? ""}  </a>`;
                                }
                            },
                            {
                                targets: 1,
                                render: function(data, type, row) {
                                    return `<span >${data}  </span>`;
                                }
                            },
                            {
                                targets: 2,
                                orderable: false,
                                render: function(data, type, row) {
                                    return `<span >${data}  </span>`;
                                }
                            },
                            {
                                targets: 3,
                                orderable: false,
                                render: function(data, type, row) {
                                    return `<span >${formatNumber(data)}  </span>`;
                                }
                            },
                            {
                                targets: 4,
                                orderable: false,
                                render: function(data, type, row) {
                                    return `<span >${formatDate(data)}  </span>`;
                                }
                            },
                        ],
                    });
                }
                initAction();
            }
        })
    </script>
@endpush
