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
            <!--begin::Modal header-->
            <!--end::Modal header-->
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
                                                    <th>{{ __('Name plan') }}:</th>
                                                    <td>{{ $detail->plan_name ?? 'Deposit' }}</td>
                                                    @if ($this->generateQrCode() && $detail->wallet_address)
                                                        <td rowspan="6"
                                                            style="width: 150px !important; position: relative;">
                                                            {!! $this->generateQrCode() !!}
                                                            <span
                                                                style="position: absolute;  right: 80px; bottom: 0px ">{{ $detail->network_name }}</span>
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Profit') }}:</th>
                                                    <td>{{ formatNumber1($detail->profit) }}%
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Deposit amount') }}:</th>
                                                    <td>{{ formatNumber1($detail->amount) }}
                                                        {{ $detail->name_coin }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Amount received') }}:</th>
                                                    <td>
                                                        {{ formatNumber1($detail->total_amount) }}
                                                        {{ $detail->name_coin }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Sender') }}:</th>
                                                    <td>{{ $detail->investor_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Number of days sent') }}:</th>
                                                    <td>{{ $detail->number_days }} days</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Sent date') }}:</th>
                                                    <td>{{ $detail->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Sending method') }}:</th>
                                                    <td class=" {{ $detail->type_payment == 0 ? 'text-danger' : ($detail->type_payment == 1 ? 'text-primary' : 'text-warning') }}">
                                                        {{ $detail->type_payment == 0 ? 'Processor' : ($detail->type_payment == 1 ? 'Account Balance' : 'Deposit') }}
                                                    </td>
                                                </tr>
                                                @if ($detail->current_coin_price > 0)
                                                    <tr>
                                                        <th>{{ __('Network type') }} :</th>
                                                        <td>{{ $detail->network_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Coin Price') }}:</th>
                                                        <td>{{ formatNumber1($detail->current_coin_price) }}
                                                            {{ $detail->name_coin }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Total transfer amount') }}:
                                                        </th>
                                                        <td>{{ formatNumber1($detail->total_coin_price) }}
                                                            {{ $detail->name_coin }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <th>{{ __('Status') }}:</th>
                                                    <td
                                                        class="{{ $detail->status == 0 ? 'text-primary' : ($detail->status == 1 ? 'text-warning' : ($detail->status == 2 ? 'text-success' : 'text-danger')) }}">
                                                        {{ $detail->status == 0 ? 'Pending' : ($detail->status == 1 ? 'Running' : ($detail->status == 2 ? 'Success' : 'Cancel')) }}
                                                    </td>
                                                </tr>
                                            @endif
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
