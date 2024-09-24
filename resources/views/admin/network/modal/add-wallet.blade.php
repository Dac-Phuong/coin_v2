<div class="modal fade" id="kt_modal_add_wallet" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Add New Wallet') }}</h4>
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
                <form id="kt_modal_wallet" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">{{ __('Enter list wallet') }}<i
                                    class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    aria-label="{{ __('Note: Each wallet is 1 line') }}"
                                    data-bs-original-title="{{ __('Note: Each wallet is 1 line') }}"></i></label>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Select Plan') }}</label>
                                <select class="form-select" name="plan_id" id="basic-default-country">
                                    <option value="">{{ __('Select Plan') }} </option>
                                    @foreach ($plan as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} -
                                            {{ $item->min_deposit }} </option>
                                    @endforeach
                                </select>
                                @error('plan_id')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label"
                                    for="basic-default-country">{{ __('Select Network') }}</label>
                                <select class="form-select" name="network_id" id="basic-default-country">
                                    <option value="">{{ __('Select Network') }} </option>
                                    @foreach ($network as $item)
                                        <option value="{{ $item->id }}">{{ $item->network_name }} </option>
                                    @endforeach
                                </select>
                                @error('network_id')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="form-label"
                                for="basic-default-country">{{ __('List address wallet') }}</label>
                            <textarea class="form-control" placeholder="{{ __('Enter list address wallet') }}" name="wallet_address"
                                id="exampleFormControlTextarea1" rows="15"></textarea>
                            @error('wallet_address')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                            >{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit-wallet" >
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
        $("#btn-submit-wallet").click(function(e) {
            e.preventDefault();
            let formData = new FormData($("#kt_modal_wallet")[0]);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('wallet.create') }}",
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
                        $('#kt_modal_add_wallet').modal('hide');
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