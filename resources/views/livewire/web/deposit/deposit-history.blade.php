 @php
     function formatNumber1($number, $decimals)
     {
         $formattedNumber = number_format($number, $decimals);
         return rtrim(rtrim($formattedNumber, '0'), '.');
     }
 @endphp
 <div class="modal fade" id="kt_modal_show" tabindex="-1" aria-hidden="true" wire:ignore.self>
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_add_user_header">
                 <!--begin::Modal title-->
                 <div class="card-header mt-2 d-flex justify-content-between align-items-center">
                     <h4 class="mb-0 " style="color:#ffb821">Detail deposit</h4>
                 </div>
                 <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                         style="color: #fff;border: 4px double #fff;position: absolute;right: 25px;top: 30px;"><svg
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                             <path fill="#fff"
                                 d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                         </svg></button>
                 </div>
             </div>
             <!--end::Modal header-->
             <!--begin::Modal body-->
             <div class="modal-body mb-3">
                 <div class="mb-4">
                     <div class="card-body">
                         <div class="mb-3">
                             <div class="tab-pane fade active show" id="pills-touch" role="tabpanel"
                                 aria-labelledby="pills-touch-tab">
                                 <div class="checkmark_bg">
                                     @if (isset($deposit))
                                         <div class="tab-content wd_box" id="pills-tabContent">
                                             @if (isset($deposit) && $deposit->type_payment == 0)
                                                 <div class="tab-pane fade show active" id="pills-touch" role="tabpanel"
                                                     aria-labelledby="pills-touch-tab">
                                                     <div class="d-flex flex-wrap table-deposit-confirm relative">
                                                         <div class="text-center p-0 deposit-modal-col"
                                                             style="background: linear-gradient(45deg, #f77425, #cb3b7e);">
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Plan:</h2>
                                                                 <h2 class="plan-title1">{{ $deposit->plan_name ?? "Deposit" }}
                                                                 </h2>
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Deposit:</h2>
                                                                 <h2 class="plan-title1">
                                                                     {{ isset($deposit) ? formatNumber1($deposit->amount , $deposit->coin_decimal) : '' }}
                                                                     {{ $deposit->name_coin }}
                                                                 </h2>
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Days Sent:</h2>
                                                                 <h2 class="plan-title1">{{ $deposit->number_days ?? 0 }}</h2>
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Amount received:</h2>
                                                                 <h2 class="plan-title1">
                                                                     {{ isset($deposit) ? formatNumber1($deposit->total_amount, $deposit->coin_decimal) : 0 }}
                                                                     {{ $deposit->name_coin }}
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Price</h2>
                                                                 <h2 class="plan-title1">
                                                                     1 {{ $deposit->name_coin }} =
                                                                     ${{ isset($deposit) ? formatNumber1($deposit->current_coin_price, $deposit->coin_decimal) : 0 }}

                                                                 </h2>
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Network Fee</h2>
                                                                 <h2 class="plan-title1">
                                                                     {{ isset($deposit) ? formatNumber1($deposit->network_fee, $deposit->coin_decimal) : 0 }}
                                                                 </h2>
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Network type:</h2>
                                                                 <h2 class="plan-title1">
                                                                     {{ isset($deposit) ? $deposit->network_name : '' }}
                                                                 </h2>
                                                             </div>
                                                         </div>
                                                         @if (isset($wallet) && $this->generateQrCodeBSC())
                                                             <div class="items-center qr-image p-2 bg-white"
                                                                 style="display: flex; justify-content: center; align-items: center">
                                                                 <div class="align-items-center">
                                                                     {!! $this->generateQrCodeBSC() !!}
                                                                 </div>
                                                             </div>
                                                             @if ($deposit->status == 0 || $deposit->status == 3)
                                                                 <div class="text-center w-100 mt-1">
                                                                     <div class="coin_form btc_form btc6 "
                                                                         id="btc_form">
                                                                         <span style="border-bottom: 2px solid">Please
                                                                             send
                                                                             <b class="text-bg-warning">{{ number_format($deposit->total_amount, $deposit->coin_decimal) }}
                                                                                 {{ $deposit->name_coin }}
                                                                             </b> to </span><span
                                                                             class="text-bg-warning text-warning"
                                                                             style="overflow-wrap: break-word;">{{ $wallet->wallet_address }}</span>
                                                                     </div>
                                                                     <div id="placeforstatus ml-2">
                                                                         <div class="payment_status"><b>Order
                                                                                 status:</b>
                                                                             <span class="status_text">Waiting for
                                                                                 payment</span>
                                                                         </div>
                                                                         <div class="payment_status text-warning">
                                                                            <span class="status_text">If you do not pay, the system will automatically cancel after 60 minutes
                                                                             </span>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             @endif

                                                         @endif
                                                     </div>
                                                 </div>
                                             @else
                                                 <div class="tab-pane fade show active" id="pills-touch" role="tabpanel"
                                                     aria-labelledby="pills-touch-tab">
                                                     <div class="d-flex flex-wrap table-deposit-confirm relative">
                                                         <div class="text-center p-0 w-100"
                                                             style="background: linear-gradient(45deg, #f77425, #cb3b7e);">
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Plan:</h2>
                                                                 <h2 class="plan-title1">{{ $deposit->plan_name ?? "Deposit" }}
                                                                 </h2>
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Deposit:</h2>
                                                                 <h2 class="plan-title1">
                                                                     {{ isset($deposit) ? formatNumber1($deposit->amount, $deposit->coin_decimal) : '' }}
                                                                     {{ $deposit->name_coin }}
                                                                 </h2>
                                                             </div>
                                                             @if($deposit->type_payment !== 3)
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Days Sent:</h2>
                                                                 <h2 class="plan-title1">{{ $deposit->number_days ?? 0 }}</h2>
                                                             </div>
                                                             @endif
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Amount received:</h2>
                                                                 <h2 class="plan-title1">
                                                                     {{ isset($deposit) ? formatNumber1($deposit->total_amount, $deposit->coin_decimal) : 0 }}
                                                                     {{ $deposit->name_coin }}
                                                             </div>
                                                             <div class="d-flex items-center text-center w-100">
                                                                 <h2 class="plan-title">Price</h2>
                                                                 <h2 class="plan-title1">
                                                                     1 {{ $deposit->name_coin }} = ${{ isset($deposit) ? formatNumber1($deposit->current_coin_price, $deposit->coin_decimal) : 0 }}
                                                                 </h2>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             @endif
                                         </div>
                                     @endif
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="text-center pt-15">
                     <div class="text_but p-0 d-flex">
                         <div class="but p-2 w-25 m-auto font-weight-bold " data-bs-dismiss="modal"
                             aria-label="Close" style=" cursor: pointer;color:#cb3a7f">Cancel
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
