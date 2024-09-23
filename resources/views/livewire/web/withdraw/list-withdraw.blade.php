 @php
     function formatNumber($number, $decimals)
     {
         $formattedNumber = number_format($number, $decimals);
         return rtrim(rtrim($formattedNumber, '0'), '.');
     }
 @endphp
 <div class="wrapper">
     @include('web.layouts.navbar')
     <section class="home-section">
         <style>
             tr th {
                 text-align: center
             }

             tr {
                 height: 55px !important;
             }

             tr td {
                 text-align: center;
                 color: #000 !important;
             }
         </style>
         <div class="headerall_top" wire:poll.10s>
             <div class="row">
                 <div class="col-lg-3">
                     <a href="{{ url('/') }}" wire:navigate>
                         <h2 class="pl-2 pt-3 items-center"
                             style="font-size: 26px;text-transform: uppercase;font-weight: 700">
                             Stakingcoins</h2>
                     </a>
                 </div>
                 <div class="col-lg-5">
                     <div class="home-content">
                         <div id="toggleButton">
                             <i class="ri-menu-line"></i>
                             <h1 class="head">Withdraw </h1> <br>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-4">
                     <ul class="home-content1">
                         <li>
                             <h3> <i class="ri-map-pin-user-line"></i> user :<span> {{ $investor->fullname }}</span>
                             </h3>
                             <h3> <i class="ri-mail-open-line"></i> Email: <span> {{ $investor->email }}</span> </h3>
                         </li>
                     </ul>
                 </div>
                 <div class="col-lg-8">
                     <div class="refer_copy">
                         <img src="images/acc_img3.png" class="img-fluid acc_img2">
                         <h3>
                             Referal link
                             <input type="text" wire:model.refer="ref" readonly id="myInput"
                                 onclick="this.select();">
                             <button onclick="copyToClipboard()"><i class="ri-link-unlink-m"></i></button>
                         </h3>
                     </div>
                 </div>
                 <div class="col-lg-4">
                     <div class="text_but d-flex flex-wrap justify-content-end ">
                         <div class="but cursor-pointer" data-bs-toggle="modal" data-bs-target="#kt_modal_deposit">Deposit</div>
                         <a href="{{ url('/deposit') }}" wire:navigate class="but2"> Investment packages </a>
                         <a href="{{ url('/withdraw') }}" wire:navigate class="but"> Withdraw</a>
                         <div wire:click="logout" class="but cursor-pointer"> logout</div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="admin1_bg">
             <div class="container-fluid">
                 <div class="depo_bg">
                     <h1 class="head3"> 01.Balance Details</h1>
                     <div class="form_block1">
                         <img src="images/acc_img4.png" class="acc_img4 img-fluid">
                         <h3> Account Balance</h3>
                         <h4>$<b>{{ formatNumber($investor->balance, 6) }} </b></h4><b>
                     </div>

                     <!---->
                     <div class="col-lg-12 col-md-12 ">
                         <h1 class="head3"> 02.Coin Details</h1>
                         <div style="max-width: 1600px ; margin: auto">
                             <div class="row">
                                 <div class="table-responsive ">
                                     <table style="background: #fff !important;border:1px solid #ccc !important">
                                         <thead>
                                             <tr>
                                                 <th scope="col">STT</th>
                                                 <th scope="col">Coin</th>
                                                 <th scope="col">Available balance</th>
                                                 <th scope="col">Equivalent</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @if (count($investor_coins) > 0)
                                                 @foreach ($investor_coins as $key => $item)
                                                     <tr style="height: 50px !important;">
                                                         <td scope="row" style="background: none;color: #000">
                                                             {{ ++$key }}</td>

                                                         <td scope="row" style="background: none;color: #000">
                                                             <div class="d-flex items-center" style="width:15%;margin: 0 auto">
                                                                 <img width="30px" height="30px"
                                                                     src="{{ $item->coin_image }}" alt="Uploaded Image"
                                                                     style="margin-right: 5px;">{{ $item->coin_name }}
                                                             </div>
                                                         </td>
                                                         <td style="background: none;color: #000">
                                                             {{ formatNumber($item->available_balance, $item->coin_decimal) }}
                                                             {{ $item->coin_name }}
                                                         </td>
                                                         <td style="background: none;color: #000">
                                                             ${{ formatNumber($item->available_balance * $item->coin_price, $item->coin_decimal) }}
                                                         </td>
                                                     </tr>
                                                 @endforeach
                                             @else
                                                 <tr>
                                                     <td colspan="12" style="text-align:center; color:red">
                                                         No data
                                                     </td>
                                                 </tr>
                                             @endif
                                         </tbody>
                                     </table>
                                     <div class="mt-3">
                                         {{ $investor_coins->links() }}
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!---->
                         <div class="d-flex align-items-center">
                             <h1 class="head3"> 03.List Withdraw </h1>
                             <div data-id="" data-bs-toggle="modal" data-bs-target="#kt_modal_update"
                                 class="text_but p-0"
                                 style="margin-left: 20px;cursor: pointer; width: 120px; margin-top: 9px;">
                                 <div class="but p-2  text-white font-weight-bold btn-withdraw">
                                     Withdraw
                                 </div>
                             </div>
                         </div>

                         <div style="max-width: 1600px ; margin: auto">
                             <div class="row">
                                 <div class="table-responsive mt-4">
                                     <table style="background: #fff !important;border:1px solid #ccc !important">
                                         <thead>
                                             <tr>
                                                 <th scope="col">STT</th>
                                                 <th scope="col">Amount withdraw</th>
                                                 <th scope="col">Total amount</th>
                                                 <th scope="col">Wallet type</th>
                                                 <th scope="col">Wallet address</th>
                                                 <th scope="col">Withdrawal date</th>
                                                 <th scope="col">Status</th>
                                                 <th scope="col">Action</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @if (count($list_withdraw) > 0)
                                                 @foreach ($list_withdraw as $key => $withdraw)
                                                     <tr>
                                                         <td scope="row" style="background: none;color: #fff">
                                                             {{ ++$key }}</td>
                                                         <td style="background: none;color: #fff">
                                                             {{ formatNumber($withdraw->amount, $withdraw->coin_decimal) }}
                                                             {{ $withdraw->coin_name }}
                                                         </td>
                                                         <td style="background: none;color: #fff">
                                                             {{ formatNumber($withdraw->total_amount, $withdraw->coin_decimal) }}
                                                             {{ $withdraw->coin_name }}
                                                         </td>
                                                         <td style="background: none;color: #fff">
                                                             {{ $withdraw->wallet_name }}
                                                         </td>
                                                         <td style="background: none;color: #fff">
                                                             {{ $withdraw->wallet_address }}
                                                         </td>
                                                         <td>{{ $withdraw->created_at }}</td>
                                                         <td
                                                             class="{{ $withdraw->status == 0 ? 'text-primary' : ($withdraw->status == 1 ? 'text-success' : ($withdraw->status == 2 ? 'text-danger' : 'text-danger')) }}">
                                                             {{ $withdraw->status == 0 ? 'Pending' : ($withdraw->status == 1 ? 'Success' : ($withdraw->status == 2 ? 'Cancel' : 'Cancel')) }}
                                                         <td style="width: 170px">
                                                             @if ($withdraw->status == 0)
                                                                 <div class="text_but p-0"
                                                                     wire:click="cancel({{ $withdraw->id }})"
                                                                     wire:loading.class="disabled"
                                                                     style="margin-left: 20px;cursor: pointer;">
                                                                     <div class="but p-2 text-white font-weight-bold">
                                                                         <span
                                                                             wire:target="cancel({{ $withdraw->id }})">
                                                                             Cancel
                                                                         </span>
                                                                     </div>
                                                                 </div>
                                                             @endif
                                                         </td>
                                                     </tr>
                                                 @endforeach
                                             @else
                                                 <tr>
                                                     <td colspan="12" style="text-align:center; color:white">
                                                         No data.
                                                     </td>
                                                 </tr>
                                             @endif
                                         </tbody>
                                     </table>
                                     <div class="mt-3">
                                         {{ $list_withdraw->links() }}
                                     </div>
                                 </div>
                                 <livewire:web.withdraw.modal-withdraw />
                                 <livewire:web.account.modal-deposit />
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
     </section>
 </div>
 @push('scripts')
     <script>
         $(document).ready(function() {
             $("#toggleButton").click(function() {
                 var $x = $("#mobile-show");
                 var $y = $(".ri-menu-line");
                 if ($x.hasClass("show")) {
                     $x.removeClass("show").addClass("hide");
                     setTimeout(function() {
                         $x.css("visibility", "hidden");
                         $y.css("position", "absolute");
                     }, 500);
                 } else {
                     $x.removeClass("hide").css("visibility", "visible");
                     $y.css("position", "fixed");
                     setTimeout(function() {
                         $x.addClass("show");
                     }, 10);
                 }
             });
         });
     </script>
 @endpush
