<div class="modal fades " id="kt_modal_add" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-400px fixed top-0 bottom-0 right-0 m-0 "
        style="margin-left: auto !important;max-width: 550px; width: 100%;right: 0px; ;position: fixed;">
        <!--begin::Modal content-->
        <div class="modal-content absolute top-0 bottom-0 right-0" style="height: 100%;border-radius: 0px;">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Add Plan Daily') }}</h4>
                </div>
                <!--end::Modal title-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body" style="overflow-y: scroll">
                <!--begin::Form-->
                <form class="ecommerce-customer-add pt-0 fv-plugins-bootstrap5 fv-plugins-framework"
                    id="eCommerceCustomerAddForm" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <div class="ecommerce-customer-add-basic mb-3">
                        <h6 class="mb-3">{{ __('Daily Planning Information') }}</h6>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="ecommerce-customer-add-name">{{ __('Name plan') }}*</label>
                            <input type="text" required class="form-control" id="ecommerce-customer-add-name"
                                placeholder="{{ __('Enter name plan') }}" wire:model.defer="name">
                            @error('name')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="ecommerce-customer-add-email">{{ __('Name Title') }}*</label>
                            <input type="text" required id="ecommerce-customer-add-email" class="form-control"
                                placeholder="{{ __('Enter title plan') }}" wire:model.defer="title">
                            @error('title')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label"
                                for="ecommerce-customer-add-contact">{{ __('Start Date') }}*</label>
                            <input type="date" required id="ecommerce-customer-add-contact"
                                class="form-control phone-mask" placeholder="" wire:model.defer="from_date">
                            @error('from_date')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label"
                                for="ecommerce-customer-add-contact">{{ __('Closing Date') }}*</label>
                            <input type="date" required id="ecommerce-customer-add-contact"
                                class="form-control phone-mask" placeholder="" wire:model.defer="end_date">
                            @error('end_date')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label"
                                for="ecommerce-customer-add-contact">{{ __('End Date') }}*</label>
                            <input type="date" required id="ecommerce-customer-add-contact"
                                class="form-control phone-mask" placeholder="" wire:model.defer="to_date">
                            @error('to_date')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-repeater">
                            <div class="mb-3 fv-plugins-icon-container align-items-center ">
                                <label class="form-label" for="ecommerce-customer-add-contact">{{ __('Profit') }}
                                    (%)*</label>
                                <div class="align-items-center d-flex">
                                    <input type="text" required id="ecommerce-customer-add-contact"
                                        class="form-control phone-mask" placeholder="{{ __('Enter % profit') }}"
                                        wire:model.defer="discount">
                                    <div class="btn btn-primary waves-effect waves-light ml-2"
                                        wire:click="addInput({{ $i }})"
                                        style="width: 50px;margin-left: 10px;">
                                        <i class="ti ti-plus me-1"></i>
                                    </div>
                                </div>
                                @error('discount')
                                    <span class="error text-danger fs-7">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                @foreach ($inputs as $key => $input)
                                    <div class="row">
                                        <div class="mb-2 col-md-3 mb-0 " style="padding-right: 0px">
                                            <label class="form-label" for="form-repeater-1-1">{{ __('Profit') }}
                                                (%)
                                                *</label>
                                            <input type="number" required
                                                wire:model="discount_daily.{{ $key }}.discount"
                                                id="form-repeater-1-1" class="form-control" placeholder="%">
                                        </div>
                                        <div class="mb-2 col-md-4 mb-0 pr-0" style="padding-right: 0px">
                                            <label class="form-label"
                                                for="form-repeater-1-2">{{ __('Start date') }}*</label>
                                            <input type="date" required id="form-repeater-1-2"
                                                wire:model="discount_daily.{{ $key }}.start_date"
                                                class="form-control">
                                        </div>
                                        <div class="mb-2 col-md-4 mb-0 pr-0" style="padding-right: 0px">
                                            <label class="form-label"
                                                for="form-repeater-1-2">{{ __('End date') }}*</label>
                                            <input type="date" required id="form-repeater-1-2"
                                                wire:model="discount_daily.{{ $key }}.end_date"
                                                class="form-control">

                                        </div>
                                        <div class="mb-2 col-md-1 d-flex align-items-center mb-0">
                                            <div class="btn btn-label-danger mt-4 waves-effect"
                                                wire:click="remove({{ $key }})">
                                                <i class="ti ti-x ti-xs me-1"></i>
                                            </div>
                                        </div>
                                        @error('discount_daily.' . $key . '.start_date')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                        @error('discount_daily.' . $key . '.start_end')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="ecommerce-customer-add-contact">{{ __('Min Deposit') }}
                            *</label>
                        <input type="text" required id="ecommerce-customer-add-contact"
                            class="form-control phone-mask" placeholder="{{ __('Enter profit') }}"
                            wire:model.defer="min_deposit">
                        @error('min_deposit')
                            <span class="error text-danger fs-7">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label"
                            for="ecommerce-customer-add-contact">{{ __('Max Deposit') }}*</label>
                        <input type="text" required id="ecommerce-customer-add-contact"
                            class="form-control phone-mask" placeholder="{{ __('Enter profit') }}"
                            wire:model.defer="max_deposit">
                        @error('max_deposit')
                            <span class="error text-danger fs-7">{{ $message }}</span>
                        @enderror
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
