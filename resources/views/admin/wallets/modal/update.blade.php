<div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Update Wallet Address') }}</h4>
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
                <form id="kt_modal_update_wallet" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">{{ __('Wallet information') }}<i
                                    class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    aria-label="{{ __('Note: Each wallet is 1 line') }}"
                                    data-bs-original-title="{{ __('Note: Each wallet is 1 line') }}"></i></label>
                                    <input type="text" name="id" hidden>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Select Plan') }}</label>
                                <select class="form-select" name="plan_id" id="basic-default-country">
                                    <option value="">{{ __('Select Plan') }} </option>
                                    @foreach ($plan as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} -
                                            {{ $item->min_deposit }} </option>
                                    @endforeach
                                </select>
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
                              
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Status') }}</label>
                                <select class="form-select" name="status" id="basic-default-country">
                                    <option value="0">{{ __('Active') }} </option>
                                    <option value="1">{{ __('Inactive') }} </option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label"
                                    for="basic-default-country">{{ __('Wallet address') }}</label>
                                <input type="text" id="basic-icon-default-email" name="wallet_address"
                                    class="form-control" placeholder="Enter name wallet" aria-label="john.doe"
                                    aria-describedby="basic-icon-default-email2" fdprocessedid="40irmg">
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="btn-update-wallet">
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
        $("#btn-update-wallet").click(function(e) {
            e.preventDefault();
            let formData = new FormData($("#kt_modal_update_wallet")[0]);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('wallet.update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error_code == -1) {
                        let error = res.data;
                        toastr.error(error);
                    } else if (res.error_code == 0) {
                        toastr.success("Update successfully");
                        $('#kt_modal_update').modal('hide');
                        $('#walletDatatable').DataTable().ajax.reload();
                    } else if(res.error_code == 1) {
                        toastr.error(res.error);
                    }else{
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