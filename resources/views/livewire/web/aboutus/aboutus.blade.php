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
                <div class="content_text head ml9">
                    <h3>About Us</h3> <p>Our team of brilliant minds is dedicated to identifying emerging technologies and harnessing their potential to create positive and lasting change. 
<br>We believe that innovation is the key to addressing the world's most pressing challenges and unlocking new opportunities for growth and progress.
                </div>
                <div class="content_subtext"></div>
            </div>
        </div>
    </div>
    <div class="about_bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="about_vedio">
                        <a href="https://youtu.be/ja_Irb5LS1k" alt="certificate" data-fancybox="gallary">
                            <img src="images/vedio_but.png" class="vedio_but" alt="vedio_but" />
                        </a>
                        <img src="images/about_img.png" class="about_img" alt="about_img" />
                    </div>
                    <div class="about_text">
                        <img src="images/about_img1.png" class="img1" alt="about_img1" />
                        <h5>DDOS PROTECTION</h5>
                        <p>
                            Our state-of-the-art software provides advanced DDoS protection.
                        </p>
                    </div>
                    <div class="about_text">
                        <img src="images/about_img1.png" class="img1" alt="about_img1" />
                        <h5>SSL SECURITY</h5>
                        <p>
                            A green EV-SSL icon in the browser window indicates that your
                            information is secure.
                        </p>
                    </div>
                    <div class="text_but">
                        <a href="{{ $investor ? url('/account') : url('/register') }}" wire:navigate class="but2"> Join now</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="head">
                        <h2>About Company</h2>
                        <h3><span> Stakingcoins</span> investment <span> Limited</span></h3>
                        <p>
                            <span> Stakingcoins Investment Limited</span> is an international
                            financial company headquartered in the United Kingdom (Company
                            Mumber:14800184). We provide intelligent and quantitative
                            trading tools on major decentralized exchanges, as well as
                            cryptocurrency storage, cold wallet services, and cryptocurrency
                            ATM services.Our team members are leaders in various fields and
                            serve to ensure the safety and efficient use of your funds. Just
                            one step to register on our official platform, You will have the
                            opportunity to obtain stable and safe passive income and grow
                            your wealth in the long term.
                        </p>
                    </div>
                    <div class="cert_detail">
                        <a href="images/certificate.jpg" alt="certificate" data-fancybox="gallary">
                            <img src="images/certificate.png" alt="certificate" class="img2" />
                        </a>
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
