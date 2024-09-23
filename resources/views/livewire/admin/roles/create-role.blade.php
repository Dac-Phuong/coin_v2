<div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered " style="min-width:750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header mb-3" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Add New Role') }}</h4>
                </div>
                <!--end::Modal title-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body py-0 mb-4">
                <!--begin::Form-->
                <form wire:submit.prevent="submit" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 mb-3 fv-plugins-icon-container">
                        <label class="form-label fs-6" for="modalRoleName">{{ __('Name Role') }}</label>
                        <input type="text" id="modalRoleName" required wire:model.defer="role" class="form-control"
                            placeholder="{{ __('Enter name role') }}" tabindex="-1">
                        @error('role')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="col-12">
                        <h5>{{ __('Role permissions') }}</h5>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Administrator access') }} <i
                                                class="ti ti-info-circle" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                aria-label="{{ __('Allow full access to the system') }}"
                                                data-bs-original-title="{{ __('Allow full access to the system') }}"></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" wire:model.live="selectAll"
                                                    type="checkbox" class="check-all" id="selectAll">
                                                <label class="form-check-label" for="selectAll">
                                                    {{ __('Select All') }}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Statistical manage') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input checkbox-item"
                                                        wire:model.defer="permissions" type="checkbox" value="dashboard"
                                                        id="finManagement">
                                                    <label class="form-check-label" for="finManagement">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('User manager') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-user" id="userManagementView">
                                                    <label class="form-check-label" for="userManagementView">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="create-user" id="userManagementRead">
                                                    <label class="form-check-label" for="userManagementRead">
                                                        {{ __('Add') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="update-user" id="userManagementWrite">
                                                    <label class="form-check-label" for="userManagementWrite">
                                                        {{ __('Update') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="delete-user" id="userManagementCreate">
                                                    <label class="form-check-label" for="userManagementCreate">
                                                        {{ __('Delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Role manager') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-role" id="roleView">
                                                    <label class="form-check-label" for="roleView">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="create-role" id="dispManagementRead">
                                                    <label class="form-check-label" for="dispManagementRead">
                                                        {{ __('Add') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="update-role" id="dispManagementWrite">
                                                    <label class="form-check-label" for="dispManagementWrite">
                                                        {{ __('Update') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="delete-role"
                                                        id="dispManagementCreate">
                                                    <label class="form-check-label" for="dispManagementCreate">
                                                        {{ __('Delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Investor manage') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-investor"
                                                        id="customerManagement">
                                                    <label class="form-check-label" for="customerManagement">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="create-investor"
                                                        id="customerManagementAdd">
                                                    <label class="form-check-label" for="customerManagementAdd">
                                                        {{ __('Add') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="update-investor"
                                                        id="customerManagementUpdate">
                                                    <label class="form-check-label" for="customerManagementUpdate">
                                                        {{ __('Update') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="delete-investor"
                                                        id="customerManagementDelete">
                                                    <label class="form-check-label" for="customerManagementDelete">
                                                        {{ __('Delete') }}
                                                    </label>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Manage investment plan') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-plan" id="roleViewCategory">
                                                    <label class="form-check-label" for="roleViewCategory">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="create-plan" id="dbManagementRead">
                                                    <label class="form-check-label" for="dbManagementRead">
                                                        {{ __('Add') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="update-plan" id="dbManagementWrite">
                                                    <label class="form-check-label" for="dbManagementWrite">
                                                        {{ __('Update') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="delete-plan" id="dbManagementCreate">
                                                    <label class="form-check-label" for="dbManagementCreate">
                                                        {{ __('Delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Network manage') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-network" id="productView">
                                                    <label class="form-check-label" for="productView">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="create-network"
                                                        id="contentManagementRead">
                                                    <label class="form-check-label" for="contentManagementRead">
                                                        {{ __('Add') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="update-network"
                                                        id="contentManagementWrite">
                                                    <label class="form-check-label" for="contentManagementWrite">
                                                        {{ __('Update') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="delete-network"
                                                        id="contentManagementCreate">
                                                    <label class="form-check-label" for="contentManagementCreate">
                                                        {{ __('Delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Coin manage') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-coin" id="productView">
                                                    <label class="form-check-label" for="productView">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="create-coin"
                                                        id="contentManagementRead">
                                                    <label class="form-check-label" for="contentManagementRead">
                                                        {{ __('Add') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="update-coin"
                                                        id="contentManagementWrite">
                                                    <label class="form-check-label" for="contentManagementWrite">
                                                        {{ __('Update') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="delete-coin"
                                                        id="contentManagementCreate">
                                                    <label class="form-check-label" for="contentManagementCreate">
                                                        {{ __('Delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Wallet manage') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-wallets" id="productView">
                                                    <label class="form-check-label" for="productView">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="create-wallets"
                                                        id="contentManagementRead">
                                                    <label class="form-check-label" for="contentManagementRead">
                                                        {{ __('Add') }}
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="update-wallets"
                                                        id="contentManagementWrite">
                                                    <label class="form-check-label" for="contentManagementWrite">
                                                        {{ __('Update') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="delete-wallets"
                                                        id="contentManagementCreate">
                                                    <label class="form-check-label" for="contentManagementCreate">
                                                        {{ __('Delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Manage deposits') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-deposit" id="apiRead">
                                                    <label class="form-check-label" for="apiRead">
                                                        {{ __('View') }}
                                                    </label>

                                                </div>
                                                {{-- <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="history-deposit" id="reportingRead">
                                                    <label class="form-check-label" for="reportingRead">
                                                        Xem lịch sử
                                                    </label>
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Manage withdraw') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="list-withdraw" id="reportingRead">
                                                    <label class="form-check-label" for="reportingRead">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ __('Settings manage') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" wire:model.defer="permissions"
                                                        type="checkbox" value="settings" id="apiRead">
                                                    <label class="form-check-label" for="apiRead">
                                                        {{ __('View') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit"
                            class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">{{ __('Save') }}</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close">{{ __('Cancel') }}</button>
                    </div>
                    <input type="hidden">
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
