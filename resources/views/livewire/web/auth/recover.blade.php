<div>
    <div class="header_bg header1_bg">
        <div class="container">
            <div class="banner_bg">
                <header>
                    @include('web.layouts.nav')
                </header>
            </div>
        </div>
        <div class="content_bg banner">
            <div class="container">
                <div class="head content_text ml9">
                    <h3>Recover Form</h3>
                    <p><br>We invest in leading financial companies from Europe, Asia and the Americas. <br>
                        The most difficult problems are always the best business opportunities</p>
                </div>
                <div class="content_subtext"></div>
            </div>
        </div>
    </div>
    <div class="admin_bg login_bg">
        <div class="container">
            <div class="head2">
                <h2>Recover <span> </span></h2>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="head_img">
                        <img src="images/content_img4.png" class="img1" alt="content_img3" />
                    </div>
                    <div class="rem_text text-center">
                        <h3>You have create an account? or Login ?</h3>
                        <div class="text_but text-center">
                            <a href="{{ url('login') }}" wire:navigate class="but"> Login</a>
                            <a href="{{ url('register') }}" wire:navigate class="but"> Signup</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    @if (session('error'))
                        <div class="error">{{ session('error') }}</div>
                    @elseif ($errors->any())
                        <div class="error">{{ $errors->first() }}</div>
                    @elseif(session('success'))
                        <div class="error">{{ session('success') }}</div>
                    @endif
                    <div class="form1">
                        <div class="form_text">
                            <a href="?home">
                                <img src="images/form_img1.png" class="form_img" /></a>
                            <h2>Recover <span> form</span></h2>
                        </div>
                        <form wire:submit.prevent="submit" action="#">
                            <div class="form_box">
                                <h3>Email Address</h3>
                                <h4> <input type="text" wire:model.defer="email" class="inpts" size="30" style="width: 100%;font-size: 16px;box-sizing: border-box;"
                                        autofocus="autofocus" data-gtm-form-interact-field-id="0" />
                                    <i class="ri-shield-user-line"></i>
                                </h4>
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
@endpush
