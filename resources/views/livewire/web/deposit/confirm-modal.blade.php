<div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered" style="max-width:450px !important">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 " style="color:#ffb821">Notification</h4>
                </div>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body mb-3">
                <div class="mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            @if($loading)
                                <label class="form-label" for="basic-icon-default" style="color:#ffb821">Loading...</label>
                            @elseif( isset( $plan) && $plan->package_type == 1 && $investor_with_plans->status == 1)
                                <label class="form-label" for="basic-icon-default" style="color:#ffb821">If you
                                    If you cancel this plan before it expires, the cancellation fee is:
                                    {{ $plan->termination_fee }}  {{ $plan->coin_name }}</label>
                            @else
                                <label class="form-label" for="basic-icon-default" style="color:#ffb821">
                                    Are you sure you want to cancel your plans?</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-center pt-15">
                    <div class="text_but p-0 d-flex">
                        <div class="but2 p-2 w-50  font-weight-bold" wire:click="confirm_cancel"
                            style=" cursor: pointer; margin-right: 15px;color:#cb3a7f"> Confirm </div>
                        <div class="but p-2 w-50  font-weight-bold" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled" style=" cursor: pointer;color:#cb3a7f">Cancel
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
