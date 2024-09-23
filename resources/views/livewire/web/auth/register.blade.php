<div class="depo_bg">
    <div class="header_bg header1_bg">
        <div class="container">
            <div class="banner_bg">
                <header>
                    @include('web.layouts.nav')
                </header>
            </div>
        </div>
        <div class="scroller">
            <a href="#" id="scroll" style="display: none">
                <img src="images/up.png" class="top_but" />
            </a>
        </div>
        <div class="content_bg banner">
            <div class="container">
                <div class="content_text ml9 head">
                    <h3>Signup form</h3>
                    <p><br>We’re global. <br>We were really interested in global expansion.
                        <br>We invest in founders around the world with global ambitions.
                        <br>We support people with a vision to invest for the future.
                    </p>
                </div>
                <div class="content_subtext"></div>
            </div>
        </div>
    </div>
    <div class="admin_bg login_bg signup_bg">
        <div class="container">
            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @elseif(session('success'))
                <div class="error">{{ session('success') }}</div>
            @endif
            <div class="head2">
                <h2>Signup <span> Details</span></h2>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="head_img">
                        <img src="images/content_img4.png" class="img1" alt="content_img3" />
                    </div>
                    <div class="rem_text text-center">
                        <h3>You have already create an account? or Recover ?</h3>
                        <div class="text_but text-center">
                            <a href="{{ url('login') }}" wire:navigate class="but"> login</a>
                            <a href="{{ url('recover') }}" wire:navigate class="but"> Recover</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <form wire:submit.prevent="submit" name="regform">
                        <div class="form1">
                            <div class="form_text">
                                <a href="?home">
                                    <img src="images/form_img1.png" class="form_img" /></a>
                                <h2>Signup <span> form</span></h2>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>Full Name</h3>
                                        <h4>
                                            <input type="text" wire:model.defer="fullname" name="fullname" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                value="" class="inpts" size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>Your Username</h3>
                                        <h4>
                                            <input type="text" wire:model.defer="username" name="username" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                class="inpts" size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>Define Password</h3>
                                        <h4>
                                            <input type="password" wire:model.defer="password" name="password" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                class="inpts" size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>Retype Password</h3>
                                        <h4>
                                            <input type="password" wire:model.defer="confirm_password" class="inpts" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>E-mail Address</h3>
                                        <h4>
                                            <input type="text" wire:model.defer="email" name="email" class="inpts" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>Retype Your E-mail</h3>
                                        <h4> <input type="text" wire:model.defer="confirm_email" class="inpts" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>Secret question</h3>
                                        <h4>
                                            <input type="text" wire:model.defer="question" class="inpts" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form_box">
                                        <h3>Secret answer</h3>
                                        <h4>
                                            <input type="text" wire:model.defer="answer" class="inpts" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                size="30" />
                                            <i class="ri-shield-user-line"></i>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form_box">
                                        <h3></h3>
                                        <h4>
                                            <input value="N/A (n/a)" disabled wire:model.defer="ref" size="30" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                                class="inpts" />
                                            <i class="ri-money-dollar-circle-line"></i>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rem_text">
                            <p>
                                <input type="checkbox" wire:model.defer="agree" name="agree" value="1" /> I 
                                agree with
                                <a href="" wire:navigate>Terms and conditions</a>
                            </p>
                        </div>
                        <div class="form_but">
                            <button type="submit" data-kt-users-modal-action="submit" class="sbmt">Submit<div
                                    class="indicator-progress" wire:loading wire:target="submit">
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </div></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="checkMailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 500px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Check your email</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg
                            fill="#fff" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg></button>
                </div>
                <div class="modal-body">
                    <p>Please check your email (may appear in your email spam folder) to confirm your email address
                        before logging in to the system...</p>
                </div>
                <div class="modal-footer text_but">
                    <a href="{{ url('login') }}" wire:navigate class="btn btn-primary but mr-2"
                        style="border: none;">Agree</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('js/googleTranslate.js') }}"></script>
    <script>
        function loadGoogleTranslate() {
            new google.translate.TranslateElement("google_element");
        }
        document.addEventListener("livewire:navigated", function() {
            loadGoogleTranslate()
        });
    </script>
    <script>
        document.addEventListener("livewire:init", function() {
            Livewire.on("isShow", function(success) {
                $('#checkMailModal').modal('show');
            });

        });
    </script>
@endpush
