
 <div class="modal fade" id="kt_modal_deposit" tabindex="-1" aria-hidden="true" wire:ignore.self>
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-scrollable mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_add_user_header">
                 <!--begin::Modal title-->
                 <div class="card-header d-flex flex-wrap">
                     <h4 class="mb-0 text-white">Enter Amount - Please select the cryptocurrency you want to deposit
                     </h4>
                     <div class="d-flex flex-wrap check_box_wrap">
                         @if (isset($coins))
                             @foreach ($coins as $coin)
                                 <div class="check_box check_box2 p-1" wire:click="checkbox({{ $coin->id }})"
                                     style="flex-grow: 1;flex-basis: 200">
                                     <label class="radio_btn">
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
                         style="color: #fff;border: 4px double #fff;position: absolute;top: 22px;right: 21px;"><svg
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                             <path fill="#fff"
                                 d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                         </svg></button>
                 </div>
             </div>
             <!--end::Modal header-->
             <!--begin::Modal body-->
             <div class="modal-body">
                 <div class="items-center m-auto qr-image p-2 bg-white"
                     style="display: flex; justify-content: center; align-items: center">
                     @if ($this->generateQrCodeBSC())
                         <div class="align-items-center">
                             {!! $this->generateQrCodeBSC() !!}
                         </div>
                     @endif

                 </div>
                 @if (isset($wallet_address))
                     <h3 class="text-center mt-2">Please send to <span class="text-warning"
                             id="textToCopy">{{ $wallet_address }}
                         </span>
                         <button type="button" class="btn btn-secondary ml-2" onclick="copy()" data-bs-toggle="tooltip"
                             data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                             data-bs-title="This top tooltip is themed via CSS variables.">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                 <path
                                     d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                 <path
                                     d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                 <path d="M9 12l.01 0" />
                                 <path d="M13 12l2 0" />
                                 <path d="M9 16l.01 0" />
                                 <path d="M13 16l2 0" />
                             </svg>
                         </button>
                         <br>
                         Order status: Waiting for payment
                     </h3>
                 @endif

                 @if (session('error'))
                     <div class="error">{{ session('error') }}</div>
                 @endif
                 @if ($errors->any())
                     <div class="error">{{ $errors->first() }}</div>
                 @endif
                 <form action="#" wire:submit.prevent="submit">
                     <div class="tab-content wd_box" id="pills-tabContent">
                         <div class="form1" style="background: linear-gradient(179deg, #312a26 -13%, #2c5168 91%);">
                             @if (isset($networks))
                                 <div class="form_box text-center">
                                     <span class=" text-white" style="font-weight: 400">Select Network</span>
                                     <select wire:model.live="network_id" class="mt-1"
                                         style="color: #000;width: 100%;font-weight: 400">
                                         <option value="">Select network</option>
                                         @foreach ($networks as $network)
                                             <option value="{{ $network->id }}">{{ $network->network_name }}</option>
                                         @endforeach
                                     </select>
                                     <h3 class="text-center mt-2" style="font-weight: 400">Enter Deposit Amount
                                     </h3>
                                     <h4>
                                         <i class="ri-money-dollar-circle-line"></i> <input type="number"
                                             name="amount" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                             wire:model.live="amount" step="any" size="15" class="inpts"
                                             id="inv_amount">
                                     </h4>
                                 </div>
                                 <div class="form_but">
                                     <button type="submit" data-kt-users-modal-action="submit" class="sbmt">Spend<div
                                             class="indicator-progress" wire:loading wire:target="submit">
                                             <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                         </div></button>
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
 @push('scripts')
     <script>
         function copy() {
             const text = document.getElementById('textToCopy').innerText;
             navigator.clipboard.writeText(text);
             alert('Text copied');
         }
     </script>
 @endpush
