<div class="modal fade" id="kt_modal_show" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px" style="max-width: 1000px;">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body mb-3">
                <!--begin::Form-->
                <form id="kt_modal_show_deposit_form" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div class="card" style="box-shadow: none">
                            <div class="d-flex justify-between items-center">
                                <h5 class="card-header p-2 mt-1" style="padding-left: 0px">{{ __('Deposit details') }}
                                </h5>
                                <div class="btn btn-icon btn-sm btn-active-icon-primary waves-effect waves-light"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ti ti-x"></i>
                                </div>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <div class="table-responsive ">
                                    <table cellspacing="0" cellpadding="2" class="form deposit_confirm relative">
                                        <tbody>
                                                <tr>
                                                    <th>{{ __('Name plan') }}:</th>
                                                    <td id="planName"></td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Profit') }}:</th>
                                                    <td id="profit"></td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Deposit amount') }}:</th>
                                                    <td id="depositAmount"></td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Amount received') }}:</th>
                                                    <td id="amountReceived">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Sender') }}:</th>
                                                    <td id="sender"></td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Number of days sent') }}:</th>
                                                    <td id="numberDay"></td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Sent date') }}:</th>
                                                    <td id="sentDate"> </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Sending method') }}:</th>
                                                    <td id="sendingMethod">
                                                    </td>
                                                </tr>
                                                    <tr>
                                                        <th>{{ __('Network type') }} :</th>
                                                        <td id="network"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Coin Price') }}:</th>
                                                        <td id="coinPrice">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Wallet Address') }}:</th>
                                                        <td id="walletAddress">
                                                        </td>
                                                    </tr>
                                                <tr>
                                                    <th>{{ __('Status') }}:</th>
                                                    <td id="status">
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal"
                            aria-label="Close">{{ __('Cancel') }}</button>
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
