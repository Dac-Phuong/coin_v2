<div class="modal fade" id="kt_modal_show_detail" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px" style="max-width: 800px;">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body mb-3">
                <!--begin::Form-->
                <form id="kt_modal_show" class="form" action="#" wire:submit.prevent="submit"
                    enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <!--begin::Input group-->
                    <div class="mb-4">
                        <div class="card" style="box-shadow: none">
                            <div class="d-flex justify-between items-center">
                                <h5 class="card-header p-2 mt-1" style="padding-left: 0px">{{ __('Info Investor') }}
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
                                                <th>{{ __('Full name') }}:</th>
                                                <td id="fullname"></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Email') }}:</th>
                                                <td id="email"></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Acount balance') }}:</th>
                                                <td id="balance"></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Total deposit amount') }}:</th>
                                                <td id="total_deposit"></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Total Withdraw') }}:</th>
                                                <td id="total_widthdraw"></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Earned total') }}:</th>
                                                <td id="earned_toatl"></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Wallet address') }}:</th>
                                                <td>
                                                    <div class="btn-group" id="hover-dropdown-demo">
                                                        <button type="button"
                                                            class="btn btn-primary dropdown-toggle waves-effect waves-light"
                                                            data-bs-toggle="dropdown" data-trigger="hover"
                                                            aria-expanded="false">{{ __('View') }}</button>
                                                        <ul class="dropdown-menu" id="listWallet">

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Created Date') }}:</th>
                                                <td id="created_at"></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Status') }}:</th>
                                                <td>
                                                    <span id="status"></span>
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
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">{{ __('Cancel') }}</button>
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
