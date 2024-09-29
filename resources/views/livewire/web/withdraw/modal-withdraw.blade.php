 @php
     function formatNumber1($number, $decimals)
     {
         $formattedNumber = number_format($number, $decimals);
         return rtrim(rtrim($formattedNumber, '0'), '.');
     }
 @endphp
 <div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true" wire:ignore.self>
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-scrollable mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_add_user_header">
                 <!--begin::Modal title-->
                 <div class="card-header withdraw-coin d-flex flex-wrap">
                     <h4 class="mb-0 text-white">Select Coin
                     </h4>
                     <div class="row">
                         @if (isset($coins))
                             @foreach ($coins as $coin)
                                 <div class="check_box check_box2 col p-0 m-1" wire:click="checkbox({{ $coin->id }})">
                                     <label class="radio_btn" style="display: block">
                                         <input type="radio" name="type" value="process_18" data-fiat="USD"
                                             {{ $coin->id == $coin_id ? 'checked' : '' }} style="display:none">
                                         <span class="checkmark1">
                                             <p class=" font-weight-bold"><img src="{{ $coin->coin_image }}"
                                                     class="pay">
                                                 {{ $coin->coin_name }}</p>
                                         </span>
                                     </label>
                                 </div>
                             @endforeach
                         @endif
                     </div>
                 </div>
                 <!--end::Modal title-->
                 <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                         style="color: #fff;border: 4px double #fff;position: absolute;
    top: 23px;
    right: 23px;"><svg
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                             <path fill="#fff"
                                 d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                         </svg></button>
                 </div>
             </div>
             <!--end::Modal header-->
             <!--begin::Modal body-->
             <div class="modal-body">
                 @if (session('error'))
                     <div class="error">{{ session('error') }}</div>
                 @endif
                 @if (session('error1'))
                     <div class="error">{{ session('error1') }} <a wire:navigate href="{{url('edit-account')}}">(Click to update wallet)</a></div>
                 @endif
                 @if ($errors->any())
                     <div class="error">{{ $errors->first() }}</div>
                 @endif
                 <form action="#" wire:submit.prevent="submit">
                     <div class="tab-content wd_box" id="pills-tabContent">
                         <div class="form1" style="background: linear-gradient(179deg, #312a26 -13%, #2c5168 91%);">
                             @if (count($wallet_address) > 0 && isset($networks) && isset($wallet_address))
                                 <div class="form_box text-center">
                                     <span class="mb-2 " style="font-weight: 400">Select Wallet</span>
                                     <select wire:model.live="network_id"
                                         style="color: #000;width: 100%;font-weight: 400">
                                         <option value="">Select wallet</option>
                                         @foreach ($networks as $network)
                                             <option value="{{ $network->id }}">{{ $network->network_name }}</option>
                                         @endforeach
                                     </select>
                                     <h3 class="text-center mt-2" style="font-weight: 400"> Enter withdrawal Amount</h3>
                                     <h4 class="position-relative">
                                         <div class="withdraw-icon" wire:click="plusMax">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                 viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                 <path fill="#2C5168"
                                                     d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
                                             </svg></div>
                                         <input  type="text"
                                                
                                                name="amount"
                                             style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                             wire:model.live="amount" step="any" size="15" class="inpts"
                                             id="inv_amount">
                                     </h4>
                                     <h3 class="mt-2 p-0 text-center text-warning">Withdrawal fee:
                                         {{ isset($coin_fee) ? formatNumber1($coin_fee , $coin_decimal) : 0 }}
                                         {{ $coin_name }}</h3>
                                 </div>
                                 <div class="form_but">
                                     <button type="submit" data-kt-users-modal-action="submit" class="sbmt">Spend<div
                                             class="indicator-progress" wire:loading wire:target="submit">
                                             <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                         </div></button>
                                 </div>
                             @else
                                 <div class="text-center mt-3">Please add your wallet before withdrawing.</div>
                                 <div class="d-flex justify-content-between mt-3">
                                     <div class="form_but m-auto">
                                         <a href="{{ url('/edit-account') }}" wire:navigate type="submit"
                                             class="sbmt"> Update Wallet</a>
                                     </div>
                                 </div>
                             @endif
                         </div>
                     </div>
                 </form>

             </div>
             <!--end::Modal body-->
         </div>
         <!--end::Modal content-->
     </div>
     <!--end::Modal dialog-->
 </div>
