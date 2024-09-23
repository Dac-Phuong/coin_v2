<div class="wrapper">
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
                    <div class="home-content">
                        <div id="toggleButton">
                            <i class="ri-menu-line menu-mobile"></i>
                            <h1 class="head">Edit Account </h1> <br>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="home-content1">
                        <li>
                            <h3> <i class="ri-map-pin-user-line"></i> user :<span>
                                    {{ isset($investor) ? $investor->fullname : '' }}</span></h3>
                            <h3> <i class="ri-mail-open-line"></i> Email: <span>
                                    {{ isset($investor) ? $investor->email : '' }}</span> </h3>
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
                    <div class="admin_bg login_bg signup_bg">
                        @if (session('success'))
                            <div class="error">{{ session('success') }}</div>
                        @endif
                        <div class="m-auto" style="max-width: 1500px ; width: 100%;">
                            <div class="row mt-5">
                                <div class="col-lg-7 col-md-12">
                                    <div class="head2" style="margin-bottom: 80px;margin-left: 35%;">
                                        <h2 class="text-center">Edit <span> Account</span></h2>
                                    </div>
                                    {{-- @if (session('error'))
                                        <div class="error">{{ session('error') }}</div>
                                    @endif --}}
                                    <form onsubmit="return checkform()" wire:submit.prevent="submit" name="regform">
                                        <div class="form1">
                                            <div class="form_text">
                                                <img src="images/form_img1.png" class="form_img" />
                                                <h2>Edit <span> form</span></h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form_box">
                                                        <h3>Full Name</h3>
                                                        <h4>
                                                            <input type="text" wire:model.defer="fullname"
                                                                style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                                name="fullname" class="inpts" size="30" />
                                                            <i class="ri-shield-user-line"></i>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form_box">
                                                        <h3>Your Username</h3>
                                                        <h4>
                                                            <input type="text" wire:model.defer="username"
                                                                style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                                name="username" class="inpts" size="30" />
                                                            <i class="ri-shield-user-line"></i>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form_box">
                                                        <h3>Define Password</h3>
                                                        <h4>
                                                            <input type="password" wire:model.defer="password"
                                                                style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                                name="password" class="inpts" size="30" />
                                                            <i class="ri-shield-user-line"></i>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form_box">
                                                        <h3>Retype Password</h3>
                                                        <h4>
                                                            <input type="password" name="password2" class="inpts"
                                                                style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                                size="30" />
                                                            <i class="ri-shield-user-line"></i>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form_box">
                                                        <h3>E-mail Address</h3>
                                                        <h4>
                                                            <input type="text" disabled wire:model.defer="email"
                                                                style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                                name="email" class="inpts" size="30" />
                                                            <i class="ri-shield-user-line"></i>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form_box">
                                                        <h3>Retype Your E-mail</h3>
                                                        <h4> <input type="text" disabled name="email1"
                                                                style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                                wire:model.defer="email" class="inpts"
                                                                size="30" />
                                                            <i class="ri-shield-user-line"></i>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form_box">
                                                    <h3></h3>
                                                    <h4>
                                                        <input value="N/A (n/a)" size="30" class="inpts"
                                                            style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                            disabled="" />
                                                        <i class="ri-money-dollar-circle-line"></i>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form_but m-auto" style="max-width: 550px;">
                                            <input type="submit" value="Save" class="sbmt" />
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <div class="d-flex">
                                        <div class="head2">
                                            <h2>List of your wallets</h2>
                                        </div>
                                        <div class="form_but text_but cusor m-auto pt-0" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_update" style="cursor: pointer">
                                            <div class="but">Add wallet</div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Network</th>
                                                    <th scope="col">Wallet address</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                                @if (isset($list_wallet) && count($list_wallet) > 0)
                                                    @foreach ($list_wallet as $key => $wallet)
                                                        <tr>
                                                            <th scope="row">{{ ++$key }}</th>
                                                            <td>{{ $wallet->network_name }}</td>
                                                            <td>{{ $wallet->wallet_address }}</td>
                                                            <td>
                                                                <div class="item-center mt-1" style="cursor: pointer"
                                                                    wire:click="delete({{ $wallet->id }})">
                                                                    <svg width="18px" fill="#fff"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                        <path
                                                                            d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                                    </svg>
                                                                </div>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <livewire:web.account.modal-deposit />
                </div>
            </div>
             
            <div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true" wire:ignore.self>
                <!--begin::Modal dialog-->
                <div class="depo_bg modal-dialog modal-dialog-scrollable mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_add_user_header">
                            <!--begin::Modal title-->
                            <div class="card-header d-flex flex-wrap">
                                <h4 class="mb-0 text-white">Add Wallet
                                </h4>
                            </div>
                            <!--end::Modal title-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"
                                aria-label="Close">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    style="color: #fff;border: 4px double #fff;"><svg
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <path fill="#fff"
                                            d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                    </svg></button>
                            </div>
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body">
                            @if ($errors->any())
                                <div class="error">{{ $errors->first() }}</div>
                            @endif
                            @if (session('error'))
                                <div class="error">{{ session('error') }}</div>
                            @endif
                            <form action="#" wire:submit.prevent="create_wallet">
                                <div class="tab-content wd_box" id="pills-tabContent">
                                    <div class="form1"
                                        style="background: linear-gradient(179deg, #312a26 -13%, #2c5168 91%);">
                                        <div class="form_box text-center">
                                            <span class="mb-1" style="font-weight: 400">Select network</span>
                                            <select wire:model.live="network_id"
                                                style="color: #000;width: 100%;font-weight: 400">
                                                <option value="">Select network</option>
                                                @if (isset($networks))
                                                    @foreach ($networks as $network)
                                                        <option value="{{ $network->id }}">
                                                            {{ $network->network_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-center mt-2" style="font-weight: 400">
                                                Enter your address wallet
                                            </span>
                                            <h4>
                                                <i class="ri-money-dollar-circle-line"></i> <input type="text"
                                                    name="wallet_address"
                                                    style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                    wire:model.live="wallet_address" size="15" class="inpts"
                                                    id="inv_wallet_address">
                                            </h4>
                                        </div>
                                        <div class="form_but">
                                            <button type="submit" data-kt-users-modal-action="create_wallet"
                                                class="sbmt">Save<div class="indicator-progress" wire:loading
                                                    wire:target="create_wallet">
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </div></button>
                                        </div>
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
        </div>
    </section>

</div>
<script language="javascript">
    function checkform() {
        if (document.regform.fullname.value == "") {
            alert("Please enter your full name!");
            document.regform.fullname.focus();
            return false;
        }
        if (document.regform.username.value == "") {
            alert("Please enter your username!");
            document.regform.username.focus();
            return false;
        }
        if (
            !document.regform.username.value.match(/^[A-Za-z0-9_\-]+$/)
        ) {
            alert(
                "For username you should use English letters and digits only!"
            );
            document.regform.username.focus();
            return false;
        }
        if (document.regform.email.value == "") {
            alert("Please enter your e-mail address!");
            document.regform.email.focus();
            return false;
        }
        if (
            document.regform.email.value != document.regform.email1.value
        ) {
            alert("Please retype your e-mail!");
            document.regform.email.focus();
            return false;
        }
        for (i in document.regform.elements) {
            f = document.regform.elements[i];
            if (f.name && f.name.match(/^pay_account/)) {
                if (f.value == "") continue;
                var notice = f.getAttribute("data-validate-notice");
                var invalid = 0;
                if (f.getAttribute("data-validate") == "regexp") {
                    var re = new RegExp(
                        f.getAttribute("data-validate-regexp")
                    );
                    if (!f.value.match(re)) {
                        invalid = 1;
                    }
                } else if (f.getAttribute("data-validate") == "email") {
                    var re = /^[^\@]+\@[^\@]+\.\w{2,4}$/;
                    if (!f.value.match(re)) {
                        invalid = 1;
                    }
                }
                if (invalid) {
                    alert("Invalid account format. Expected " + notice);
                    f.focus();
                    return false;
                }
            }
        }
        return true;
    }

    function IsNumeric(sText) {
        var ValidChars = "0123456789";
        var IsNumber = true;
        var Char;
        if (sText == "") return false;
        for (i = 0; i < sText.length && IsNumber == true; i++) {
            Char = sText.charAt(i);
            if (ValidChars.indexOf(Char) == -1) {
                IsNumber = false;
            }
        }
        return IsNumber;
    }
</script>
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
