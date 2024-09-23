 @php
     function formatNumber($number, $decimals = 6)
     {
         $formattedNumber = number_format($number, $decimals);
         return rtrim(rtrim($formattedNumber, '0'), '.');
     }
 @endphp
 <div class="wrapper" wire:poll.15s>
     @include('web.layouts.navbar')
     <section class="home-section">
         <div class="headerall_top">
             <div class="row">
                 <div class="col-lg-3">
                     <a href="{{ url('/') }}" wire:navigate>
                         <h2 class="pl-2 pt-3 items-center"
                             style="font-size: 26px;text-transform: uppercase;font-weight: 700">
                             Stakingcoins</h2>
                     </a>
                 </div>
                 <div class="col-lg-5">
                     <div class="home-content head">
                         <div id="toggleButton">
                             <i class="ri-menu-line menu-mobile"></i>
                             <h1 class="head">account as </h1> <br>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-4">
                     <ul class="home-content1">
                         <li>
                             <h3> <i class="ri-map-pin-user-line"></i> user:<span> {{ $investor->fullname }}</span></h3>
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
                         <a href="{{ url('/deposit') }}" wire:navigate class="but2" >Investment Packages </a>
                         <a href="{{ url('/withdraw') }}" wire:navigate class="but"> Withdraw</a>
                         <div wire:click="logout" class="but cursor-pointer"> logout</div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="admin1_bg">
             <div class="container-fluid depo_bg">
                 <div class="row">
                     <div class="col-lg-8 col-md-12">
                         <h1 class="head3"> 01.User Details</h1>
                         <div class="user_acc">
                             <img src="images/user_img1.png" class="user_img1">
                             <h3> <i class="ri-star-fill"></i> Welcome</h3>
                             <h4><i class="ri-star-fill"></i> {{ $investor->fullname }}</h4>
                             <h5><i class="ri-star-fill"></i> Registration Date <span>
                                     {{ $investor->created_at }}</span></h5>
                             <h5><i class="ri-star-fill"></i> Last acces date <span> {{ $investor->updated_at }}</span>
                             </h5>
                         </div>
                     </div>
                     <div class="col-lg-4 col-md-12">
                         <h1 class="head3"> 02.Payment Details</h1>
                         <div class="payment_detail">
                             <marquee width="100%" direction="right" height="245px" onmouseout="this.start()"
                                 onmouseover="this.stop()">
                                 @if (isset($coins))
                                     @foreach ($coins as $coin)
                                         <p class="payment-item"> <img src="{{ $coin->coin_image }}" class="payment">
                                             {{ $coin->coin_name }} <span>
                                                 ${{ formatNumber($coin->coin_price) }}
                                             </span> </p>
                                     @endforeach
                                 @endif
                             </marquee>
                         </div>
                     </div>
                 </div>
                 <h1 class="head3"> 03.Menu Details</h1>
                 <ul class="but_detail">
                     <li>
                         <div class="text_but cursor-pointer" data-bs-toggle="modal" data-bs-target="#kt_modal_deposit">
                             <div class="but">Deposit </div>
                         </div>
                     </li>
                     <li>
                         <div class="text_but">
                             <a href="{{ url('deposit') }}" wire:navigate class="but" style="max-width: 205px !important">Investment packages</a>
                         </div>
                     </li>
                     <li>
                         <div class="text_but">
                             <a href="{{ url('withdraw') }}" wire:navigate class="but"> Withdraw </a>
                         </div>
                     </li>

                     <li>
                         <div class="text_but">
                             <div wire:click="logout" class="but" style="cursor: pointer"> logout </div>
                         </div>
                     </li>
                 </ul>
                 <h1 class="head3"> 04.Account Details</h1>
                 <ul class="user_detail">
                     <li>
                         <div class="form_block">
                             <img src="images/acc_img4.png" class="acc_img4 img-fluid">
                             <h3> Account Balance </h3>
                             <h4> ${{ formatNumber($investor->balance) }}</h4>
                         </div>
                     </li>
                     <li>
                         <div class="form_block">
                             <a href="{{ url('list-deposit') }}" wire:navigate>
                                 <img src="images/acc_img5.png" class="acc_img4 img-fluid">
                                 <h3>Last Deposit</h3>
                                 <h4> {{ isset($last_deposit) ? formatNumber($last_deposit->amount) : 0 }}
                                     {{ isset($last_deposit) ? $last_deposit->name_coin : '' }}</h4>
                             </a>
                         </div>
                     </li>
                     <li>
                         <div class="form_block">
                             <a href="{{ url('withdraw') }}" wire:navigate>
                                 <img src="images/acc_img6.png" class="acc_img4 img-fluid">
                                 <h3>Last Withdraw</h3>
                                 <h4> {{ isset($last_withdraw) ? formatNumber($last_withdraw->amount) : 0 }}
                                     {{ isset($last_withdraw) ? $last_withdraw->name_coin : '' }}</h4>
                                 </h4>
                             </a>
                         </div>
                     </li>
                     <li>
                         <a href="{{ url('list-deposit') }}" wire:navigate>
                             <div class="form_block">
                                 <img src="images/acc_img7.png" class="acc_img4 img-fluid">
                                 <h3> Earned Total </h3>
                                 <h4> ${{ formatNumber($investor->earned_toatl) }}</h4>
                             </div>
                         </a>
                     </li>
                 </ul>
                 <div class="col-lg-12 col-md-12 ">
                     <h1 class="head3"> 05.Coin Details</h1>
                     <div class="form_detail">
                         <div class="row ml-3">
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
                                                 <tr>
                                                     <td scope="row" style="background: none;color: #000">
                                                         {{ ++$key }}</td>
                                                     <td scope="row" style="background: none;color: #000">
                                                         <div class="d-flex items-center">
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
                 </div>
                 <div class="row depo_bg">
                     <livewire:web.account.modal-deposit />
                     <div class="col-lg-6 col-md-12">
                         <h1 class="head3"> 06.Deposit Details</h1>
                          <ul class="form_detail">
                             <li>
                                 <a href="{{ url('list-deposit') }}" wire:navigate>
                                     <div class="d-flex justify-content-between flex-wrap p-2 text-white"
                                         style="background: linear-gradient(45deg, #2c5168, #fbb123);align-items: baseline;">
                                         <h2>
                                             Last Active Investment packages
                                         </h2>
                                         <span class="text-white">
                                             {{ isset($active_by_package) ? formatNumber($active_by_package->amount) : 0 }}
                                             {{ isset($active_by_package) ? $active_by_package->name_coin : '' }}
                                             {{ isset($active_by_package) ? '-' : '' }}
                                             {{ isset($active_by_package) ? $active_by_package->created_at : '' }}
                                         </span>
                                     </div>
                                 </a>
                             </li>
                             <li class="mt-2">
                                 <a href="{{ url('list-deposit') }}" wire:navigate>
                                     <div class="d-flex justify-content-between flex-wrap p-2 text-white"
                                         style="background: linear-gradient(45deg, #2c5168, #fbb123);align-items: baseline;">
                                         <h2>
                                             Last Active Deposit
                                         </h2>
                                         <span class="text-white">
                                             {{ isset($active_deposit) ? formatNumber($active_deposit->amount) : 0 }}
                                             {{ isset($active_deposit) ? $active_deposit->name_coin : '' }}
                                             {{ isset($active_deposit) ? '-' : '' }}
                                             {{ isset($active_deposit) ? $active_deposit->created_at : '' }}
                                         </span>
                                     </div>
                                 </a>
                             </li>
                         </ul>
                     </div>
                     <div class="col-lg-6 col-md-12">
                         <h1 class="head3"> 07.Withdraw Details</h1>
                         <ul class="form_detail">
                             <li>
                                 <a href="{{ url('withdraw') }}" wire:navigate>
                                     <div class="d-flex justify-content-between flex-wrap p-2 text-white"
                                         style="background: linear-gradient(45deg, #2c5168, #fbb123);align-items: baseline;">
                                         <h2> Last Pending Withdraw </h2>
                                         <span class="text-white">
                                             {{ isset($pending_withdraw) ? formatNumber($pending_withdraw->amount) : 0 }}
                                             {{ isset($pending_withdraw) ? $pending_withdraw->coin_name : '' }}
                                             {{ isset($pending_withdraw) ? '-' : '' }}
                                             {{ isset($pending_withdraw) ? $pending_withdraw->created_at : '' }}
                                         </span>
                                     </div>
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </div>
                 
             </div>
     </section>
 </div>
 <script>
     $(document).ready(function() {
         $("#toggleButton").click(function() {
             var $x = $("#mobile-show");
             if ($x.hasClass("show")) {
                 $x.removeClass("show").addClass("hide");
                 setTimeout(function() {
                     $x.css("visibility", "hidden");
                 }, 500);
             } else {
                 $x.removeClass("hide").css("visibility", "visible");
                 setTimeout(function() {
                     $x.addClass("show");
                 }, 10);
             }
         });
     });
 </script>
