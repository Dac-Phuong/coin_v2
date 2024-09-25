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
                </div>
                <div class="col-md-2 w-100 justify-content-between my-2 mr-3 flex-wrap d-flex px-4 ">
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
                </div>
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
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        $(document).on("DOMContentLoaded", function() {
            var dt_basic_table = $('#depositDatatable');
            var dt_basic = null;
            if (dt_basic_table.length) {
                const initAction = () => {
                    // Variable declaration
                    let roles = [];
                    // Show update
                    $(document).on('click', '.btn-edit', function() {
                        const data = getRowData($(this).closest('tr'));
                        $('#kt_modal_update_plan input[name="id"]').val(data.id);
                        $('#kt_modal_update_plan input[name="name"]').val(data.name);
                        $('#kt_modal_update_plan input[name="title"]').val(data.title);
                        $('#kt_modal_update_plan input[name="discount"]').val(data.discount);
                        $('#kt_modal_update_plan input[name="min_deposit"]').val(data.min_deposit);
                        $('#kt_modal_update_plan input[name="termination_fee"]').val(data
                            .termination_fee);
                        $('#kt_modal_update_plan select[name="coin_id"]').val(data.coin_id)
                        $('#data-input-data').empty();
                        $('#offcanvasEditPlan').offcanvas('show');
                    })
                    //  delete
                    $(document).on('click', '.btn-delete', function() {
                        const data = getRowData($(this).closest('tr'));
                        Swal.fire({
                            title: 'Do you want to delete?',
                            text: "You will not be able to undo this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Delete now!',
                            customClass: {
                                confirmButton: 'btn btn-primary me-1',
                                cancelButton: 'btn btn-label-secondary'
                            },
                            buttonsStyling: false
                        }).then(function(result) {
                            if (result.value) {
                                $.ajax({
                                    url: '{{ route('plan.delete') }}',
                                    type: 'POST',
                                    data: {
                                        id: data.id,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        dt_basic.ajax.reload();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Delete successful',
                                            customClass: {
                                                confirmButton: 'btn btn-success'
                                            }
                                        });
                                    }
                                });

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
                                    return `<a href="#" class="text-primary text-hover-primary btn-show-detail">  ${row.name_coin ?? ""}  </a>`;

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
                                           ${roles.can_update ? `<a class="dropdown-item btn-edit" href="javascript:void(0);"><i class="ti ti-pencil me-2"></i> Update</a>` : ''}
                                           ${roles.can_delete ? `<a class="dropdown-item btn-delete" href="javascript:void(0);"><i class="ti ti-trash me-2"></i> Delete</a>` : ''}
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
