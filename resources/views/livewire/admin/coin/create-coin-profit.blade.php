<div class="modal fades " id="kt_modal_add_profit" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-400px fixed top-0 bottom-0 right-0 m-0 "
        style="margin-left: auto !important;max-width: 400px; width: 100%;right: 0px; ;position: fixed;">
        <!--begin::Modal content-->
        <div class="modal-content absolute top-0 bottom-0 right-0" style="height: 100%;border-radius: 0px;">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Add Profit') }}</h4>
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
                    id="eCommerceCustomerAddForm" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <div class="ecommerce-customer-add-basic">
                        <div class="form-repeater">
                            <div class="mb-3 fv-plugins-icon-container align-items-center ">
                                <label class="form-label" for="ecommerce-customer-add-contact">{{ __('Select Plan') }}
                                    (%)*</label>
                                <div class="align-items-center d-flex">
                                    <select id="defaultSelect" wire:model.live="plan_id" class="form-select">
                                        <option value="">{{ __('Select plan') }}</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->name }} -
                                                {{ $plan->min_deposit }}</option>
                                        @endforeach
                                    </select>
                                    <div class="btn btn-primary waves-effect waves-light ml-2"
                                        wire:click="addInput({{ $i }})"
                                        style="width: 50px;margin-left: 10px;">
                                        <i class="ti ti-plus me-1"></i>
                                    </div>
                                </div>
                                @error('plan_id')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                @foreach ($inputs as $key => $input)
                                    <div class="row">
                                        <div class="mb-2 col-md-5 mb-0 " style="padding-right: 0px">
                                            <label class="form-label"
                                                for="form-repeater-1-1">{{ __('Number days') }}</label>
                                            <input type="number" required
                                                wire:model="number_days.{{ $key }}.number_days"
                                                id="form-repeater-1-1" class="form-control" placeholder="1 days">
                                        </div>
                                        <div class="mb-2 col-md-5 mb-0 " style="padding-right: 0px">
                                            <label class="form-label" for="form-repeater-1-1">{{ __('Profit') }}(%)
                                                *</label>
                                            <input type="text" required
                                                wire:model="number_days.{{ $key }}.profit"
                                                id="form-repeater-1-1" class="form-control" placeholder="%">
                                        </div>
                                        <div class="mb-2 col-md-1 d-flex align-items-center mb-0">
                                            <div class="btn btn-label-danger mt-4 waves-effect"
                                                wire:click="remove({{ $key }})">
                                                <i class="ti ti-x ti-xs me-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @error('number_days' . $key . 'profit')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('Save') }}</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                ...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
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
