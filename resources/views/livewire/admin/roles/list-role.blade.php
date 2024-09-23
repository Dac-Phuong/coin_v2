<div>

    <div class="row g-4">
        <h4 class="">{{ __('List Roles') }}</h4>
        <p class="mb-1 mt-0">{{ __('A role provides access to predefined menus and features to depend on') }}
            <br> {{ __('assigned roles, administrators can have access to what users need') }}.
        </p>
        @if (isset($list_role))
            @foreach ($list_role as $key => $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card py-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal mb-2">{{ __('Total') }} {{ count($role['users']) }} {{ __('User') }}</h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-sm pull-up" aria-label="Vinnie Mostowy"
                                        data-bs-original-title="Vinnie Mostowy">
                                        <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-sm pull-up" aria-label="Allen Rieske"
                                        data-bs-original-title="Allen Rieske">
                                        <img class="rounded-circle" src="../../assets/img/avatars/12.png"
                                            alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-sm pull-up" aria-label="Julee Rossignol"
                                        data-bs-original-title="Julee Rossignol">
                                        <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-sm pull-up" aria-label="Kaith D'souza"
                                        data-bs-original-title="Kaith D'souza">
                                        <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-sm pull-up" aria-label="John Doe"
                                        data-bs-original-title="John Doe">
                                        <img class="rounded-circle" src="../../assets/img/avatars/1.png" alt="Avatar">
                                    </li>
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-1">
                                @can('update-role')
                                    <div class="role-heading">
                                        <h4 class="mb-1">{{ $role->name }}</h4>
                                        <button data-kt-action="update" data-id={{ $role->id }} data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_update" class="role-edit-modal"><span>Sửa vai
                                                trò</span></button>
                                    </div>
                                @endcan
                                @can('delete-role')
                                    <div wire:click="delete({{ $role->id }})" class="text-muted cursor-pointer"><i
                                            class="ti ti-trash ti-md"></i></div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @can('create-role')
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100 py-3">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="../../assets/img/illustrations/add-new-roles.png"
                                    class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <button data-bs-toggle="modal" data-bs-target="#kt_modal_add"
                                    class="btn btn-primary mb-2 text-nowrap add-new-role waves-effect waves-light">
                                    <i class="ti ti-plus mr-4"></i> Thêm vai trò mới
                                </button>
                                <p class="mb-0 mt-1">Thêm vai trò nếu chưa có</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>

</div>
