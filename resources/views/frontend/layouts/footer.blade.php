<nav class="bottom-menu">
    <ul>
        <li class="active"><a href="/"><i class="fas fa-home"></i><span>Home</span></a></li>
        <li><a href="/register"><i class="fas fa-plus text-danger"></i><span>+</span></a></li>
        <li><a href="/login"><i class="fas fa-user"></i><span>Sign In</span></a></li>
        <li><a href="/list-of-companies-in-tanzania"><i class="fas fa-globe"></i><span>Browse</span></a></li>
    </ul>
</nav>

<footer class="light-footer skin-light-footer style-2">
    <div class="footer-middle">
        <div class="container">
            <div class="row">

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="footer_widget">
                        <img src="{{ asset('uploads/general/' . $setting->logo) }}" class="img-footer small mb-2"
                            alt="Tanzania biz logo" />
                        <p class="mt-2 mb-0" style="font-size: 14px; color: #666;">Tanzania's #1 Business Directory —
                            Find, List & Grow Your Business.</p>
                        <div class="address mt-2">
                            {{ $setting->location }}
                        </div>
                        <div class="address mt-3">
                            <a
                                href="javascript:location='mailto:\u0069\u006e\u0066\u006f\u0040\u0074\u0061\u006e\u007a\u0061\u006e\u0069\u0061\u0062\u0069\u007a\u002e\u0063\u006f\u006d';void 0">
                                <script>
                                    document.write(
                                        '\u0069\u006e\u0066\u006f\u0040\u0074\u0061\u006e\u007a\u0061\u006e\u0069\u0061\u0062\u0069\u007a\u002e\u0063\u006f\u006d'
                                        )
                                </script>
                            </a>
                        </div>
                        <div class="address mt-2">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="{{ $setting->facebook }}" class="theme-cl"
                                        target="_blank" rel="noopener"><i class="lni lni-facebook-filled"
                                            style="font-size: 24px;"></i></a></li>
                                <li class="list-inline-item"><a href="{{ $setting->twitter }}" class="theme-cl"
                                        target="_blank" rel="noopener"><i class="lni lni-twitter-filled"
                                            style="font-size: 24px;"></i></a></li>
                                <li class="list-inline-item"><a href="{{ $setting->youtube }}" class="theme-cl"
                                        target="_blank" rel="noopener"><i class="lni lni-youtube"
                                            style="font-size: 24px;"></i></a></li>
                                <li class="list-inline-item"><a href="{{ $setting->instagram }}" class="theme-cl"
                                        target="_blank" rel="noopener"><i class="lni lni-instagram-filled"
                                            style="font-size: 24px;"></i></a></li>
                                <li class="list-inline-item"><a href="{{ $setting->linkedin }}" class="theme-cl"
                                        target="_blank" rel="noopener"><i class="lni lni-linkedin-original"
                                            style="font-size: 24px;"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Free Online Business Tool</h4>
                        <ul class="footer-menu">
                            <li><a href="/tools/invoice-generator">Invoice Generator</a></li>
                            <li><a href="/tools/qr-code-generator">Qr Code Generator</a></li>

                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Quick Link</h4>
                        <ul class="footer-menu">
                            <li><a href="/about-us">About Us</a></li>
                            <li><a href="/register">List Your Business Free</a></li>
                            <li><a href="/privacy-policy">Privacy of policy</a></li>
                            <li><a href="/terms-of-service">Terms of service</a></li>
                            <li><a href="/disclamer">Disclaimer</li>
                            <li><a href="#">FAQs</a></li>
                            <li><a href="/blog"></a>Read our blog</li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Our Networks</h4>
                        <ul class="footer-menu">
                            <li><a href="https://utaliidirectory.com" target="_blank" rel="noopener">Tanzania tourism
                                    directory</a></li>
                            <li><a href="https://visitzanzibarguide.com" target="_blank" rel="noopener">Zanzibar travel
                                    Guides</a></li>
                            <li><a href="#" target="_blank" rel="noopener">Kenya tourism directory</a></li>
                            <li><a href="#" target="_blank" rel="noopener">Uganda tourism directory</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Browse</h4>
                        <ul class="footer-menu">
                            <li><a href="/disclamer"></a>Featured Listing</li>
                            <li><a href="/browse-business-by-category">By Category</a></li>
                            <li><a href="/terms-of-service">By City</a></li>
                            <li><a href="/privacy-policy"></a>New Listings</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom br-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 text-center">
                    <p class="mb-0">© {{ date('Y') }} All Right Reserved | Tanzania Biz.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ============================ Footer End ================================== -->
