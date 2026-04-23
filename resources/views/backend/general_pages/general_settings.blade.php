@extends('backend.layouts.base')
@section('title', 'General Setting')

@section('contents')
    @if (!is_null($setting))
        <!-- If setting is not empty -->
        <div class="row">
            @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cog mr-2"></i>
                            General Settings
                        </h3>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Logo</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('store.general.settings') }}" method="post"
                                    enctype="multipart/form-data">@csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <img class="img-fluid img-thumbnail mb-3" id="logoPreview"
                                                src="{{ asset('uploads/general/' . $setting->logo) }}" alt="preview banner"
                                                style="max-height: 80px;">
                                            <input type="file" name="logo" class="form-control" id="logo">
                                            @error('logo')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="forCategory" class="form-label">Favicon</label>
                                            <img class="img-fluid img-thumbnail mb-3" id="faviconPreview"
                                                src="{{ asset('uploads/general/' . $setting->favicon) }}"
                                                alt="preview banner" style="max-height: 80px;">
                                            <input type="file" name="favicon" class="form-control" id="favicon">
                                            @error('favicon')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div> <!-- end brand -->

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="forCategory" class="form-label">Site Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $setting->name }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="">Hero Background</label>
                                        <div class="col-md-12 mb-3">
                                            <img class="img-fluid img-thumbnail mb-3" id="heroPreview"
                                                src="{{ asset('uploads/general/' . $setting->hero_bg) }}" alt="preview banner"
                                                style="max-height: 1920px;">
                                            <input type="file" name="hero_bg" class="form-control" id="hero_bg">
                                            @error('hero_bg')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <h4 class="card-title mt-3">Social Media</h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Facebook</label>
                                            <input type="text" name="facebook" class="form-control"
                                                value="{{ $setting->facebook }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Instagram</label>
                                            <input type="text" name="instagram" class="form-control"
                                                value="{{ $setting->instagram }}">
                                        </div>



                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Twitter</label>
                                            <input type="text" name="twitter" class="form-control"
                                                value="{{ $setting->twitter }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Linkedin</label>
                                            <input type="text" name="linkedin" class="form-control"
                                                value="{{ $setting->linkedin }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Youtube</label>
                                            <input type="text" name="youtube" class="form-control"
                                                value="{{ $setting->youtube }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Tripadvisor</label>
                                            <input type="text" name="tripadvisor" class="form-control"
                                                value="{{ $setting->tripadvisor }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Get Your Guide</label>
                                            <input type="text" name="getyourguide" class="form-control"
                                                value="{{ $setting->getyourguide }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Tik Tok</label>
                                            <input type="text" name="tiktok" class="form-control"
                                                value="{{ $setting->tiktok }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Telegram</label>
                                            <input type="text" name="youtube" class="form-control"
                                                value="{{ $setting->telegram }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Google Business</label>
                                            <input type="text" name="youtube" class="form-control"
                                                value="{{ $setting->google_business }}">
                                        </div>

                                    </div> <!-- end social media row -->

                                    <h4 class="card-title mt-3">Contacts</h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Email </label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $setting->email }}">
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Mobile Phone </label>
                                            <input type="text" name="mobile_phone" class="form-control"
                                                value="{{ $setting->mobile_phone }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control"
                                                value="{{ $setting->location }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $setting->id }}">
                                    <!-- end general contacts -->

                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                </form>
                            </div> <!-- end seo manager -->
                        </div> <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- if the setting is empty create new records -->
    @else
        <div class="row">
            @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Logo</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('store.general.settings') }}" method="post"
                                    enctype="multipart/form-data">@csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <img class="img-fluid img-thumbnail mb-3" id="logoPreview"
                                                src="{{ asset('uploads/general/no_image.jpg') }}" alt="preview banner"
                                                style="max-height: 80px;">
                                            <input type="file" name="logo" class="form-control" id="logo">
                                            @error('logo')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="forCategory" class="form-label">Favicon</label>
                                            <img class="img-fluid img-thumbnail mb-3" id="faviconPreview"
                                                src="{{ asset('uploads/general/no_image.jpg') }}" alt="preview banner"
                                                style="max-height: 80px;">
                                            <input type="file" name="favicon" class="form-control" id="favicon">
                                            @error('favicon')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div> <!-- end brand -->

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="forCategory" class="form-label">Site Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>

                                    <h4 class="card-title mt-3">Social Media</h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Facebook</label>
                                            <input type="text" name="facebook" class="form-control">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Instagram</label>
                                            <input type="text" name="instagram" class="form-control">
                                        </div>



                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Twitter</label>
                                            <input type="text" name="twitter" class="form-control">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Linkedin</label>
                                            <input type="text" name="linkedin" class="form-control">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Youtube</label>
                                            <input type="text" name="youtube" class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Tripadvisor</label>
                                            <input type="text" name="tripadvisor" class="form-control"
                                                value="{{ $setting->tripadvisor }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Get Your Guide</label>
                                            <input type="text" name="getyourguide" class="form-control"
                                                value="{{ $setting->getyourguide }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Tik Tok</label>
                                            <input type="text" name="tiktok" class="form-control"
                                                value="{{ $setting->tiktok }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Telegram</label>
                                            <input type="text" name="telegram" class="form-control"
                                                value="{{ $setting->telegram }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Google Business</label>
                                            <input type="text" name="google_business" class="form-control"
                                                value="{{ $setting->google_business }}">
                                        </div>
                                    </div> <!-- end social media row -->

                                    <h4 class="card-title mt-3">Contacts</h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Email 1</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Mobile Phone </label>
                                            <input type="text" name="mobile_phone" class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="forCategory" class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control">
                                        </div>
                                    </div>
                                    <!-- end general contacts -->

                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                </form>
                            </div> <!-- end seo manager -->
                        </div> <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@push('extra_script')
    <script type="text/javascript">
        $('#logo').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#logoPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('#favicon').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#faviconPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('#hero_bg').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#heroPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 4000);
    </script>
@endpush
