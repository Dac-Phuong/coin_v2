<div class="modal fade" id="kt_modal_add_network" tabindex="-1" aria-hidden="true" >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Add New Network') }}</h4>
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
                <form id="kt_modal_add" class="form" 
                    enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Network Name') }}</label>
                                <input type="text" id="basic-icon-default-email" name="network_name"
                                    class="form-control" placeholder="" >
                                @error('network_name')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Network Fee')}} ($)</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    name="network_price" class="form-control" placeholder=""
                                    >
                                @error('network_price')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Status') }}</label>
                                <select class="form-select" name="status" id="basic-default-country">
                                    <option value="0">{{ __('Active') }} </option>
                                    <option value="1">{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Network Image') }}</label>
                                <input type="file" id="basic-icon-default-email" name="network_image"
                                    class="form-control" placeholder="">
                                @error('network_image')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="form-label" for="basic-default-country">{{ __('Description') }}</label>
                            <textarea class="form-control" placeholder="" name="description" 
                                rows="10"></textarea>
                            @error('description')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary " id="btn-submit" >
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
            let formData = new FormData($("#kt_modal_add")[0]);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('network.create') }}",
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
                        $('#kt_modal_add_network').modal('hide');
                        $('#networkDatatable').DataTable().ajax.reload();
                    } else if(res.error_code == 1) {
                        toastr.error(res.error);
                    }else{
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