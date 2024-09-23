@php
    function formatNumber1($number, $decimals = 6)
    {
        $formattedNumber = number_format($number, $decimals);
        return rtrim(rtrim($formattedNumber, '0'), '.');
    }
@endphp
<div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px" style="max-width: 1000px;">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal body-->
            <div class="modal-body mb-3">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="#" wire:submit.prevent="submit"
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
                                            @if (isset($detail))
                                                <tr>
                                                    <th>{{ __('Withdrawer') }}:</th>
                                                    <td>{{ $detail->fullname }}</td>
                                                    @if ($this->generateQrCode())
                                                        <td rowspan="6"
                                                            style="width: 150px !important; position: relative;">
                                                            {!! $this->generateQrCode() !!}
                                                            <span
                                                                style="position: absolute;  right: 80px; bottom: 0px ">{{ $detail->wallet_name }}</span>
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Coin Name') }}:</th>
                                                    <td>{{ $detail->coin_name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Network type') }}:</th>
                                                    <td>{{ $detail->wallet_name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Amount') }}:</th>
                                                    <td>{{ formatNumber1($detail->amount) }}  {{ $detail->coin_name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Total Amount') }}:</th>
                                                    <td>{{ formatNumber1($detail->total_amount) }}
                                                        {{ $detail->coin_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Withdrawal date') }}:</th>
                                                    <td>{{ $detail->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Wallet address') }} :</th>
                                                    <td>{{ $detail->wallet_address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Status') }}:</th>
                                                    <td
                                                        class="{{ $detail->status == 0 ? 'text-primary' : ($detail->status == 1 ? 'text-success' : ($detail->status == 2 ? 'text-danger' : 'text-danger')) }}">
                                                        {{ $detail->status == 0 ? 'Pending' : ($detail->status == 1 ? 'Success' : ($detail->status == 2 ? 'Cancel' : 'Cancel')) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
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
