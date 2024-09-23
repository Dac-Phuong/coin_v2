 @php
     function formatNumber($number, $decimals = 6)
     {
         $formattedNumber = number_format($number, $decimals);
         return rtrim(rtrim($formattedNumber, '0'), '.');
     }
 @endphp
 <div class="main_wrapper">
     <div class="plan_bg">
         <div class="container">
             <div class="plan">
                 <div class="head">
                     <h3>INVESTMENT PLAN<br>Flexible, can withdraw at any time</h3>
                 </div>
                 <div class="d-flex flex-wrap mt-4">
                     </h4>
                     <div class="d-flex flex-wrap check_box_wrap">
                         @foreach ($coins as $coin)
                             <div class="check_box check_box2 p-1" wire:click="checkbox({{ $coin->id }})">
                                 <label class="radio_btn {{ $coin->id == $coin_id ? 'active' : '' }}">
                                     <input type="radio" name="type" {{ $coin->id == $coin_id ? 'checked' : '' }}
                                         value="process_18" data-fiat="USD" style="display:none;">
                                     <span class="checkmark1">
                                         <p class=" font-weight-bold "><img src="{{ $coin->coin_image }}"
                                                 class="pay">
                                             {{ $coin->coin_name }}</p>
                                     </span>
                                 </label>
                             </div>
                         @endforeach
                     </div>
                 </div>
                 <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
                     @if (isset($plan_fixeds))
                         @foreach ($plan_fixeds as $key => $plan_fixed)
                             <div class="col relative">
                                 <a href="{{ url('/deposit') }}" wire:navigate class="nina-col-hosting">
                                     <div class="nina-item-hosting">
                                         <div class="nina-header-hosting alex-nina-header-hosting{{ $key }}">
                                             <div class="nina-title-hosting">
                                                 <h2>{{ $plan_fixed->name }}</h2>
                                             </div>
                                             <div class="nina-desc-hosting"></div>
                                             <div class="nina-price-hosting alex-nina-price-hosting{{ $key }}">
                                                 <div>
                                                     <div class="nina-text-price1">Package</div>
                                                     <div class="nina-text-price2" style="font-size:22px">
                                                         {{ formatNumber($plan_fixed->min_deposit, $plan_fixed->coin_decimal) }} {{ $plan_fixed->coin_name }}
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="nina-body-hosting nina-host-pho-thong{{ $key }}">
                                             <ul>
                                                 @foreach ($plan_fixed->number_profit as $item)
                                                     @php
                                                         $total =
                                                             ($item->profit / 100) * $plan_fixed->min_deposit +
                                                             $plan_fixed->min_deposit;
                                                     @endphp
                                                     <li class="w-100 flex-column ">
                                                         <div class="w-100 d-flex justify-content-between">
                                                             <div class="nina-info-hosting w-50" style="font-size:15px">
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
                                                             {{ isset($total) ? formatNumber($total , $plan_fixed->coin_decimal) : 0 }}
                                                             {{ $plan_fixed->coin_name }}
                                                         </div>
                                                     </li>
                                                 @endforeach
                                             </ul>
                                         </div>
                                     </div>
                                 </a>
                             </div>
                         @endforeach
                     @endif
                 </div>
             </div>
         </div>
     </div>
     <div class="about_plan">
         <div class="container">
             <div class="calci_bg">
                 <div class="row">
                     <div class="col-lg-6 col-md-12">
                         <div class="calci">
                             <div class="head"></div>
                             <div class="modal fade calci_popup" id="calciModal" tabindex="-1"
                                 aria-labelledby="calciModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">
                                                 Select plan
                                             </h5>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                 aria-label="Close">X</button>
                                         </div>
                                         <div class="modal-body">
                                             <ul class="calci_detail">
                                                 <li>
                                                     <h3>Select plan</h3>
                                                     <select class="" id="Ultra">
                                                         <option value="1" class="opts">Plan1</option>
                                                         <option value="2" class="opts">Plan2</option>
                                                         <option value="3" class="opts">Plan3</option>
                                                         <option value="4" class="opts">Plan4</option>
                                                     </select>
                                                 </li>
                                                 <li>
                                                     <h3>Enter Amount - Please select the cryptocurrency you want to deposit</h3>
                                                     <input type="text" class="inpts" id="money" placeholder=""
                                                         value="" />
                                                 </li>
                                                 <li>
                                                     <h3>Daily Profit</h3>
                                                     <h4 id="profitDaily">0.90</h4>
                                                 </li>
                                                 <li>
                                                     <h3>Total Profit</h3>
                                                     <h4 id="profitTotal">11.70</h4>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="calci_img">
                                 <img src="images/calci_img3.png" class="img1 img-fluid" alt="calci_img1" />
                                 <img src="images/calci_img4.png" class="img2 img-fluid" alt="calci_img1" />
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-6 col-md-12">
                         <div class="head aos-init" data-aos="fade-left" data-aos-duration="2200">
                             <h2>Facts &amp; Projects</h2>
                             <h3>Our Achivements</h3>
                             <p>STAKINGCOINS is the best place to earn rewards and generate passive income from your
                                 USDT.</p>
                             <p>
                                 STAKINGCOINS Investment Limited is the ultimate platform for all
                                 Cryptocurrency enthusiasts! Our innovative platform offers a
                                 range of features With Novamining, you can earn money and
                                 enjoy financial freedom in the exciting world of
                                 cryptocurrency. Join us now and experience the future of the
                                 crypto world!
                             </p>
                         </div>
                         <div class="text_but ">
                             <a href="{{ $investor ? url('account') : url('register') }}" wire:navigate
                                 class="but hvr-float-shadow">
                                 {{ $investor ? 'deposit now' : 'invest now' }}</a>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
     </div>
     <div class="campaign">
         <div class="container">
             <div class="row">
                 <div class="col-lg-7">
                     <div class="section-title head">
                         <h3>Stakingcoins Supports Established & Emerging Protocols<br>Earn interest on Tether up to
                             280%
                             APY</h3>
                     </div>
                     <div class="join-now">
                         <a href='{{ $investor ? url('account') : url('register') }}' target='_blank'>Join Now</a>
                     </div>
                 </div>
                 <div class="col-lg-5">
                     <div class="dt-css-grid">
                         @foreach ($network as $item)
                             <div class="wf-cell shown">
                                 <div class="the7-icon-box-grid">
                                     <div class="box-content-wrapper">
                                         <div class="elementor-icon">
                                             <img width="48" height="48" src="{{ $item->network_image }}"
                                                 alt="Uploaded Image">
                                         </div>
                                         <div class="box-content">
                                             <h4 class="box-heading">
                                                 <a href="{{ $investor ? url('account') : url('register') }}"
                                                     wire:navigate aria-label="Avalanche">
                                                     {{ $item->network_name }}
                                                 </a>
                                             </h4>
                                             <div class="alex-desc">
                                                 <div class="box-description">{{ $item->description }}</div>
                                                 <a href="{{ $investor ? url('account') : url('register') }}"
                                                     wire:navigate aria-label="Avalanche"
                                                     class="box-button elementor-button elementor-size-sm no-text"><i
                                                         aria-hidden="true"
                                                         class="elementor-button-icon fas fa-arrow-right"></i></a>
                                             </div>

                                         </div>
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="refer_plan">
         <div class="container">
             <div class="refer_bg">
                 <div class="row">
                     <div class="col-lg-6 col-md-12">
                         <div class="refer">
                             <div class="head aos-init" data-aos="fade-right" data-aos-duration="2500">
                                 <h2>AFFILIATE PROGRAM</h2>
                                 <h3>Referral Commision</h3>
                                 <p>
                                     <span> Stakingcoins</span> Forming partnerships is critical to
                                     the success of any business. This also applies to large
                                     investment projects. Developing partnerships is key to
                                     ensuring success for all. Keeping in mind the importance of
                                     partnerships, we have designed a very profitable affiliate
                                     program.
                                 </p>
                                 <p>
                                     Share your referral link and invite your friends and family
                                     to sign up on the Stakingcoins platform and earn passive income
                                     with our affiliate program up to 2 levels. You don't need to
                                     be actively investing to earn affiliate income.
                                 </p>
                             </div>
                             <div class="text_but">
                                 <a href="{{ $investor ? url('account') : url('register') }}" wire:navigate
                                     class="but hvr-float-shadow"> {{ $investor ? 'invest now' : 'Join now' }}</a>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-6 col-md-12">
                         <div class="refer_level">
                             <img src="images/refer_img.png" class="img1" alt="refer_img" />
                             <ul class="level_detail">
                                 <li>
                                     <h3>5%</h3>
                                     <h4>Level2</h4>
                                 </li>
                                 <li>
                                     <h3>3%</h3>
                                     <h4>Level1</h4>
                                 </li>

                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
