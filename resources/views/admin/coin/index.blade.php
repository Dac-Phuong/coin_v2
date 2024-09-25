@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <h4 class="py-3 mb-2">
            <span class="text-muted fw-light">{{ __('Coin Manage') }} /</span> {{ __('Coin List') }}
        </h4>
        <div class="card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header">{{ __('Coin List') }}</h5>
                <div>
                    @can('create-coin')
                        <a href="" class="btn btn-primary template-customizer-reset-btn text-white" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Reset Page to update price coin" onclick="location.reload();"><i
                                class="ti ti-refresh ti-sm"></i><span
                                class="badge rounded-pill bg-danger badge-dot badge-notifications d-none"></span></a>
                        <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light"
                            style="margin-right:24px" type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                            <span>
                                <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>
                                <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span>
                            </span>
                        </button>
                    @endcan
                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table class="table dataTable" id="coinDatatable">
                    <thead>
                        <tr>
                            <th>{{ __('Coin Name') }}</th>
                            <th>{{ __('Coin Image') }}</th>
                            <th>{{ __('Network Group') }}</th>
                            <th>{{ __('Coin Price') }}</th>
                            <th>{{ __('Coin Fee') }}</th>
                            <th>{{ __('Min Withdraw') }}</th>
                            <th>{{ __('Rate Coin') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width:80px">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @include('admin.coin.modal.create')
        @include('admin.coin.modal.update')
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        $(document).on("DOMContentLoaded", function() {
            var dt_basic_table = $('#coinDatatable');
            var dt_basic = null;
            if (dt_basic_table.length) {
                const initAction = () => {
                    // Variable declaration
                    let roles = [];
                    // Show update
                    $(document).on('click', '.btn-edit', function() {
                        const data = getRowData($(this).closest('tr'));
                        $('#kt_modal_update_coin input[name="id"]').val(data.id);
                        $('#kt_modal_update_coin input[name="coin_name"]').val(data.coin_name);
                        $('#kt_modal_update_coin input[name="coin_price"]').val(data.coin_price);
                        $('#kt_modal_update_coin input[name="coin_fee"]').val(data.coin_fee);
                        $('#kt_modal_update_coin input[name="min_withdraw"]').val(data.min_withdraw);
                        $('#kt_modal_update_coin input[name="description"]').val(data.description);
                        $('#kt_modal_update_coin select[name="rate_coin"]').val(data.rate_coin)
                        $('#kt_modal_update_coin select[name="status"]').val(data.status)
                        $('#kt_modal_update_coin input[name="network_id[]"]').prop('checked', false);
                        const networkIds = JSON.parse(data.network_id);
                        networkIds.forEach(function(id) {
                            $('#kt_modal_update_coin input[name="network_id[]"][value="' + id +
                                '"]').prop('checked', true);
                        });
                        $('#kt_modal_update').modal('show');
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
                                    url: '{{ route('coin.delete') }}',
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

                    function formatNumber(num, decimal = 2, type = 1) {
                        if (type !== 1) {
                            return num % 1 === 0 ?
                                num.toLocaleString('en-US') :
                                num.toLocaleString('en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: decimal
                                });;
                        }
                        return new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD',
                            minimumFractionDigits: decimal,
                            maximumFractionDigits: decimal
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
                            url: '{{ route('coin.list') }}',
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
                                data: 'coin_name'
                            },
                            {
                                data: 'coin_image'
                            },
                            {
                                data: 'network_name'
                            },
                            {
                                data: 'coin_price'
                            },
                            {
                                data: 'coin_fee'
                            },
                            {
                                data: 'min_withdraw'
                            },
                            {
                                data: 'rate_coin'
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
                                    return `<a href="#" class="text-primary text-hover-primary btn-show-detail">  ${data ?? ""}  </a>`;

                                }
                            },
                            {
                                targets: 1,
                                render: function(data, type, row) {
                                    return `<img src="${data}" style="height:50px" alt="coin Image">`;
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
                                render: function(data, type, row) {
                                    return `<span>${formatNumber(data, row.coin_decimal)} </span>`;
                                }
                            },
                            {
                                targets: 4,
                                render: function(data, type, row) {
                                    return `<span>${formatNumber(data, row.coin_decimal, 2)} ${row.coin_name}</span>`;
                                }
                            },
                            {
                                targets: 5,
                                render: function(data, type, row, meta) {
                                    return `<span>${formatNumber(data, row.coin_decimal, 2)} ${row.coin_name}</span>`;
                                }
                            },
                            {
                                targets: 6,
                                render: function(data, type, row, meta) {
                                    return `${data == 1 ? '<span class="badge bg-label-primary" text-capitalized="">Auto</span>' : '<span class="badge bg-label-danger" text-capitalized="">Manual</span>'}`;

                                }
                            },
                            {
                                targets: 7,
                                render: function(data, type, row, meta) {
                                    return `${data == 0 ? '<span class="badge bg-label-success" text-capitalized="">active</span>' : '<span class="badge bg-label-danger" text-capitalized="">inactive</span>'}`;

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
