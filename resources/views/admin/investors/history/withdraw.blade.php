@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <div>
            <h4 class="py-3 mb-2">
                <span class="text-muted fw-light">{{ __('Investor Manager') }} /</span> {{ __('Investor List') }} /</span>
                {{ __('Withdarw History') }}
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('Withdarw History') }}</h5>
                    <a href="{{ url('admin/investor/list') }}"
                        class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px">
                        <span>
                            <i class="ti ti-arrow-left"></i>
                            <span class="d-none d-sm-inline-block">{{ __('Go back') }}</span>
                        </span>
                    </a>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="table dataTable" id="withdrawDatatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Plan Coin') }}</th>
                                <th scope="col">{{ __('Amount Withdraw') }}</th>
                                <th scope="col">{{ __('Wallet Address') }}</th>
                                <th scope="col">{{ __('Withdrawal Date') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
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
            var dt_basic_table = $('#withdrawDatatable');
            var investor_id = {{ $id }};
            var dt_basic = null;
            if (dt_basic_table.length) {
                const initAction = () => {
                    function formatNumber(num) {
                        return num % 1 === 0 ?
                            num.toLocaleString('en-US') :
                            num.toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 4
                            }).replace(/\.?0+$/, '');
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
                    const getRowData = (row) => {
                        return dt_basic.row(row).data();
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
                            url: '{{ route('history.withdraw') }}',
                            type: "POST",
                            data: function(data) {
                                data._token = "{{ csrf_token() }}";
                                data.investor_id = investor_id;
                            },
                            "dataSrc": function(res) {
                                roles = res.role
                                return res.data;
                            }
                        },
                        columns: [{
                                data: 'coin_name'
                            },
                            {
                                data: 'total_amount'
                            },
                            {
                                data: 'wallet_address'
                            },
                            {
                                data: 'updated_at'
                            },
                            {
                                data: 'status'
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
                                    return `<span >${formatNumber(data)} ${row.coin_name} </span>`;
                                }
                            },
                            {
                                targets: 3,
                                render: function(data, type, row) {
                                    return `<span >${formatDate(data)}  </span>`;
                                }
                            },
                            {
                                targets: 4,
                                render: function(data, type, row) {
                                    return `<span class="badge ${data == 0 ? 'bg-label-primary' : data == 1 ? ' bg-label-success' : data == 2 ? ' bg-label-danger' : 'bg-label-danger' }" >${data == 0 ? 'Pending' : data == 1 ? 'Success' : data == 2 ? 'Cancel' : 'Cancel'} </span>`;
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
