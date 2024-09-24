<div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Update Network') }}</h4>
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
                <form id="kt_modal_update_coin" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div>
                            <input type="text" name="id" hidden>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Coin Name') }} <i
                                        class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                        aria-label="{{ __('Note: All capital letters without accents') }}"
                                        data-bs-original-title="{{ __('Note: All capital letters without accents') }}"></i></label>
                                <input type="text" id="basic-icon-default-email" name="coin_name"
                                    class="form-control" placeholder="USDT">
                                @error('coin_name')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Coin Price') }}</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    name="coin_price" class="form-control" placeholder="$">
                                @error('coin_price')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Min Withdraw') }}</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    name="min_withdraw" class="form-control">
                                @error('min_withdraw')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Coin Fee') }}</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    name="coin_fee" class="form-control">
                                @error('coin_fee')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label"
                                    for="basic-default-country">{{ __('Decimal number after comma') }}</label>
                                <input type="number" value="2" step="any" id="basic-icon-default-email"
                                    name="coin_decimal" class="form-control" placeholder="4">
                                @error('coin_decimal')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Rate Coin') }}</label>
                                <select class="form-select" name="rate_coin" id="basic-default-country">
                                    <option value="0">{{ __('Manual') }}</option>
                                    <option value="1">{{ __('Auto') }} </option>
                                </select>
                                @error('rate_coin')
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
                                <label class="form-label" for="basic-default-country">{{ __('Coin Image') }}</label>
                                <input type="file" id="basic-icon-default-email" name="coin_image"
                                    class="form-control" placeholder="">
                                @error('coin_image')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label"
                                    for="basic-default-country">{{ __('Select Network') }}</label>
                                <div class="d-flex flex-wrap">
                                    @if (isset($network))
                                        @foreach ($network as $item)
                                            <div class="form-check me-3 mb-1">
                                                <input class="form-check-input" name="network_id[]"
                                                    type="checkbox" value="{{ $item->id }}"
                                                    id="network-{{ $item->id }}">
                                                <label class="form-check-label" for="network-{{ $item->id }}">
                                                    {{ $item->network_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
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
                        <button type="submit" class="btn btn-primary" id="btn-update-coin">
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
        $("#btn-update-coin").click(function(e) {
            e.preventDefault();
            let formData = new FormData($("#kt_modal_update_coin")[0]);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('coin.update') }}",
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
                        $('#coinDatatable').DataTable().ajax.reload();
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