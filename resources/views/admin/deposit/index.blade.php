@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <div>
            <h4 class="py-3 mb-2" wire:poll.15s>
                <span class="text-muted fw-light">{{ __('Deposit Manage') }} /</span> {{ __('Deposit List') }}
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('Deposit List') }}</h5>
                    <button class="btn btn-primary template-customizer-reset-btn text-white mr-3" id="btn-reset-data"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reset data">
                        <i class="ti ti-refresh ti-sm"></i>
                        <span class="badge rounded-pill bg-danger badge-dot badge-notifications d-none"></span>
                    </button>
                </div>
                {{-- <div class="col-md-2 w-100 justify-content-between my-2 mr-3 flex-wrap d-flex px-4 ">
                    <div class="d-flex flex-wrap m-0 wrap-form">
                        <div class="d-flex align-items-center wrap-form-date">
                            <p class="m-0" style="width: 120px;font-weight: 600">{{ __('From date') }}</p>
                            <input type="date" class="form-control" value="" name="from_date"
                                style="max-width: 240px">
                        </div>
                        <div class="d-flex align-items-center wrap-to-date">
                            <p class="m-0" style="width: 160px;padding: 0 20px;font-weight: 600">{{ __('To date') }}
                            </p>
                            <input type="date" class="form-control" value="" name="to_date"
                                style="max-width: 240px;">
                        </div>
                    </div>
                </div> --}}
                <div class="card-datatable table-responsive pt-0">
                    <table class="table dataTable" id="depositDatatable">
                        <thead>
                            <tr>
                                <th>{{ __('Coin type') }}</th>
                                <th>{{ __('Name plan') }}</th>
                                <th>{{ __('Profit') }} (%)</th>
                                <th>{{ __('Sender') }}</th>
                                <th>{{ __('Deposit amount') }}</th>
                                <th>{{ __('Sending method') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Sent date') }}</th>
                                <th style="width:80px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @include('admin.deposit.modal.show')
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        // Ensure the baseUrl is correctly formatted
        $(document).on("DOMContentLoaded", function() {
            var dt_basic_table = $('#depositDatatable');
            var dt_basic = null;
            if (dt_basic_table.length) {
                const initAction = () => {
                    // Variable declaration
                    let roles = [];
                    // Show update
                    $(document).on('click', '.btn-show', function() {
                        const data = getRowData($(this).closest('tr'));
                        console.log(data);
                        $('#planName').text(data.plan_name || 'Deposit');
                        $('#profit').text(data.profit + '%');
                        $('#depositAmount').text(formatNumber(data.amount) + " " + data.name_coin);
                        $('#amountReceived').text(formatNumber(data.total_amount) + " " + data
                            .name_coin);
                        $('#sender').text(data.investor_name);
                        $('#numberDay').text(data.number_days);
                        $('#sentDate').text(formatDate(data.created_at));
                        $('#network').text(data.network_name || 'Deposit');
                        $('#coinPrice').text(formatNumber(data.current_coin_price) + " " + data
                            .name_coin);
                        $('#walletAddress').text(data.wallet_address);
                        $('#sendingMethod').html(data.type_payment == 0 ?
                            '<span class="text-danger">Processor</span>' : data.type_payment == 1 ?
                            '<span class="text-success">Account Balance</span>' :
                            '<span class="text-warning">Deposit</span>');
                        $('#status').html(data.status == 0 ?
                            '<span class="text-primary">Pending</span>' : data.status == 1 ?
                            '<span class="text-warning">Running</span>' : data.status == 2 ?
                            '<span class="text-success">Success</span>' :
                            '<span class="text-danger">Cancel</span>');
                        $('#kt_modal_show').modal('show');
                    })
                    $('#btn-reset-data').click(function() {
                        $('#depositDatatable').DataTable().ajax.reload();
                    })
                    //  confirm
                    $(document).on('click', '.btn-confirm', function() {
                        const data = getRowData($(this).closest('tr'));
                        $.ajax({
                            url: '{{ route('deposit.confirm') }}',
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
                            url: '{{ route('deposit.cancel') }}',
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
                            url: '{{ route('deposit.list') }}',
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
                                data: 'name_coin'
                            },
                            {
                                data: 'plan_name'
                            },
                            {
                                data: 'profit'
                            },
                            {
                                data: 'investor_name'
                            },
                            {
                                data: 'amount'
                            },
                            {
                                data: 'type_payment'
                            },
                            {
                                data: 'status'
                            },
                            {
                                data: 'created_at'
                            },
                            {
                                data: ''
                            }
                        ],
                        columnDefs: [{
                                targets: 0,
                                render: function(data, type, row) {
                                    return `<a href="#" class="text-primary text-hover-primary btn-show">  ${row.name_coin ?? ""}  </a>`;

                                }
                            },
                            {
                                targets: 1,
                                render: function(data, type, row) {
                                    return `<span >${data ?? 'Deposit'}  </span>`;
                                }
                            },
                            {
                                targets: 2,
                                render: function(data, type, row) {
                                    return `<span >${data}%  </span>`;
                                }
                            },
                            {
                                targets: 4,
                                render: function(data, type, row) {
                                    const data1 = parseFloat(data);
                                    return `<span>${formatNumber(data1)} ${row.name_coin} </span>`;
                                }
                            },
                            {
                                targets: 5,
                                render: function(data, type, row) {
                                    return `<span class="badge ${data == 0 ? 'bg-label-danger' : data == 1 ? ' bg-label-success' : 'bg-label-warning' }" >${data == 0 ? 'Processor' : data == 1 ? 'Account Balance' : 'Deposit'} </span>`;
                                }
                            },
                            {
                                targets: 6,
                                render: function(data, type, row) {
                                    return `<span class="badge ${data == 0 ? 'bg-label-primary' : data == 1 ? ' bg-label-warning' : data == 2 ? ' bg-label-success' : 'bg-label-danger' }" >${data == 0 ? 'Pending' : data == 1 ? 'Running' : data == 2 ? 'Success' : 'Cancel'} </span>`;
                                }
                            },
                            {
                                targets: 7,
                                render: function(data, type, row, meta) {
                                    return `<span>${formatDate(data)} </span>`;
                                }
                            },
                            {
                                targets: -1,
                                data: null,
                                orderable: false,
                                className: "text-end",
                                render: function(data, type, row) {
                                    if (!roles.can_update && !roles.can_delete) {
                                        return '';
                                    }
                                    let dropdownMenu = `
                                   <div class="dropdown">
                                       <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                           <i class="ti ti-dots-vertical"></i>
                                       </button>
                                       <div class="dropdown-menu">
                                           ${roles.can_update ? `<button class="dropdown-item btn-confirm" ${row.status !== 0 ? 'disabled' : ''} data-id="${row.id}"><i class="ti ti-check me-2"></i>Confirm</button>` : ''}
                                           ${roles.can_delete ? `<button class="dropdown-item btn-cancel" ${row.status == 2 || row.status == 3   ? 'disabled' : ''} data-id="${row.id}"><i class="ti ti-x me-2"></i>Cancel</button>` : ''}
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
