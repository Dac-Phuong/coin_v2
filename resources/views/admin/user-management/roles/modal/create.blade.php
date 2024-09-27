<div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered " style="min-width:750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header mb-3" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 role-title">{{ __('Add New Role') }}</h4>
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
                <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 mb-3 fv-plugins-icon-container">
                        <label class="form-label fs-6" for="modalRoleName">{{ __('Name Role') }}</label>
                        <input type="text" id="modalRoleName" required name="role" class="form-control"
                            placeholder="{{ __('Enter name role') }}" tabindex="-1">
                    </div>
                    <div class="col-12">
                        <h5>{{ __('Role permissions') }}</h5>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-medium text-heading">{{ __('Administrator access') }}<i class="ti ti-info-circle" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                aria-label="{{ __('Allow full access to the system') }}"
                                                data-bs-original-title="{{ __('Allow full access to the system') }}"></i>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input permission-checkbox" type="checkbox"
                                                        id="selectAll">
                                                    <label class="form-check-label" for="selectAll">
                                                        {{__('Select all')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if (isset($data))
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td class="text-nowrap fw-medium text-heading">
                                                    {{ __($item['label']) }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end">
                                                        <div class="form-check mb-0 me-4 me-lg-12">
                                                            <input class="form-check-input permission-checkbox"
                                                                name="permissions[]"
                                                                value="{{ $item['permissions']['list'] }}"
                                                                type="checkbox"
                                                                id="userManagementRead1.{{ $key }}">
                                                            <label class="form-check-label"
                                                                for="userManagementRead1.{{ $key }}">
                                                                Xem
                                                            </label>
                                                        </div>
                                                        @if (isset($item['permissions']['create']))
                                                            <div class="form-check mb-0 me-4 me-lg-12">
                                                                <input class="form-check-input permission-checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $item['permissions']['create'] }}"
                                                                    type="checkbox"
                                                                    id="userManagementRead2.{{ $key }}">
                                                                <label class="form-check-label"
                                                                    for="userManagementRead2.{{ $key }}">
                                                                    Thêm
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (isset($item['permissions']['update']))
                                                            <div class="form-check mb-0 me-4 me-lg-12">
                                                                <input class="form-check-input permission-checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $item['permissions']['update'] }}"
                                                                    type="checkbox"
                                                                    id="userManagementRead3.{{ $key }}">
                                                                <label class="form-check-label"
                                                                    for="userManagementRead3.{{ $key }}">
                                                                    Sửa
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (isset($item['permissions']['delete']))
                                                            <div class="form-check mb-0 me-4 me-lg-12">
                                                                <input class="form-check-input permission-checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $item['permissions']['delete'] }}"
                                                                    type="checkbox"
                                                                    id="userManagementRead4.{{ $key }}">
                                                                <label class="form-check-label"
                                                                    for="userManagementRead4.{{ $key }}">
                                                                    Xóa
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (isset($item['permissions']['confirm']))
                                                            <div class="form-check mb-0 me-4 me-lg-12">
                                                                <input class="form-check-input permission-checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $item['permissions']['confirm'] }}"
                                                                    type="checkbox"
                                                                    id="userManagementRead5.{{ $key }}">
                                                                <label class="form-check-label"
                                                                    for="userManagementRead5.{{ $key }}">
                                                                    Duyệt
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (isset($item['permissions']['cancel']))
                                                            <div class="form-check mb-0 me-4 me-lg-12">
                                                                <input class="form-check-input permission-checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $item['permissions']['cancel'] }}"
                                                                    type="checkbox"
                                                                    id="userManagementRead6.{{ $key }}">
                                                                <label class="form-check-label"
                                                                    for="userManagementRead6.{{ $key }}">
                                                                    Hủy
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit"
                            class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="save-role-btn">{{ __('Save') }}</button>
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
