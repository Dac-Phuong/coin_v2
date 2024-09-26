<div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px" style="max-width: 1000px;">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal body-->
            <div class="modal-body mb-3">
                <!--begin::Form-->
                <form id="kt_modal_show_withdraw" class="form" action="#"
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
                                                    <th>{{ __('Withdrawer') }}:</th>
                                                    <td id="fullname"></td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Coin Name') }}:</th>
                                                    <td id="coin_name">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Network type') }}:</th>
                                                    <td id="wallet_name">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Amount') }}:</th>
                                                    <td id="amount">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Total Amount') }}:</th>
                                                    <td id="total_amount">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Withdrawal date') }}:</th>
                                                    <td id="created_at">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Wallet address') }} :</th>
                                                    <td id="wallet_address">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Status') }}:</th>
                                                    <td id="status">
                                                    </td>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close">{{ __('Cancel') }}</button>
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
