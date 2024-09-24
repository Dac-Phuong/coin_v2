<div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Add New Investor') }}</h4>
                </div>
                <!--end::Modal title-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body mb-3">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="#" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label"
                                    for="basic-icon-default-user">{{ __('First and last name') }}</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                                    <input type="text" required id="basic-icon-default-user" name="fullname"
                                        class="form-control" placeholder="{{ __('Enter first and last name') }}">
                                </div>
                                @error('fullname')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-user">{{ __('Account name') }}</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                                    <input type="text" required id="basic-icon-default-user" name="username"
                                        class="form-control" placeholder="{{ __('Enter account name') }}">
                                </div>
                                @error('username')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    for="basic-icon-default-email">{{ __('Email Address') }}</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                    <input type="email" required id="basic-icon-default-email" name="email"
                                        class="form-control" placeholder="{{ __('Enter email address') }}"
                                        aria-label="john.doe">
                                </div>
                                @error('email')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label">{{ __('Status') }}</label>
                                <select id="defaultSelect" name="status" class="form-select">
                                    <option selected value="0">{{ __('Active') }}</option>
                                    <option value="1">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="multicol-password">{{ __('Password') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" required id="multicol-password" name="password"
                                            class="form-control" placeholder="············"
                                            aria-describedby="multicol-password2" fdprocessedid="vb9bj">
                                        <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
                                    @error('password')
                                        <span class="error text-danger fs-7">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit">
                            <span class="indicator-label">{{ __('Save') }}</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@push('scripts')
    <script>
        $("#btn-submit").click(function(e) {
            e.preventDefault();
            let formData = new FormData($("#kt_modal_add_user_form")[0]);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('investor.create') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error_code == -1) {
                        let error = res.data;
                        toastr.error(error, 'Lỗi');
                    } else if (res.error_code == 0) {
                        toastr.success("add successfully");
                        $('#kt_modal_add_user_form').modal('hide');
                        $('#userDatatable').DataTable().ajax.reload();
                    } else {
                        toastr.error("Add failed, try again later");
                    }
                },
                error: function(err) {
                    const e = JSON.parse(err.responseText);
                    if (e.error) {
                        toastr.error(e.error)
                    }
                }
            })
        });
    </script>
@endpush
