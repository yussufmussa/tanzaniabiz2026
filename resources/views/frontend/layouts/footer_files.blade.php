<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script defer src="{{asset('frontend/js/popper.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script defer src="{{asset('frontend/js/slick.js')}}"></script>
<script defer src="{{asset('frontend/js/jquery.magnific-popup.min.js')}}"></script>
<script defer src="{{asset('frontend/js/counterup.js')}}"></script>
<script defer src="{{asset('frontend/js/moment.min.js')}}"></script>
<script defer src="{{asset('frontend/js/lightbox.js')}}"></script>
<script defer src="{{asset('frontend/js/daterangepicker.js')}}"></script>
<script defer src="{{asset('frontend/js/custom.js')}}"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
@stack('extra_script')
@livewireScripts

</body>
</html>
