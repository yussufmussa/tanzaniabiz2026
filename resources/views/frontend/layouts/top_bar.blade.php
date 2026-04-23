<div class="header-top-bar  py-2 padding-right-30px padding-left-30px" style="background-color: #004AAD; color:aliceblue;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 d-flex align-items-center header-top-info font-size-14 font-weight-medium">
                <p class="login-and-signup-wrap">
                    <a href="/login">
                        <span class="mr-1 la la-sign-in"></span>Login
                    </a>
                    <span class="or-text px-2">or</span>
                    <a href="/register">
                        <span class="mr-1 la la-user-plus"></span>Sign Up
                    </a>
                </p>
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6 d-flex align-items-center justify-content-end header-top-info">
                <span class="mr-2 text-white font-weight-semi-bold font-size-14">Follow us on:</span>
                <ul class="social-profile social-profile-colored">
                    <li><a href="{{$setting->first()->facebook}}" target="_blank"><i class="lab la-facebook mr-1"></i></a></li>
                    <li><a href="{{$setting->first()->twitter}}" target="_blank"><i class="lab la-twitter mr-1"></i></a></li>
                    <li><a href="{{$setting->first()->instagram}}" target="_blank"><i class="lab la-instagram mr-1"></i></a></li>
                    <li><a href="{{$setting->first()->linkedin}}" target="_blank"><i class="lab la-linkedin mr-1"></i></a></li>
                </ul>
            </div>
        </div><!-- end row -->
    </div><!-- end container-fluid -->
</div><!-- end header-top-bar -->
