<div class="modal fades " id="kt_modal_add" tabindex="-1" aria-hidden="true" >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-400px fixed top-0 bottom-0 right-0 m-0 "
        style="margin-left: auto !important;max-width: 400px; width: 100%;right: 0px; ;position: fixed;">
        <!--begin::Modal content-->
        <div class="modal-content absolute top-0 bottom-0 right-0" style="height: 100%;border-radius: 0px;">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Add New Plan Fixed') }}</h4>
                </div>
                <!--end::Modal title-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body " style="overflow-y: scroll">
                <!--begin::Form-->
                <form class="ecommerce-customer-add pt-0 fv-plugins-bootstrap5 fv-plugins-framework"
                    id="kt_modal_add_plan">
                    <div class="ecommerce-customer-add-basic">
                        <h6 class="mb-3">{{ __('Fixed plan information') }}</h6>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="ecommerce-customer-add-name">{{ __('Name plan') }}*</label>
                            <input type="text" required class="form-control" id="ecommerce-customer-add-name"
                                placeholder="" name="name">
                            @error('name')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="ecommerce-customer-add-email">{{ __('Title plan') }}*</label>
                            <input type="text" required id="ecommerce-customer-add-email" class="form-control"
                                placeholder="" name="title">
                            @error('title')
                                <span class="error text-danger fs-7">{{ $title }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="ecommerce-customer-add-contact">{{ __('Deposit') }}*</label>
                            <input type="number" step="any" required id="ecommerce-customer-add-contact"
                                class="form-control phone-mask" placeholder="" name="min_deposit">
                            @error('min_deposit')
                                <span class="error text-danger fs-7">{{ $title }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="ecommerce-customer-add-contact">{{ __('Termination fee') }}
                                *</label>
                            <input type="number" step="any" required id="ecommerce-customer-add-contact"
                                class="form-control phone-mask" placeholder="" name="termination_fee">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="basic-default-country">{{ __('Select Coin') }}</label>
                            <select class="form-select" required name="coin_id" id="basic-default-country">
                                <option value="">{{ __('Select Coin') }} </option>
                                @foreach ($coins as $coin)
                                    <option value="{{ $coin->id }}">{{ $coin->coin_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-repeater">
                            <div class="mb-3 fv-plugins-icon-container align-items-center ">
                                <label class="form-label" for="ecommerce-customer-add-contact">{{ __('Profit') }}
                                    (%)*</label>
                                <div class="align-items-center d-flex">
                                    <input type="number" step="any" required id="ecommerce-customer-add-contact"
                                        class="form-control phone-mask" placeholder="" name="discount">
                                    <div class="btn btn-primary waves-effect waves-light ml-2" id="btn-add-input"
                                        style="width: 50px;margin-left: 10px;">
                                        <i class="ti ti-plus me-1"></i>
                                    </div>
                                </div>
                                @error('discount')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div id="data-input">

                            </div>
                        </div>

                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary" id="btn-submit">
                            <span class="indicator-label">{{ __('Save') }}</span>
                        </button>
                        <button type="reset" class="btn btn-light me-3 mx-4" data-bs-dismiss="modal"
                            aria-label="Close" wire:loading.attr="disabled">{{ __('Cancel') }}</button>
                    </div>
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
        $('#btn-add-input').click(function(e) {
            e.preventDefault();
            let key = $('.row').length;
            let html = `
            <div class="row">
                <div class="mb-2 col-md-5 mb-0 " style="padding-right: 0px">
                    <label class="form-label"
                        for="form-repeater-${key}-days">{{ __('Number days') }}</label>
                    <input type="number" required name="number_days[${key}][days]"
                        id="form-repeater-${key}-days" class="form-control" placeholder="1 days">
                </div>
                <div class="mb-2 col-md-5 mb-0 " style="padding-right: 0px">
                    <label class="form-label" for="form-repeater-${key}-profit">{{ __('Profit') }}(%)
                        *</label>
                    <input type="number" required step="any"
                        name="number_days[${key}][profit]"
                        id="form-repeater-${key}-profit" class="form-control" placeholder="%">
                </div>
                <div class="mb-2 col-md-1 d-flex align-items-center mb-0">
                    <div class="btn btn-label-danger btn-delete-input mt-4 waves-effect"
                        wire:click="remove(${key})">
                        <i class="ti ti-x ti-xs me-1"></i>
                    </div>
                </div>
            </div>
        `;
            $('#data-input').append(html);
        })
        $('#data-input').on('click', '.btn-delete-input', function(e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });

        $("#btn-submit").click(function(e) {
            e.preventDefault();
            let formData = new FormData($("#kt_modal_add_plan")[0]);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('plan.create') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error_code == -1) {
                        let error = res.data;
                        toastr.error(error);
                    } else if (res.error_code == 0) {
                        toastr.success("add successfully");
                        $('#kt_modal_add').modal('hide');
                        $('#planDatatable').DataTable().ajax.reload();
                    } else if (res.error_code == 1) {
                        toastr.error(res.error);
                    } else {
                        toastr.error("Add failed, try again later");
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        });
    </script>
@endpush
