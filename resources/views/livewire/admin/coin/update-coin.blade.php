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
                <form id="kt_modal_add_user_form" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Coin Name') }} <i
                                        class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                        aria-label="{{ __('Note: All capital letters without accents') }}"
                                        data-bs-original-title="{{ __('Note: All capital letters without accents') }}"></i></label>
                                <input type="text" id="basic-icon-default-email" wire:model.defer="coin_name"
                                    class="form-control" placeholder="USDT" aria-label="john.doe"
                                    aria-describedby="basic-icon-default-email2" fdprocessedid="40irmg">
                                @error('coin_name')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Coin Price') }}</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    wire:model.defer="coin_price" class="form-control" placeholder="$"
                                    aria-label="john.doe" aria-describedby="basic-icon-default-email2"
                                    fdprocessedid="40irmg">
                                @error('coin_price')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Min Withdraw') }}</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    wire:model.defer="min_withdraw" class="form-control" aria-label="john.doe"
                                    aria-describedby="basic-icon-default-email2" fdprocessedid="40irmg">
                                @error('min_withdraw')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Coin Fee') }}</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    wire:model.defer="coin_fee" class="form-control" aria-label="john.doe"
                                    aria-describedby="basic-icon-default-email2" fdprocessedid="40irmg">
                                @error('coin_fee')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label"
                                    for="basic-default-country">{{ __('Decimal number after comma') }}</label>
                                <input type="number" step="any" id="basic-icon-default-email"
                                    wire:model.defer="coin_decimal" class="form-control" placeholder="4"
                                    aria-label="john.doe" aria-describedby="basic-icon-default-email2"
                                    fdprocessedid="40irmg">
                                @error('coin_decimal')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Rate Coin') }}</label>
                                <select class="form-select" wire:model.defer="rate_coin" id="basic-default-country">
                                    <option value="0">{{ __('Manual') }}</option>
                                    <option value="1">{{ __('Auto') }} </option>
                                </select>
                                @error('rate_coin')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Status') }}</label>
                                <select class="form-select" wire:model.defer="status" id="basic-default-country">
                                    <option value="0">{{ __('Active') }} </option>
                                    <option value="1">{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="basic-default-country">{{ __('Coin Image') }}</label>
                                <input type="file" id="basic-icon-default-email" wire:model.defer="coin_image"
                                    class="form-control" placeholder="" aria-label="john.doe"
                                    aria-describedby="basic-icon-default-email2" fdprocessedid="40irmg">
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
                                                <input class="form-check-input" wire:model.defer="network_id"
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
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('Save') }}</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                ...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
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
