  <div class="tab-pane fade show active" id="general" role="tabpanel">
      <form id="generalTabForm" enctype="multipart/form-data">
          <h5 class="mb-3">Business Information</h5>
          <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="form-group">
                      <label class="mb-1"><h6>Business Name <span class="text-danger">*</span></h6></label>
                      <input type="text" name="name" value="{{ $listing->name ?? old('name') }}"
                          class="form-control rounded" placeholder="Enter Your Business Name">
                         @error('name')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>
              <input type="hidden" id="business_listing_id" value="{{ $listing->id ?? '' }}">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                  <div class="form-group">
                      <label class="mb-1"><h6>Business Categories <span class="text-danger">*</span></h6></label>
                      <select name="category_id" class="form-control" id="category_id">
                          <option>-- Select Category -- </option>
                          @foreach ($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}
                              </option>
                          @endforeach
                      </select>
                      @error('category_id')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>

              <div id="loader" style="display:none;">
                  <img src="{{ asset('uploads/general/loading.gif') }}" alt="Loading..." />
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4" id="subcategory_div">
                  <div class="form-group">
                      <label class="mb-1"><h6>Business Sub Categories (<small>select up to
                              5</small>) <span class="text-danger">*</span></h6></label>
                      <select name="subcategory_id[]" class="form-control" id="subcategory_id" multiple="multiple">
                      </select>
                      @error('subcategory_id')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>

              <div class="mb-4">
                  <h6>Business Logo <span class="text-danger">*</span></h6>
                  @if (isset($listing))
                      <img src="{{ asset('uploads/businessListings/logos/' . $listing->logo) }}"
                          alt="{{ $listing->name }}" class="img-thumbnail mb-3" width="200" height="200"
                          id="businessLogo">
                  @endif

                  <img src="{{ asset('uploads/general/logo_placeholder.png') }}" alt="Business Logo" class="img-thumbnail mb-3"
                      width="200" height="200" id="businessLogo">
                  <div class="form-group">
                      <input name="logo" class="form-control rounded" id="logo" type="file">
                      @error('logo')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                      <span class="text-danger">Maximum size 2Mb</span>
                  </div>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="form-group">
                      <label class="mb-1"><h6>Business description <span class="text-danger">*</span></h6></label>
                      <textarea name="description" class="form-control rounded ht-150" placeholder="Enter business description">
                        {{ $listing->description ?? old('description') }}
                     </textarea>
                      @error('description')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>

              <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                  <div class="form-group">
                      <label class="mb-1"><h6>City<span class="text-danger">*</span></h6></label>
                      <select name="city_id" class="form-control" id="city_id">
                          <option>-- Select City -- </option>
                          @foreach ($cities as $city)
                              <option value="{{ $city->id }}"
                                  {{ isset($listing) && $listing->city && $listing->city->id == $city->id ? 'selected' : '' }}>
                                  {{ $city->city_name }}
                              </option>
                          @endforeach
                      </select>
                      @error('city_id')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>

              <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                  <div class="form-group">
                      <label class="mb-1"><h6>Business address <span class="text-danger">*</span></h6></label>
                      <input type="text" name="location" value="{{ $listing->location ?? old('location') }}"
                          class="form-control rounded" placeholder="i.e Derm tower Kijitonyama">
                      @error('location')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>

              <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                  <div class="form-group">
                      <label class="mb-1"><h6>Mobile Phone <span class="text-danger">*</span></h6></label>
                      <input type="text" name="phone" value="{{ $listing->phone ?? old('phone') }}"
                          class="form-control rounded" placeholder="Enter Phone Number +255">
                      @error('phone')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>

              <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                  <div class="form-group">
                      <label class="mb-1"><h6>Website</h6></label>
                      <input type="text" name="website" value="{{ $listing->website ?? old('website') }}"
                          class="form-control rounded" placeholder="start with https://">
                      @error('website')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                  <div class="form-group">
                      <label class="mb-1"><h6>Youtube Video Link (optional)</h6></label>
                      <input type="text" name="youtube_video_link"
                          value="{{ $listing->youtube_video_link ?? old('youtube_video_link') }}"
                          class="form-control rounded" placeholder="https://youtu.be/Auuk1y4DRgk?si=wPSYtdCcRbDy36FP">
                      @error('youtube_video_link')
                          <div class="text-danger">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              </div>
          </div>

          <div class="tab-navigation">
              <div></div>
              <button type="submit" class="btn theme-bg text-light">
                  Save & Continue <i class="fa fa-arrow-right ms-2"></i>
              </button>
          </div>
      </form>
  </div>
