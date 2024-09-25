@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <div>
            <!-- Responsive Datatable -->
            <h4 class="py-3 mb-2">
                <span class="text-muted fw-light">{{ __('Plan Manage') }} /</span> {{ __('Plan List') }}
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('Plan List') }}</h5>
                    @can('create-plan')
                        <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px"
                            type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                            <span>
                                <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>
                                <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span>
                            </span>
                        </button>
                    @endcan
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="table dataTable" id="planDatatable">
                        <thead>
                            <tr>
                                <th>{{ __('Name plan') }}</th>
                                <th>{{ __('Name Title') }}</th>
                                <th>{{ __('Profit') }}</th>
                                <th>{{ __('Deposit') }}</th>
                                <th>{{ __('Termination fee') }}</th>
                                <th>{{ __('Create Date') }}</th>
                                <th style="width:80px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- BEGIN modal -->
        @include('admin.plans.modal.create')
        @include('admin.plans.modal.update')
        <!--  END modal -->
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        $(document).on("DOMContentLoaded", function() {
            var dt_basic_table = $('#planDatatable');
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
                        $('#kt_modal_update_plan input[name="termination_fee"]').val(data.termination_fee);
                        $('#kt_modal_update_plan select[name="coin_id"]').val(data.coin_id)
                        $('#data-input-data').empty();
                        data.plan_number_days.forEach(function(item, key) {
                            let html = `
                            <div class="row">
                                <input name="number_days[${key}][id]" value="${item.id}"  type="hidden">
                                <div class="mb-2 col-md-5 mb-0 " style="padding-right: 0px">
                                    <label class="form-label"
                                        for="form-repeater-${key}-days">{{ __('Number days') }}</label>
                                    <input type="number" required value="${item.number_days}" name="number_days[${key}][days]"
                                        id="form-repeater-${key}-days" class="form-control" placeholder="1 days">
                                </div>
                                <div class="mb-2 col-md-5 mb-0 " style="padding-right: 0px">
                                    <label class="form-label" for="form-repeater-${key}-profit">{{ __('Profit') }}(%)
                                        *</label>
                                    <input type="number" required step="any"
                                        name="number_days[${key}][profit]"
                                        id="form-repeater-${key}-profit" value="${item.profit}" class="form-control" placeholder="%">
                                </div>
                                <div class="mb-2 col-md-1 d-flex align-items-center mb-0">
                                    <div data-id="${item.id}" class="btn btn-label-danger btn-delete-input mt-4 waves-effect"  >
                                        <i class="ti ti-x ti-xs me-1"></i>
                                    </div>
                                </div>
                            </div> `;
                            $('#data-input-data').append(html);
                        })
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

                    function formatNumber(num, decimal = 0, type = 1) {
                        if (type !== 1) {
                            return num % 1 === 0 ?
                                num.toLocaleString('en-US') :
                                num.toLocaleString('en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 2
                                });
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
                            url: '{{ route('plan.list') }}',
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
                                data: 'name'
                            },
                            {
                                data: 'title'
                            },
                            {
                                data: 'discount'
                            },
                            {
                                data: 'min_deposit'
                            },
                            {
                                data: 'termination_fee'
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
                                targets: 1,
                                render: function(data, type, row) {
                                    return `<span >${data}  </span>`;
                                }
                            },
                            {
                                targets: 2,
                                render: function(data, type, row) {
                                    return `<span >${data}%  </span>`;
                                }
                            },
                            {
                                targets: 3,
                                render: function(data, type, row) {
                                    return `<span >${formatNumber(data,row.coins.decimal,2)} ${row.coins.coin_name} </span>`;
                                }
                            },
                            {
                                targets: 4,
                                render: function(data, type, row) {
                                    return `<span >${formatNumber(data,row.coins.decimal,2)} ${row.coins.coin_name} </span>`;
                                }
                            },
                            {
                                targets: 5,
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
