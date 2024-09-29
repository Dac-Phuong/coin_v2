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
                 <div class="card-header d-flex flex-wrap">
                     <h4 class="mb-0 text-white">Deposit</h4>
                     <div class="d-flex flex-wrap check_box_wrap">
                         @if (isset($coin))
                             <div class="check_box check_box2  p-1">
                                 <label class="radio_btn">
                                     <span class="checkmark1" style="background: url(../images/trans_bg.png);">
                                         <p class=" font-weight-bold text-white"><img src="{{ $coin->coin_image }}"
                                                 class="pay">
                                             {{ $coin->coin_name }}</p>
                                     </span>
                                 </label>
                             </div>
                         @endif
                     </div>
                 </div>
                 <div class="btn btn-icon btn-sm btn-active-icon-primary mt-3" data-bs-dismiss="modal"
                     aria-label="Close">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                         style="color: #fff;border: 4px double #fff;position: absolute;right: 25px;top: 30px;"><svg
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                             <path fill="#fff"
                                 d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                         </svg></button>
                 </div>
                 <!--end::Modal title-->
             </div>
             <!--end::Modal header-->
             <!--begin::Modal body-->
             <div class="modal-body">
                 <div class="nav nav-pills check_tab" id="pills-tab" role="tablist">
                     <button class="nav-link {{ $currentTab == 'tab1' ? 'active' : '' }}" id="pills-touch-tab" type="button" wire:click="switchTab('tab1')">Spend Processor</button>
                     <button class="nav-link {{ $currentTab == 'tab2' ? 'active' : '' }}" id="pills-touch1-tab" type="button" wire:click="switchTab('tab2')"> Spend Account Balance</button>
                 </div>
                 <form action="#" wire:submit.prevent="submit">
                     <div class="tab-content wd_box" id="pills-tabContent">
                         @if ($currentTab === 'tab1')
                             <div class="tab-pane fade active show" id="pills-touch" role="tabpanel"
                                 aria-labelledby="pills-touch-tab">
                                 <div class="checkmark_bg">
                                     <div class="tab-content wd_box" id="pills-tabContent">
                                         <div class="tab-pane fade show active" id="pills-touch" role="tabpanel"
                                             aria-labelledby="pills-touch-tab">
                                             <div class="d-flex flex-wrap table-deposit-confirm relative">
                                                 <div class="text-center p-0 deposit-modal-col"
                                                     style="background: linear-gradient(45deg, #f77425, #cb3b7e);">
                                                     <div class="d-flex items-center text-center w-100">
                                                         <h2 class="plan-title">Plan:</h2>
                                                         <h2 class="plan-title1">{{ $plan->name ?? 0 }}</h2>
                                                     </div>
                                                     <div class="d-flex items-center text-center w-100">
                                                         <h2 class="plan-title">Deposit:</h2>
                                                         <h2 class="plan-title1">
                                                             {{ isset($plan) ? formatNumber1($plan->min_deposit, $coin_decimal) : '' }}
                                                             {{ $coin_name }}</h2>
                                                     </div>
                                                     <div class="d-flex items-center text-center w-100">
                                                         <h2 class="plan-title">Profit:</h2>
                                                         <h2 class="plan-title1">
                                                             {{ isset($profit) ? $profit : 0 }}%</h2>
                                                     </div>
                                                     <div class="d-flex items-center text-center w-100">
                                                         <h2 class="plan-title">Days Sent:</h2>
                                                         <h2 class="plan-title1">{{ $number_days ?? 1 }}</h2>
                                                     </div>
                                                     <div class="d-flex items-center text-center w-100">
                                                         <h2 class="plan-title">Amount received:</h2>
                                                         <h2 class="plan-title1">
                                                             {{ isset($plan) ? formatNumber1($total_amount, $coin_decimal) : 0 }}
                                                             {{ $coin_name }}
                                                     </div>
                                                     <div class="d-flex items-center text-center w-100">
                                                         <h2 class="plan-title">Price</h2>
                                                         <h2 class="plan-title1">
                                                             1 {{ $coin_name }} =
                                                             ${{ isset($coin_price) ? formatNumber1($coin_price, $coin_decimal) : 0 }}
                                                         </h2>
                                                     </div>
                                                     <div class="d-flex items-center text-center w-100">
                                                         <h2 class="plan-title">Network type:</h2>
                                                         <select wire:model.live="networkId" class="w-50"
                                                             style="color: black">
                                                             @foreach ($network as $item)
                                                                 <option value="{{ $item->id }}">
                                                                     {{ $item->network_name }}
                                                                 </option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="items-center qr-image p-2 bg-white"
                                                     style="display: flex; justify-content: center; align-items: center">
                                                     @if ($this->generateQrCodeBSC())
                                                         <div class="align-items-center">
                                                             {!! $this->generateQrCodeBSC() !!}
                                                         </div>
                                                     @endif
                                                 </div>
                                                 @if ($isOpen)
                                                     @if (!isset($wallets) || empty($wallet_address))
                                                         <div class="payment_status text-center m-auto">The current
                                                             wallet has been used up, please wait a few minutes</div>
                                                     @else
                                                         <div class="text-center w-100 mt-1">
                                                             <div class="coin_form btc_form btc6 " id="btc_form">
                                                                 <span style="border-bottom: 2px solid">Please send <b
                                                                         class="text-bg-warning">{{ formatNumber1($total_coin_price, $coin_decimal) }}
                                                                         {{ $coin_name }}
                                                                     </b> to </span><span
                                                                     class="text-bg-warning text-warning"
                                                                     style="overflow-wrap: break-word;">
                                                                        <span id="walletAddress">{{ $wallet_address }}</span>
                                                                        <button type="button" id="copyButton" class="ml-2 btn btn-secondary">
                                                                            <svg style="width: 16px; height: 16px;" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                                <path d="M208 0L332.1 0c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9L448 336c0 26.5-21.5 48-48 48l-192 0c-26.5 0-48-21.5-48-48l0-288c0-26.5 21.5-48 48-48zM48 128l80 0 0 64-64 0 0 256 192 0 0-32 64 0 0 48c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 176c0-26.5 21.5-48 48-48z"/>
                                                                            </svg>
                                                                        </button>
                                                                     </span>
                                                             </div>
                                                             <div id="placeforstatus ml-2">
                                                                 <div class="payment_status"><b>Order status:</b> <span
                                                                         class="status_text">Waiting for payment</span>
                                                                 </div>
                                                                 <div class="payment_status text-warning"><span
                                                                         class="status_text">If you do not pay, the
                                                                         system will automatically cancel after 60
                                                                         minutes
                                                                     </span>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     @endif
                                                 @endif
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         @elseif($currentTab === 'tab2')
                             <div class="">
                                 <div class="text-center p-0 deposit-modal-col"
                                     style="background: linear-gradient(45deg, #f77425, #cb3b7e); width: 100%;">
                                     <div class="d-flex items-center text-center w-100">
                                         <h2 class="plan-title">Plan:</h2>
                                         <h2 class="plan-title1">{{ $plan->name ?? 0 }}</h2>
                                     </div>
                                     <div class="d-flex items-center text-center w-100">
                                         <h2 class="plan-title">Deposit:</h2>
                                         <h2 class="plan-title1">
                                             {{ isset($plan->min_deposit) ? formatNumber1($plan->min_deposit, $coin_decimal) : '' }}
                                             {{ $coin_name }}</h2>
                                         </h2>
                                     </div>
                                     <div class="d-flex items-center text-center w-100">
                                         <h2 class="plan-title">Profit:</h2>
                                         <h2 class="plan-title1">
                                             {{ isset($profit) ? $profit : 0 }}%</h2>
                                     </div>
                                     <div class="d-flex items-center text-center w-100">
                                         <h2 class="plan-title">Days Sent:</h2>
                                         <h2 class="plan-title1">{{ $number_days ?? 1 }}</h2>
                                     </div>
                                     <div class="d-flex items-center text-center w-100">
                                         <h2 class="plan-title">Price</h2>
                                         <h2 class="plan-title1">
                                             1 {{ $coin_name }} =
                                             ${{ isset($coin_price) ? formatNumber1($coin_price, $coin_decimal) : 0 }}
                                         </h2>
                                     </div>
                                     <div class="d-flex items-center text-center w-100">
                                         <h2 class="plan-title">Amount received:</h2>
                                         <h2 class="plan-title1">
                                            {{ formatNumber1($total_amount, $coin_decimal) }} {{ $coin_name }}
                                     </div>
                                 </div>

                             </div>
                         @endif
                         @if (session('error'))
                             <div class="error">{{ session('error') }}</div>
                         @endif
                         @if (isset($plan) && $plan->package_type == 1)
                             @if ((isset($wallets) && $wallet_address) || $currentTab == 'tab2')
                                 <div class="form1">
                                     <div class="form_box">
                                         <h3> Choose the number of investment days</h3>
                                         <h4>
                                             <i class="ri-money-dollar-circle-line"></i>
                                             <select type="text" name="amount" wire:model.live="number_days_id"
                                                 class="inpts" id="inv_amount">
                                                 @foreach ($plan_number_days as $number_days)
                                                     <option value="{{ $number_days->id }}">
                                                         {{ $number_days->number_days }}
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </h4>
                                     </div>
                                     <div class="form_but">
                                         <button type="submit" data-kt-users-modal-action="submit"
                                             class="sbmt">Spend
                                             <div class="indicator-progress" wire:loading wire:target="submit">
                                                 <span
                                                     class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                             </div>
                                         </button>
                                     </div>
                                 </div>
                             @endif
                         @else
                             <div class="text-center text-white">This plan has ended.</div>
                         @endif
                     </div>
                 </form>
             </div>
             <!--end::Modal body-->
         </div>
         <!--end::Modal content-->
     </div>
     <!--end::Modal dialog-->
 </div>

<script>
    $(document).ready(function() {
        $(document).on('click', '#copyButton', function() {
            var walletAddress = $('#walletAddress').text();
            navigator.clipboard.writeText(walletAddress).then(function() {
                alert('Wallet address copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        });
    });
</script>
