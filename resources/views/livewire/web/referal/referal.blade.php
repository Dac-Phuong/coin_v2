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
                            <h1 class="head">Referral </h1> <br>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="home-content1">
                        <li>
                            <h3> <i class="ri-map-pin-user-line"></i> user :<span> {{ $investor->fullname }}</span></h3>
                            <h3> <i class="ri-mail-open-line"></i> Email: <span> {{ $investor->email }}</span> </h3>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8">
                    <div class="refer_copy">
                        <img src="images/acc_img3.png" class="img-fluid acc_img2">
                        <h3>
                            Referral link
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
                    <ul class="user_detail ">
                        <li>
                            <div class="form_block">
                                <img src="images/acc_img4.png" class="acc_img4 img-fluid">
                                <h3> Account Balance </h3>
                                <h4>$<b>{{ formatNumber($investor->balance, 6) }} </b></h4><b>
                            </div>
                        </li>
                        <li>
                            <div class="form_block">
                                <img src="images/acc_img5.png" class="acc_img4 img-fluid">
                                <h3>Commission percentage </h3>
                                <h4> {{ isset($referal) ? $referal->amount_money : 0 }}%</h4>
                            </div>
                        </li>
                        <li>
                            <div class="form_block">
                                <img src="images/acc_img6.png" class="acc_img4 img-fluid">
                                <h3> Total referral</h3>
                                <h4> {{ $number_referals }}</h4>
                            </div>
                        </li>
                        <li>
                            <div class="form_block">
                                <img src="images/acc_img7.png" class="acc_img4 img-fluid">
                                <h3>First commission received</h3>
                                <h4> {{ isset($ref_detail) ? $ref_detail->amount_received : 0 }}
                                    {{ isset($ref_detail) ? $ref_detail->coin_name : '' }}
                                </h4>
                            </div>
                        </li>
                    </ul>
                    <h1 class="head3"> 01.List Investor Referral</h1>

                    <div style="max-width: 1600px; margin: auto">
                        <div class="row">
                            <div class="table-responsive mt-4">
                                <table cellspacing="0" cellpadding="1" class="form deposit_confirm"
                                    style="background: #fff !important;border:1px solid #ccc !important">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">FullName</th>
                                            <th scope="col">Email Address</th>
                                            <th scope="col">Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($list_referal) > 0)
                                            @foreach ($list_referal as $key => $referal)
                                                <tr>
                                                    <td scope="row" style="background: none;color: #fff">
                                                        {{ ++$key }}</td>
                                                    <td style="background: none;color: #fff">{{ $referal->fullname }}
                                                    </td>
                                                    <td>{{ $referal->email }}</td>
                                                    <td>{{ $referal->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" style="text-align:center; color:red">
                                                    No data.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $list_referal->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <livewire:web.account.modal-deposit />
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
