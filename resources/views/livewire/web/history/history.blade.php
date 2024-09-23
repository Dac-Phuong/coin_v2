<div class="wrapper">
    @include('web.layouts.navbar')
    <section class="home-section">
        <div class="headerall_top">
            <div class="row">
                <div class="col-lg-3">
                    <a href="{{ url('/') }}" wire:navigate> <img src="images/logo1.png" class="img-fluid logo hvr-wobble-vertical"></a>
                </div>
                <div class="col-lg-5">
                    <div class="home-content">
                        <i class="ri-menu-line"></i>
                        <h1 class="head">History </h1> <br>
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
                            Referal link
                            <input type="text" value="https://stakingcoins.net/?ref=phuong" id="myInput">
                            <button ><i class="ri-link-unlink-m"></i></button>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text_but d-flex flex-wrap justify-content-end ">
                         <div class="but cursor-pointer" data-bs-toggle="modal" data-bs-target="#kt_modal_update">Deposit</div>
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
                        <h4>$<b>{{ $investor->balance }} </b></h4><b>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
