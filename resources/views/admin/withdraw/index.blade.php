@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <!-- Responsive Datatable -->
        <div>
            <h4 class="py-3 mb-2" wire:poll.15s>
                <span class="text-muted fw-light">{{ __('Manage withdraw') }} /</span> {{ __('Withdraw List') }}
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('Withdraw List') }}</h5>
                    <button class="btn btn-primary template-customizer-reset-btn text-white mr-3" id="btn-reset-data"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reset data">
                        <i class="ti ti-refresh ti-sm"></i>
                        <span class="badge rounded-pill bg-danger badge-dot badge-notifications d-none"></span>
                    </button>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="table dataTable" id="withdrawDatatable">
                        <thead>
                            <tr>
                                <th>{{ __('Withdrawer') }}</th>
                                <th>{{ __('Coin Name') }}</th>
                                <th>{{ __('Wallet type') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Total Amount') }} </th>
                                <th>{{ __('Withdrawal date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th style="width:80px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            @include('admin.withdraw.modal.show')
        </div>
    @endsection
    @push('scripts')
        <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
        <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
        <script>
            // Ensure the baseUrl is correctly formatted
            $(document).on("DOMContentLoaded", function() {
                var dt_basic_table = $('#withdrawDatatable');
                var dt_basic = null;
                if (dt_basic_table.length) {
                    const initAction = () => {
                        // Variable declaration
                        let roles = [];
                        // Show update
                        $(document).on('click', '.btn-show', function() {
                            const data = getRowData($(this).closest('tr'));
                            $('#fullname').text(data.fullname);
                            $('#coin_name').text(data.coin_name);
                            $('#wallet_name').text(data.wallet_name);
                            $('#amount').text(formatNumber(data.amount) + " " + data.coin_name);
                            $('#total_amount').text(formatNumber(data.total_amount) + " " + data
                                .coin_name);
                            $('#created_at').text(formatDate(data.created_at));
                            $('#wallet_address').text(data.wallet_address);
                            $('#network').text(data.network_name);
                           
                            $('#status').html(data.status == 0 ?
                                '<span class="text-primary">Pending</span>' : data.status == 1 ?
                                '<span class="text-success">Success</span>' : data.status == 2 ?
                                '<span class="text-danger">Cancel</span>' :
                                '<span class="text-danger">Cancel</span>');
                            $('#kt_modal_update').modal('show');
                        })

                        $('#btn-reset-data').click(function() {
                            $('#withdrawDatatable').DataTable().ajax.reload();
                        })
                        //  confirm
                        $(document).on('click', '.btn-confirm', function() {
                            const data = getRowData($(this).closest('tr'));
                            $.ajax({
                                url: '{{ route('withdraw.confirm') }}',
                                type: 'POST',
                                data: {
                                    id: data.id,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(res) {
                                    dt_basic.ajax.reload();
                                    toastr.success('Confirm successfully.')
                                },
                                error: function(err) {
                                    toastr.error(err.message)
                                }
                            });
                        })
                        // cancel
                        $(document).on('click', '.btn-cancel', function() {
                            const data = getRowData($(this).closest('tr'));
                            $.ajax({
                                url: '{{ route('withdraw.cancel') }}',
                                type: 'POST',
                                data: {
                                    id: data.id,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(res) {
                                    dt_basic.ajax.reload();
                                    toastr.success('Cancel successfully.')
                                },
                                error: function(err) {
                                    toastr.error(err.message)
                                }
                            });
                        })

                        function formatNumber(num) {
                            return num % 1 === 0 ?
                                num.toLocaleString('en-US') :
                                num.toLocaleString('en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 4
                                });
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
                                url: '{{ route('withdraw.list') }}',
                                type: "POST",
                                data: function(data) {
                                    data._token = "{{ csrf_token() }}";
                                },
                                "dataSrc": function(res) {
                                    roles = res.role
                                    return res.data;
                                }
                            },
                            columns: [{
                                    data: 'fullname'
                                },
                                {
                                    data: 'coin_name'
                                },
                                {
                                    data: 'wallet_name'
                                },
                                 {
                                    data: 'amount'
                                },
                                {
                                    data: 'total_amount'
                                },
                                {
                                    data: 'created_at'
                                },
                              
                                {
                                    data: 'status'
                                },
                                {
                                    data: ''
                                }
                            ],
                            columnDefs: [{
                                    targets: 0,
                                    render: function(data, type, row) {
                                        return `<a href="#" class="text-primary text-hover-primary btn-show">  ${data ?? ""}  </a>`;

                                    }
                                },
                                {
                                    targets: 1,
                                    render: function(data, type, row) {
                                        return `<span >${data ?? 'Deposit'}  </span>`;
                                    }
                                },
                                {
                                    targets: 3,
                                    render: function(data, type, row) {
                                        return `<span >${formatNumber(data)} ${row.coin_name}</span>`;
                                    }
                                },
                                {
                                    targets: 4,
                                    render: function(data, type, row) {
                                        return `<span>${formatNumber(data)} ${row.coin_name} </span>`;
                                    }
                                },
                                 {
                                    targets: 5,
                                    render: function(data, type, row, meta) {
                                        return `<span>${formatDate(data)} </span>`;
                                    }
                                },
                                {
                                    targets: 6,
                                    render: function(data, type, row) {
                                        return `<span class="badge ${data == 0 ? 'bg-label-primary' : data == 1 ? ' bg-label-success' : data == 2 ? ' bg-label-danger' : 'bg-label-danger' }" >${data == 0 ? 'Pending' : data == 1 ? 'Success' : data == 2 ? 'Cancel' : 'Cancel'} </span>`;
                                    }
                                },
                                {
                                    targets: -1,
                                    data: null,
                                    orderable: false,
                                    className: "text-end",
                                    render: function(data, type, row) {
                                        if (!roles.can_confirm && !roles.can_cancel) {
                                            return '';
                                        }
                                        let dropdownMenu = `
                                   <div class="dropdown">
                                       <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                           <i class="ti ti-dots-vertical"></i>
                                       </button>
                                       <div class="dropdown-menu">
                                           ${roles.can_confirm ? `<button class="dropdown-item btn-confirm" ${row.status == 1 ? 'disabled' : ''} data-id="${row.id}"><i class="ti ti-check me-2"></i>Confirm</button>` : ''}
                                           ${roles.can_cancel ? `<button class="dropdown-item btn-cancel" ${row.status == 2  ? 'disabled' : ''} data-id="${row.id}"><i class="ti ti-x me-2"></i>Cancel</button>` : ''}
                                       </div>
                                   </div>`;
                                        return dropdownMenu;
                                    },
                                }
                            ],
                        });
                    }
                    initAction();

                }
            })
        </script>
    @endpush
