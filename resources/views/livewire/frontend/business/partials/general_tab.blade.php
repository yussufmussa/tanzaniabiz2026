@if ($currentStep == 1)
    <div class="tab-pane fade show active">

        <div wire:loading.flex wire:target="saveGeneral"
            class="position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center"
            style="background: rgba(255,255,255,0.7); z-index: 9999;">

            <div class="text-center">
                <img src="{{ asset('uploads/general/loading.gif') }}" alt="Saving..." style="width:80px;">
                <p class="mt-2 mb-0">Saving...</p>
            </div>
        </div>

        <form wire:submit.prevent="saveGeneral">
            <h5 class="mb-3">Business Information</h5>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Business Name <span class="text-danger">*</span></h6>
                        </label>
                        <input type="text" wire:model="name"
                            class="form-control rounded @error('name') is-invalid @enderror"
                            placeholder="Enter Your Business Name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Business Categories <span class="text-danger">*</span></h6>
                        </label>
                        <select wire:model.live="category_id"
                            class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div wire:loading>
                    <img src="{{ asset('uploads/general/loading.gif') }}" alt="Loading..." />
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Business Sub Categories (<small>select up to 5</small>)
                                <span class="text-danger">*</span>
                            </h6>
                        </label>

                        <select wire:model="subcategory_id" id="subcategory_id"
                            class="form-control @error('subcategory_id') is-invalid @enderror" multiple size="5"
                            {{ !$category_id ? 'disabled' : '' }}>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>

                        @if (!$category_id)
                            <small class="text-muted">Select a category first.</small>
                        @else
                            <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple</small>
                        @endif

                        @error('subcategory_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="mb-4">
                    <h6>Business Logo <span class="text-danger">*</span></h6>

                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="img-thumbnail mb-3"
                            width="200" height="200">
                    @elseif ($existingLogo)
                        <img src="{{ asset('uploads/businessListings/logos/' . $existingLogo) }}" alt="Business Logo"
                            class="img-thumbnail mb-3" width="200" height="200">
                    @else
                        <img src="{{ asset('uploads/general/logo_placeholder.png') }}" alt="Logo Placeholder"
                            class="img-thumbnail mb-3" width="200" height="200">
                    @endif

                    <div class="form-group">
                        <input type="file" wire:model="logo"
                            class="form-control rounded @error('logo') is-invalid @enderror" accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="text-danger">Maximum size 2Mb</span>

                        <div wire:loading wire:target="logo" class="text-muted mt-2">
                            Uploading logo...
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Business description <span class="text-danger">*</span></h6>
                        </label>
                        <textarea wire:model="description" class="form-control rounded ht-150 @error('description') is-invalid @enderror"
                            placeholder="Enter business description" rows="4"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>City<span class="text-danger">*</span></h6>
                        </label>
                        <select wire:model="city_id" class="form-control @error('city_id') is-invalid @enderror">
                            <option value="">-- Select City --</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Business address <span class="text-danger">*</span></h6>
                        </label>
                        <input type="text" wire:model="location"
                            class="form-control rounded @error('location') is-invalid @enderror"
                            placeholder="i.e Derm tower Kijitonyama">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Business Email <span class="text-danger">*</span></h6>
                        </label>
                        <input type="email" wire:model="email"
                            class="form-control rounded @error('email') is-invalid @enderror"
                            placeholder="your email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Mobile Phone <span class="text-danger">*</span></h6>
                        </label>
                        <input type="text" wire:model="phone"
                            class="form-control rounded @error('phone') is-invalid @enderror"
                            placeholder="Enter Phone Number 0777549996">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Website</h6>
                        </label>
                        <input type="url" wire:model="website"
                            class="form-control rounded @error('website') is-invalid @enderror"
                            placeholder="start with https://">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6>Youtube Video Link (optional)</h6>
                        </label>
                        <input type="url" wire:model="youtube_video_link"
                            class="form-control rounded @error('youtube_video_link') is-invalid @enderror"
                            placeholder="https://youtu.be/...">
                        @error('youtube_video_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="tab-navigation mt-4">
                <div></div>
                <button type="submit" class="btn theme-bg text-light" wire:loading.attr="disabled">
                    <span wire:loading.remove
                        wire:target="saveGeneral">{{ $mode == 'create' ? 'Save & Continue' : 'Update & Continue' }} <i
                            class="fa fa-arrow-right ms-2"></i></span>
                    <span wire:loading wire:target="saveGeneral">Saving...</span>
                </button>
            </div>
        </form>
    </div>
@endif
