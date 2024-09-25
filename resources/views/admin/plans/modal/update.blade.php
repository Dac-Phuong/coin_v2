<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditPlan" aria-labelledby="offcanvasEditUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">{{ __('Update Plan Fixed') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body h-100 mx-0 flex-grow-0 pt-0">
        <form class="add-new-user pt-0" id="kt_modal_update_plan">
            <input type="hidden" name="id" value="">
            <div class="ecommerce-customer-add-basic">
                <h6 class="mb-3">{{ __('Fixed plan information') }}</h6>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="ecommerce-customer-add-name">{{ __('Name plan') }}*</label>
                    <input type="text" required class="form-control" id="ecommerce-customer-add-name" placeholder=""
                        name="name">
                    @error('name')
                        <span class="error text-danger fs-7">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="ecommerce-customer-add-email">{{ __('Title plan') }}*</label>
                    <input type="text" required id="ecommerce-customer-add-email" class="form-control" placeholder=""
                        name="title">
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
                    <div id="data-input-data">

                    </div>
                </div>

            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary" id="btn-update">
                    <span class="indicator-label">{{ __('Save') }}</span>
                </button>
                <button type="reset" class="btn btn-light me-3 mx-4" data-bs-dismiss="offcanvas"
                    aria-label="Close">{{ __('Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
    <script>
        $(document).on('click', '#btn-add-input', function(e) {
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
                    <div class="btn btn-label-danger btn-delete-input mt-4 waves-effect" >
                        <i class="ti ti-x ti-xs me-1"></i>
                    </div>
                </div>
            </div>
        `;
            $('#data-input-data').append(html);
        })
        $('#data-input-data').on('click', '.btn-delete-input', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) {
                $(this).closest('.row').remove()
            } else {
                $.ajax({
                    url: "{{ route('item.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.error_code == 0) {
                            $(e.target).closest('.row').remove();
                            $('#planDatatable').DataTable().ajax.reload();
                        } else {
                            toastr.error(res.error);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        toastr.error("Delete failed, try again later");
                    }
                });
            }
        });

        $("#btn-update").click(function(e) {
            e.preventDefault();
            let formData = new FormData($("#kt_modal_update_plan")[0]);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('plan.update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error_code == -1) {
                        let error = res.data;
                        toastr.error(error);
                    } else if (res.error_code == 0) {
                        $('#offcanvasEditPlan').offcanvas('hide');
                        $('#planDatatable').DataTable().ajax.reload();
                        toastr.success("Update successfully");
                    } else if (res.error_code == 1) {
                        toastr.error(res.error);
                    } else {
                        toastr.error("Update failed, try again later");
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        });
    </script>
@endpush
