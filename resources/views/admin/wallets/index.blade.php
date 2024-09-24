@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <div>
            <!-- Responsive Datatable -->
            <h4 class="py-3 mb-2">
                <span class="text-muted fw-light">{{ __('Wallet Manage') }} /</span> {{ __('Wallet List') }} </span>
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('Wallet List') }}</h5>
                    <a href="{{ url('admin/list-network') }}"
                        class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px">
                        <span>
                            <i class="ti ti-arrow-left"></i>
                            <span class="d-none d-sm-inline-block">{{ __('Go back') }}</span>
                        </span>
                    </a>
                </div>

                <div class="card-datatable table-responsive pt-0">
                    <table class="table dataTable" id="walletDatatable">
                        <thead>
                            <tr>
                                <th>{{ __('Network Name') }}</th>
                                <th>{{ __('Plan Name') }}</th>
                                <th>{{ __('Wallet Address') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th style="width:80px">{{ __('Action') }}</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        @include('admin.wallets.modal.update')
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        $(document).on("DOMContentLoaded", function() {
            var dt_basic_table = $('#walletDatatable');
            var network_id = {{ $id }};
            var dt_basic = null;
            var roles = [];
            if (dt_basic_table.length) {
                const initAction = () => {
                    $(document).on('click', '.btn-edit', function() {
                        const data = getRowData($(this).closest('tr'));
                        $('#kt_modal_update_wallet input[name="id"]').val(data.id);
                        $('#kt_modal_update_wallet select[name="plan_id"]').val(data.plan_id);
                        $('#kt_modal_update_wallet select[name="network_id"]').val(data
                            .network_id);
                        $('#kt_modal_update_wallet input[name="wallet_address"]').val(data
                            .wallet_address);
                        $('#kt_modal_update_wallet select[name="status"]').val(data.status)
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
                                    url: '{{ route('wallet.delete') }}',
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
                            url: '{{ route('wallet.list') }}',
                            type: "POST",
                            data: function(data) {
                                data._token = "{{ csrf_token() }}";
                                data.network_id = network_id;
                            },
                            "dataSrc": function(res) {
                                roles = res.role
                                return res.data;
                            }
                        },
                        columns: [{
                                data: 'network_name'
                            },
                            {
                                data: 'plan_name'
                            },
                            {
                                data: 'wallet_address'
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
                                    return `<a href="#" class="text-primary text-hover-primary btn-show-detail">  ${data ?? ""}  </a>`;

                                }
                            },
                            {
                                targets: 2,
                                render: function(data, type, row) {
                                    return `<span >${data}  </span>`;
                                }
                            },
                            {
                                targets: 3,
                                render: function(data, type, row) {
                                    return `${data == 0 ? '<span class="badge bg-label-success" text-capitalized="">active</span>' : '<span class="badge bg-label-danger" text-capitalized="">inactive</span>'}`;
                                }
                            },
                            {
                                targets: 4,
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
