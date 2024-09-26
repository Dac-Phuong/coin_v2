@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <!-- Responsive Datatable -->

        <div class="row g-4">
            <h4 class="">{{ __('List Roles') }}</h4>
            <p class="mb-1 mt-0">{{ __('A role provides access to predefined menus and features to depend on') }}
                <br> {{ __('assigned roles, administrators can have access to what users need') }}.
            </p>
            <div id="rolesList" class="row g-6">
            </div>

        </div>

        {{-- BEGIN modal --}}
        @include('admin.user-management.roles.modal.create')
        @include('admin.user-management.roles.modal.update')
        {{-- END modal --}}
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>
    <script>
        $(document).ready(function() {
            var permissions = [];
            var title = $('.role-title');
            var roleName = $('#RoleName');
            let role_id = null;
            var checkboxes = $('.permission-checkbox');
            // checked all
            checkboxes.first().on('change', function() {
                const isChecked = $(this).is(':checked');
                checkboxes.each(function(index) {
                    if (index > 0) {
                        $(this).prop('checked', isChecked);
                    }
                });
            });
            // show modal
            $(document).on('click', '.showModal', function(event) {
                checkboxes.prop('checked', false);
                roleName.val('');
                role_id = null;
                permissions = [];
                title.text('{{ __('Add New Role') }}');
                $('#kt_modal_add').modal('show');
            });
            // show role
            function loadRoles() {
                $('#loading').show();
                $.ajax({
                    url: '{{ route('getRoles') }}',
                    type: 'GET',
                    success: function(res) {
                        var rolesList = $('#rolesList');
                        rolesList.empty();
                        if (res.data.roles.length > 0) {
                            $.each(res.data.roles, function(index, role) {
                                var roleHtml = `
                        <div class="col-xl-4 col-lg-6 col-md-6 my-2">
                            <div class="card py-1">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-normal mb-2">Tổng cộng ${role?.users?.length} người dùng</h6>
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0"> `;
                                $.each(role?.users?.slice(0, 5), function(i, user) {
                                    roleHtml += `
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            class="avatar avatar-sm pull-up" aria-label="${user?.name}"
                                            data-bs-original-title="${user?.name}">
                                            <img class="rounded-circle" src="${user?.avatar ? '/storage/' + user?.avatar : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAACUCAMAAAAj+tKkAAAANlBMVEX///+ZmZmVlZXa2tqSkpKPj4/m5ub8/PzNzc3w8PD4+PigoKDg4ODS0tK4uLioqKivr6/CwsIOjwJ1AAAFXElEQVR4nO1c23q0KgwdDoqAgr7/y/46nbbqAEkAne5vsy56N+kCciIJPh4NDQ0NDQ0NDQ0N/wcoY/QPjFGf5nOAHqfFzZ5x+QXmZ7dMQn+a1xNqXLxljHO2B99g/TJ+didVP81dJ1kUvOvmqf8USTXNVvI4uxdHaedpo3gzTaUXlti6IyRb9M0MewK9F8X+RnpmYeDRvh01c3dZtRlgzQtSlIO5g9/os+htkH68nJ52edv32sTu6nPuPck2AhTtlcaiBrpxvGO6jJ9xXTk9xjpnrvGJZq6wfRv4fIk16xrH+2LIdP097G01fpeYiq7Jb9vDvu4eVjzfb1R1iMbWpse4r2gppv7+badc7YyVw4WPNX+WnMtUir2HdLUYDpj/uF5BnNjuc7oXDqcRcqnDTyDix5rtif1vRofRiq5KcoMxEOnPNyOFSitsBVNWiADH3+L/RndC/LCCGk6IjRBhpyvgX74vjQqF4NfHbmw9gmGpN4Q9DE9o+ghfm10ZP3gP+JC68Q6wHhalDQgLmZNqrmZwgWkBAHrQBXbABsASZMkWgjdMPkMi4DPw+fxgHZdALFCPEbYykZaRkO7g1YOhQIOBKN9ba0g0yknAq+S5WrjATnqApcCeJjOrUQ9EPoJQnxGWwrMIPkZEmoU4HES8g0wtAlh5UDcfWJMZy4p3sPnVI5iVF8JOkNU64mTCEQXChlFGgsgKs+xYoQqpVdzMdkmm+2qDusrBQQARjlZIet4KpyEbYO1G2VrO/Q51GWYSVEKBk4PQlROQ1UoLyUFWxcC07Q0eJRc8G0w42kBOCtH1rHSRyiDXySzVSjDu9Ym0C0M50yeosQSRg3wzTNgJzkKeoOaEGP//QjxlF4SyIjXvRxRWfhGpXwwEEeT2DiZA/YAvARU3eP1jX/f/6wgybs/TE0pYUlfvYoKMs6/BhB96WPdyF8EVUvpB9CvGwUtyU+8GgltLfeslr3/pP72HYAmuNhLZnSFpnXkyQYIfXBVuXsTYHzCKxbGOQJLqB7GRZOuOROO8EQ7tbKiRBJcsSDsAQV5PHmfR1JQak6lzKzB3HYHKWanZjIKrZsEAF4JZYIaWPBIJhYI1uuGFjeBy6WVW4La4DUYQ1gwNZGR0I9K3OumIKbpJN1wkveOkU8aXU6pIZl8dvXqkUgdCvySumFMMM8rUca3hcOk8BB2v9mStONHmzOzyxiuFGSqYuNd19DLFC0NUr3PqgybSZitorkVbf3kjKjH/XzBoEDkVnteHiDiaLAv+RngLM5zME8H4BLU30whXHcESWQRBO84V9kIos8m2ulDKleUQdggtOns4RYXMpHDwL5AIZ5pIRFrpdGfIeRWMEr7lXAWrfeHtVArmPlTA02RHkW+83Wdl0XjUeb1FExBP9CcrKTyTsyHz4mkwfVpy6XzZKb7z4mEwdSSY0SA54ehZM3vjexzlFfr9FaexknKCxxOpMOJ4NLu6BMkloxCOfdlyeXt+GV3YAA6Zerm4vbRKw977NFMUYyes2gOina/hxfgR1VWaUt6A6poTIQtnLw+o9tZlz6/iawiFHLGg8CsavAzAJAsXZFzwaqgqQ3nJq6Z6llI6mxyBIrUvE5DLVS95J15lE697+Vf+cvL5cOI6fmAlF8GPWjsmA9f1iIBbcf1Tcp1vK3K555F273NeiXHE0HU1CLqxSJ89cJ4DIxCfWNjtnrTxnuhVGB32Swacuevftgeg+snDj/xk56c7P7Fwgh68PX+I5Hfntu+RQA3lGziKwVm2zSjwX2bPb7q44Y980eWhjO6nxflXIcf6eZl6/cc+ivP30faroaGhoaGhoeG/iH8yXzh9wKHc4QAAAABJRU5ErkJggg=='}" alt="Avatar">
                                        </li>`;
                                });
                                roleHtml += ` </ul>
                                        </div>
                                    <div class="">
                                        <div class="role-heading">
                                            <h4 class="mb-1">${role?.name}</h4>
                                            <div class="d-flex justify-content-between ">
                                                ${res.data.can_update ? `<div data-role-id="${role?.id}" class="role-edit-modal text-primary cursor-pointer edit-role-btn"> <span>Sửa vai trò</span> </div>`: '' }
                                                ${res.data.can_delete  ? `<div data-role-id="${role?.id}" class="text-muted cursor-pointer delete-role-btn"><i class="ti ti-trash ti-md"></i></div>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                                rolesList.append(roleHtml);
                            });
                            var addRoleHtml = `
                            ${res.data.can_create ? `<div class="col-xl-4 col-lg-6 col-md-6 mt-2">
                                                      <div class="card">
                                                          <div class="row">
                                                              <div class="col-sm-5">
                                                                  <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                                                      <img src="{{ asset('/assets/img/illustrations/add-new-roles.png') }}"
                                                                          class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83">
                                                                  </div>
                                                              </div>
                                                              <div class="col-sm-7">
                                                                  <div class="card-body text-sm-end text-center ps-sm-0">
                                                                      <button
                                                                          class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role waves-effect waves-light showModal">Thêm vai trò mới</button>
                                                                      <p class="mb-0 mt-1">Thêm vai trò mới,<br> nếu vai trò đó chưa tồn tại.</p>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>` : ''
                            }`;
                            rolesList.append(addRoleHtml);
                        }
                        $('#loading').hide();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching roles:', error);
                    }
                })
            }
            loadRoles();
            // edit role
            $(document).on('click', '.edit-role-btn', function() {
                var roleId = $(this).data('role-id');
                role_id = roleId;
                title.text('Sửa vai trò');
                $.get(`/user/role/edit/${role_id}`, function(res) {
                    if (res.error_code == 0) {
                        roleName.val(res.data.role.name);
                        checkboxes.prop('checked', false);
                        res.data.permissions.forEach(function(permissionId) {
                            $(`.permission-checkbox[value="${permissionId}"]`).prop(
                                'checked', true);
                        });
                        $('#addRoleModal').modal('show');
                    } else {
                        toastr.error(res.message, 'Error');
                    }
                });
            });
            // update role
            $(document).on('click', '.add-role-btn', function(event) {
                event.preventDefault();
                permissions = [];
                var checkedCheckboxes = $('.permission-checkbox:checked');
                checkedCheckboxes.each(function() {
                    var value = $(this).val();
                    if (value != 'on' && !permissions.includes(value)) {
                        permissions.push(value)
                    }
                });
                if (role_id) {
                    $.ajax({
                        url: '/user/role/update',
                        type: 'POST',
                        data: {
                            role_name: roleName.val(),
                            role_id: role_id,
                            permissions: permissions,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            if (res.error_code == 0) {
                                toastr.success(res.message);
                                $('#addRoleModal').modal('hide');
                                loadRoles();
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại');
                        }
                    });
                } else {
                    $.ajax({
                        url: '/user/role/create',
                        type: 'POST',
                        data: {
                            role_name: roleName.val(),
                            permissions: permissions,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            if (res.error_code == 0) {
                                toastr.success(res.message);
                                $('#addRoleModal').modal('hide');
                                loadRoles();
                            } else {
                                if (res.error_code == 1) {
                                    toastr.error(res.errors.role_name, 'Lỗi');
                                } else {
                                    toastr.error(res.message, 'Lỗi');
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại');
                        }
                    });
                }
            });
            $(document).on('click', '.delete-role-btn', function(event) {
                event.preventDefault();
                var roleId = $(this).data('role-id');
                Swal.fire({
                    title: 'Bạn có muốn xóa không?',
                    text: "Bạn sẽ không thể hoàn tác điều này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa ngay!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-1',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: `/user/role/delete/${roleId}`,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function(res) {
                                if (res.error_code == 0) {
                                    toastr.success(res.message);
                                    loadRoles();
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                toastr.error('Đã có lỗi xảy ra. Vui lòng thử lại');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
