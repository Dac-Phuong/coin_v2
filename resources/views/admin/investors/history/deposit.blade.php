@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <div>
            <h4 class="py-3 mb-2">
                <span class="text-muted fw-light">{{ __('Investor Manager') }} /</span> {{ __('Investor List') }} /</span>
                {{ __('Deposit History') }}
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('Investor List') }}</h5>
                    <a href="{{ url('admin/list-investor') }}"
                        class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px">
                        <span>
                            <i class="ti ti-arrow-left"></i>
                            <span class="d-none d-sm-inline-block">{{ __('Go back') }}</span>
                        </span>
                    </a>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="table dataTable" id="depositDatatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Name plan') }}</th>
                                <th scope="col">{{ __('Number of days') }}</th>
                                <th scope="col">{{ __('Profit') }}</th>
                                <th scope="col">{{ __('Deposits Amount') }}</th>
                                <th scope="col">{{ __('Amount Received') }}</th>
                                <th scope="col">{{ __('Send date') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- @push('scripts')
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
<script>
    $(document).on("DOMContentLoaded", function() {
        var dt_basic_table = $('#investorDatatable');
        var investor_id = {{ $id }};
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
                        url: '{{ route('history.deposit') }}',
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
                            data: 'username'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'balance'
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
                                return `<span >${formatNumber(data)}  </span>`;
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
                                           ${roles.can_deposit ? `<a class="dropdown-item" href="/admin/investor/history/deposit/${row.id}"><i class="ti ti-history"></i> History Deposit</a>` : ''}
                                           ${roles.can_withdraw ? `<a class="dropdown-item" href="/admin/investor/history/withdraw/${row.id}"><i class="ti ti-history"></i> History Withdraw</a>` : ''}
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
@endpush --}}
