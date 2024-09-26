@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <!-- Responsive Datatable -->
        <div>
            <h4 class="py-3 mb-2">
                <span class="text-muted fw-light">{{ __('Permission Manager') }} /</span> {{ __('List User') }}
            </h4>
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">{{ __('List User') }}</h5>
                    @can('create-user')
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
                    <table class="table dataTable" id="userDatatable">
                        <thead>
                            <tr>
                                <th>{{ __('User Name') }}</th>
                                <th>{{ __('Email Address') }}</th>
                                <th>{{ __('Roles') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th style="width:80px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- BEGIN modal -->
        @include('admin.user-management.users.modal.create')
        @include('admin.user-management.users.modal.update')
        <!--  END modal -->
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        // Ensure the baseUrl is correctly formatted
        $(document).on("DOMContentLoaded", function() {
            var dt_basic_table = $('#userDatatable');
            var dt_basic = null;
            if (dt_basic_table.length) {
                const initAction = () => {
                    // Variable declaration
                    let roles = [];
                    // Show update
                    $(document).on('click', '.btn-show', function() {
                        const data = getRowData($(this).closest('tr'));
                        $('#kt_modal_update_user input[name="id"]').val(data.id);
                        $('#kt_modal_update_user input[name="name"]').val(data.name);
                        $('#kt_modal_update_user input[name="email"]').val(data.email);
                        $('#kt_modal_update_user select[name="role"]').val(data.role);
                        $('#kt_modal_update').modal('show');
                    })
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
                                    url: '{{ route('user.delete') }}',
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
                            url: '{{ route('user.list') }}',
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
                                data: 'email'
                            },
                            {
                                data: 'role'
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
                                    return `<a href="#" class="text-primary text-hover-primary btn-show">  ${data ?? ""}  </a>`;
                                }
                            },
                            {
                                targets: 3,
                                render: function(data, type, row) {
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
                                           ${roles.can_update ? `<button class="dropdown-item btn-show"><i class="ti ti-pencil me-2"></i>Update</button>` : ''}
                                           ${roles.can_delete ? `<button class="dropdown-item btn-delete"><i class="ti ti-trash me-2"></i>Delete</button>` : ''}
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
