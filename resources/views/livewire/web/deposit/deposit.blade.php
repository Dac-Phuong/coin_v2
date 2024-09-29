 @php
     function formatNumber($number, $decimals)
     {
         $formattedNumber = number_format($number, $decimals);
         return rtrim(rtrim($formattedNumber, '0'), '.');
     }
 @endphp
 <div class="wrapper">
     @include('web.layouts.navbar')
     <section class="home-section mb-8">
         <div class="headerall_top" wire:poll.15s>
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
                             <h1 class="head">deposit </h1> <br>
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
                         <div class="but cursor-pointer" data-bs-toggle="modal" data-bs-target="#kt_modal_deposit">
                             Deposit</div>
                         <a href="{{ url('/deposit') }}" wire:navigate class="but2"> Investment Packages </a>
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
                         <h4>$<b>{{ formatNumber($investor->balance, 6) }} </b></h4>
                     </div>
                     <h1 class="head3"> 02.Coin Details</h1>
                     <div class="row ">
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
                     <h1 class="head3"> 03.Plan Fixed</h1>
                     <div style="max-width: 1600px ; margin: auto; margin-bottom:30px">
                         <div class="w-100">
                             <h4 class="text-center pb-4 pt-1 fs-5 fw-bold">
                                 Please select the cryptocurrency you want to deposit
                             </h4>
                             <div class="row">
                                @if (isset($coins))
                                 @foreach ($coins as $coin)
                                     <div class="col p-0 m-1" wire:click="checkbox({{ $coin->id }})">
                                         <div class="check_box check_box2">
                                             <label class="radio_btn {{ $coin->id == $coin_id ? 'active' : '' }}" style="display: block">
                                                 <input type="radio" name="type"
                                                     {{ $coin->id == $coin_id ? 'checked' : '' }} value="process_18"
                                                     data-fiat="USD" style="display:none;">
                                                 <span class="checkmark1">
                                                     <p class="font-weight-bold"><img src="{{ $coin->coin_image }}"
                                                             class="pay">
                                                         {{ $coin->coin_name }}</p>
                                                 </span>
                                             </label>
                                         </div>
                                         </div>
                                     @endforeach
                                 @endif
                             </div>
                         </div>
                         <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
                             @if (isset($plan_fixeds))
                                 @foreach ($plan_fixeds as $key => $plan_fixed)
                                     <div class="col relative">
                                         <div class="nina-col-hosting" data-id="{{ $plan_fixed->id }}"
                                             data-coin-id="{{ $plan_fixed->coin_id }}" data-bs-toggle="modal"
                                             data-bs-target="#kt_modal_update">
                                             <div class="nina-item-hosting">
                                                 <div
                                                     class="nina-header-hosting alex-nina-header-hosting{{ $key }}">
                                                     <div class="nina-title-hosting">
                                                         <h2>{{ $plan_fixed->name }}</h2>
                                                     </div>
                                                     <div class="nina-desc-hosting"></div>
                                                     <div
                                                         class="nina-price-hosting alex-nina-price-hosting{{ $key }}">
                                                         <div>
                                                             <div class="nina-text-price1">Package</div>
                                                             <div class="nina-text-price2" style="font-size:22px">
                                                                 {{ formatNumber($plan_fixed->min_deposit, $plan_fixed->coin_decimal) }}
                                                                 {{ $plan_fixed->coin_name }}
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div
                                                     class="nina-body-hosting nina-host-pho-thong{{ $key }}">
                                                     <ul>
                                                         @foreach ($plan_fixed->number_profit as $item)
                                                             @php
                                                                 $total =
                                                                     ($item->profit / 100) * $plan_fixed->min_deposit +
                                                                     $plan_fixed->min_deposit;
                                                             @endphp
                                                             <li class="w-100 flex-column ">
                                                                 <div class="w-100 d-flex justify-content-between">
                                                                     <div class="nina-info-hosting w-50"
                                                                         style="font-size:15px">
                                                                         {{ $item->number_days }}
                                                                         DAY = {{ $item->profit }}% APY</div>
                                                                     <div class="nina-info-parameter w-50 ml-1 text-black"
                                                                         style="font-size:15px">
                                                                         Profit:
                                                                         {{ formatNumber(($item->profit / 100) * $plan_fixed->min_deposit, $plan_fixed->coin_decimal) }}
                                                                         {{ $plan_fixed->coin_name }}
                                                                     </div>
                                                                 </div>
                                                                 <div class="nina-info-parameter w-100"
                                                                     style="text-align: left;" style="font-size:15px">
                                                                     Total:
                                                                     {{ isset($total) ? formatNumber($total, $plan_fixed->coin_decimal) : 0 }}
                                                                     {{ $plan_fixed->coin_name }}
                                                                 </div>
                                                             </li>
                                                         @endforeach
                                                     </ul>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach
                             @endif
                             <livewire:web.deposit.deposit-modal />
                             <livewire:web.account.modal-deposit />
                         </div>
                     </div>
                     {{-- <h1 class="head3"> 03.Plan Daily</h1>
                    <div style="max-width: 1600px ; margin: auto">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-5">
                            @if (isset($plan_daily))
                                @foreach ($plan_daily as $key => $plan)
                                    <div class="col relative">
                                        <div class="nina-col-hosting" data-id="{{ $plan->id }}"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update"
                                            wire:click="resetPage">
                                            <div class="nina-item-hosting">
                                                <div
                                                    class="nina-header-hosting alex-nina-header-hosting{{ $key }}">
                                                    <div class="nina-title-hosting">
                                                        <h2>{{ $plan->name }}</h2>
                                                    </div>
                                                    <div class="nina-desc-hosting"> {{ $plan->title }}</div>
                                                    <div
                                                        class="nina-price-hosting alex-nina-price-hosting{{ $key }}">
                                                        <div>
                                                            <div class="nina-text-price2">{{ $plan->discount }} %</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nina-body-hosting nina-host-pho-thong{{ $key }}">

                                                    <ul>
                                                        <li>
                                                            <div class="nina-info-hosting">Profit Percent</div>
                                                            <div class="nina-info-parameter">
                                                                {{ $plan->discount }}%
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="nina-info-hosting">Min Deposit</div>
                                                            <div class="nina-info-parameter">
                                                                ${{ $plan->min_deposit }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="nina-info-hosting">Max Deposit</div>
                                                            <div class="nina-info-parameter">
                                                                ${{ $plan->max_deposit }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="nina-info-hosting">Start day</div>
                                                            <div class="nina-info-parameter">
                                                                {{ \Carbon\Carbon::parse($plan->from_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="nina-info-hosting">Closing date</div>
                                                            <div class="nina-info-parameter">
                                                                {{ \Carbon\Carbon::parse($plan->end_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="nina-info-hosting">End date</div>
                                                            <div class="nina-info-parameter">
                                                                {{ \Carbon\Carbon::parse($plan->to_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="btn-support cl-1">
                                                        <a href="#" data-id="{{ $plan->id }}"
                                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update"
                                                            wire:click="resetPage" class="btn-views">
                                                            <span>Join</span> <span>Now</span><span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24"
                                                                    style="fill: rgb(255,255,255);transform: ;msFilter:;">
                                                                    <path
                                                                        d="m11.293 17.293 1.414 1.414L19.414 12l-6.707-6.707-1.414 1.414L15.586 11H6v2h9.586z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div> --}}
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
