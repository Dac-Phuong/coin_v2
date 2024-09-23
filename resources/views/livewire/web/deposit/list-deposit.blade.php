 @php
     function formatNumber($number, $decimals = 6)
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
                 text-align: center;
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
                             <h1 class="head">List deposit </h1> <br>
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
                         <h4>$<b>{{ formatNumber($investor->balance) }} </b></h4><b>
                     </div>
                     <h1 class="head3"> 02.List Deposit</h1>
                     <div style="max-width: 1600px ; margin: auto">
                         <div class="row">
                             <div class="table-responsive mt-4">
                                 <table style="background: #FFF !important;border:1px solid #ccc !important ">
                                     <thead>
                                         <tr>
                                             <th scope="col">STT</th>
                                             <th scope="col">Plan</th>
                                             <th scope="col">number of days</th>
                                             <th scope="col">Profit</th>
                                             <th scope="col">Deposits Amount</th>
                                             <th scope="col">Amount Received</th>
                                             <th scope="col">Send date</th>
                                             <th scope="col">Status</th>
                                             <th scope="col">Action</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @if (count($list_deposit) > 0)
                                             @foreach ($list_deposit as $key => $deposit)
                                                 <tr>
                                                     <td scope="row"
                                                         style="background: none;color: #fff;cursor: pointer;"
                                                         data-bs-toggle="modal"
                                                         data-id="{{ $deposit->Investor_with_plants_id }}"
                                                         data-bs-target="#kt_modal_show">
                                                         {{ ++$key }}</td>
                                                     <td style="background: none;color: #fff;cursor: pointer"
                                                         data-bs-toggle="modal"
                                                         data-id="{{ $deposit->Investor_with_plants_id }}"
                                                         data-bs-target="#kt_modal_show">
                                                         {{ isset($deposit->name) ? $deposit->name : 'Deposit' }}</td>
                                                     <td data-bs-toggle="modal"
                                                         data-id="{{ $deposit->Investor_with_plants_id }}"
                                                         data-bs-target="#kt_modal_show" style="cursor: pointer">
                                                         {{ $deposit->number_days == 0 ? "" : $deposit->number_days }}</td>
                                                     <td data-bs-toggle="modal"
                                                         data-id="{{ $deposit->Investor_with_plants_id }}"
                                                         data-bs-target="#kt_modal_show" style="cursor: pointer">
                                                         {{ $deposit->plan_discount }}%</td>
                                                     <td data-bs-toggle="modal"
                                                         data-id="{{ $deposit->Investor_with_plants_id }}"
                                                         data-bs-target="#kt_modal_show" style="cursor: pointer">
                                                         {{ formatNumber($deposit->amount) }}
                                                         {{ $deposit->name_coin }}</td>
                                                     <td data-bs-toggle="modal"
                                                         data-id="{{ $deposit->Investor_with_plants_id }}"
                                                         data-bs-target="#kt_modal_show" style="cursor: pointer">
                                                         {{ formatNumber($deposit->total_amount) }}
                                                         {{ $deposit->name_coin }}
                                                     </td>

                                                     <td data-bs-toggle="modal"
                                                         data-id="{{ $deposit->Investor_with_plants_id }}"
                                                         data-bs-target="#kt_modal_show" style="cursor: pointer">
                                                         {{ $deposit->start_date ?? $deposit->from_date }}
                                                     </td>
                                                     @if ($deposit->investor_with_plants_status == 0)
                                                         <td class="text-primary">
                                                             Pending
                                                         </td>
                                                     @elseif($deposit->investor_with_plants_status == 1)
                                                         <td class="text-warning">
                                                             Running
                                                         </td>
                                                     @elseif($deposit->investor_with_plants_status == 2)
                                                         <td class="text-success">
                                                             Success
                                                         </td>
                                                     @else
                                                         <td class="text-danger">
                                                             Cancel
                                                         </td>
                                                     @endif
                                                     <td style="width: 170px">
                                                         @if ($deposit->investor_with_plants_status == 0 || $deposit->investor_with_plants_status == 1)
                                                             <div class="text_but p-0" data-kt-action="update"
                                                                 data-id={{ $deposit->Investor_with_plants_id }}
                                                                 {{-- wire:click="cancel({{ $deposit->Investor_with_plants_id }})" --}} data-bs-toggle="modal"
                                                                 data-bs-target="#kt_modal_update"
                                                                 style="margin-left: 20px; cursor: pointer;">
                                                                 <div class="but p-2 text-white font-weight-bold">
                                                                     Cancel
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
                                     {{ $list_deposit->links() }}
                                 </div>
                             </div>
                             <livewire:web.deposit.confirm-modal />
                             <livewire:web.deposit.deposit-history />
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
