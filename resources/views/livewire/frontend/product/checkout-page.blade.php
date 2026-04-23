<div>
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-lg-4">
        @if (!$showPaymentIframe)
            <div class="row">

                <!-- ================= CHECKOUT DETAILS (LEFT / WHITE) ================= -->
                <div class="col-lg-8">

                    <!-- Shipping Address -->
                    <div class="mb-4">
                        <h2 class="h5 mb-3">Shipping Address</h2>

                        <div class="mb-3">
                            @if (count($shippingAddresses) > 0 && $showAddAddressForm)
                                <button wire:click="toggleAddAddressForm" class="btn btn-sm btn-outline-secondary">
                                    Cancel
                                </button>
                            @endif

                            @if (count($shippingAddresses) == 0 || (count($shippingAddresses) < 3 && !$showAddAddressForm))
                                <button wire:click="toggleAddAddressForm" class="btn btn-sm btn-primary">
                                    + Add New Address
                                </button>
                            @endif
                        </div>

                        {{-- Add Address Form --}}
                        @if ($showAddAddressForm)
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" wire:model="newAddress.contact_person_name"
                                        class="form-control">
                                    @error('newAddress.contact_person_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Mobile Phone</label>
                                    <input type="text" wire:model="newAddress.mobile_number" class="form-control">
                                    @error('newAddress.mobile_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Region</label>
                                    <select wire:model.live="newAddress.region_id" class="form-select">
                                        <option value="">Select region</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">District</label>
                                    <select wire:model.live="newAddress.district_id" class="form-select"
                                        {{ empty($districts) ? 'disabled' : '' }}>
                                        <option value="">Select district</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ward</label>
                                    <select wire:model="newAddress.ward_id" class="form-select"
                                        {{ empty($wards) ? 'disabled' : '' }}>
                                        <option value="">Select ward</option>
                                        @foreach ($wards as $ward)
                                            <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Street</label>
                                    <input type="text" wire:model="newAddress.street_name" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" wire:model="newAddress.postal_code" class="form-control">
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            wire:model="newAddress.is_default">
                                        <label class="form-check-label">Set as default</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button wire:click="saveNewAddress" class="btn btn-primary w-100">
                                        Save Address
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Existing Addresses --}}
                        @if (!$showAddAddressForm && count($shippingAddresses) > 0)
                            <div class="mt-3">
                                @foreach ($shippingAddresses as $address)
                                    <label
                                        class="d-block border rounded-3 p-3 mb-2 {{ $selectedAddressId == $address->id ? 'border-primary' : '' }}">
                                        <input type="radio" wire:model.live="selectedAddressId"
                                            value="{{ $address->id }}" class="me-2">
                                        <strong>
                                            {{ $address->ward->district->name }},
                                            {{ $address->ward->name }},
                                            {{ $address->street_name }}
                                        </strong>
                                        <div class="small text-muted">{{ $address->mobile_number }}</div>
                                        @if ($address->is_default)
                                            <span class="badge bg-success mt-1">Default</span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Shipping Method -->
                    <div class="mb-4">
                        <h2 class="h5 mb-3">Shipping Method</h2>
                        @foreach ($shippingZones as $zone)
                            <div class="form-check mb-2">
                                <input class="form-check-input" wire:model.live="selectedShippingZoneId" type="radio"
                                    value="{{ $zone->id }}">
                                <label class="form-check-label">
                                    {{ $zone->name }} — TZS {{ number_format($zone->cost, 2) }}
                                    ({{ $zone->estimated_days }} days)
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="accordion bg-body-tertiary rounded-5 p-4">
                        <div class="accordion-item border-0">
                            <h3 class="accordion-header" id="promoCodeHeading">
                                <button type="button" class="accordion-button animate-underline collapsed py-0"
                                    data-bs-toggle="collapse" data-bs-target="#promoCode">
                                    <i class="ci-percent fs-xl me-2"></i>
                                    <span class="animate-target me-2">Apply promo code</span>
                                </button>
                            </h3>

                            <div id="promoCode" class="accordion-collapse show">
                                <div class="accordion-body pt-3 pb-2">

                                    @if ($appliedCoupon)
                                        <div
                                            class="alert alert-success d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $appliedCoupon->code }}</strong>
                                                <span class="ms-2">
                                                    (
                                                    {{ $appliedCoupon->type === 'fixed'
                                                        ? 'TZS ' . number_format($appliedCoupon->discount_value, 2)
                                                        : $appliedCoupon->discount_value . '%' }}
                                                    off)
                                                </span>
                                            </div>
                                            <button wire:click="removeCoupon" class="btn btn-sm btn-outline-danger">
                                                Remove
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-flex gap-2">
                                            <input type="text" wire:model="couponCode" class="form-control"
                                                placeholder="Enter promo code">
                                            <button wire:click="applyCoupon" class="btn btn-dark">
                                                Apply
                                            </button>
                                        </div>
                                    @endif

                                    @if ($couponMessage)
                                        <div class="small mt-2 {{ $couponError ? 'text-danger' : 'text-success' }}">
                                            {{ $couponMessage }}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="mb-4">
                        <h2 class="h5 mb-3">Order Notes</h2>
                        <textarea wire:model="notes" rows="3" class="form-control" placeholder="Any special instructions?"></textarea>
                    </div>

                    <!-- Action -->
                    <button wire:click="placeOrder" class="btn btn-lg btn-primary w-100"
                        {{ empty($cartItems) ? 'disabled' : '' }}>
                        Proceed to Payment
                    </button>

                </div>

                <!-- ================= ORDER SUMMARY + COUPON (RIGHT / GREY) ================= -->
                <aside class="col-lg-4">
                    <div class="position-sticky top-0" style="padding-top: 1rem">

                        <!-- Order Summary -->
                        <div class="bg-body-tertiary rounded-5 p-4 mb-3">

                            <h2 class="h5 mb-3">Order Summary</h2>

                            <div style="max-height: 260px; overflow-y: auto">
                                @foreach ($cartItems as $item)
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <div class="pe-2">
                                            <div class="fw-medium fs-sm text-truncate">
                                                {{ $item['title'] }}
                                            </div>
                                            <div class="text-muted fs-xs">
                                                Qty: {{ $item['quantity'] }}
                                            </div>
                                        </div>
                                        <div class="fw-semibold fs-sm">
                                            TZS {{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fs-sm">Subtotal</span>
                                    <span class="fw-medium">TZS {{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fs-sm">Shipping</span>
                                    <span class="fw-medium">
                                        {{ $shippingCost > 0 ? 'TZS ' . number_format($shippingCost, 2) : 'Select shipping' }}
                                    </span>
                                </div>

                                @if ($discount > 0)
                                    <div class="d-flex justify-content-between text-success mb-2">
                                        <span class="fs-sm">Discount</span>
                                        <span class="fw-medium">
                                            - TZS {{ number_format($discount, 2) }}
                                        </span>
                                    </div>
                                @endif

                                <hr>

                                <div class="d-flex justify-content-between fs-5 fw-semibold">
                                    <span>Total</span>
                                    <span>TZS {{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Coupon (NEW TEMPLATE UI + OLD LOGIC) -->


                    </div>
                </aside>

            </div>
        @endif

        @if ($showPaymentIframe)
            <div class="row">
                <!-- ================= CHECKOUT DETAILS (LEFT / WHITE) ================= -->
                <div class="col-lg-8">

                        <h2 class="h5 mb-3">Payment page</h2>
                        <iframe src="{{ $redirect_url }}" height="600">
                        </iframe>

                </div>

                <!-- ================= ORDER SUMMARY + COUPON (RIGHT / GREY) ================= -->
                <aside class="col-lg-4">
                    <div class="position-sticky top-0" style="padding-top: 1rem">

                        <!-- Order Summary -->
                        <div class="bg-body-tertiary rounded-5 p-4 mb-3">

                            <h2 class="h5 mb-3">Order Summary</h2>

                            <div style="max-height: 260px; overflow-y: auto">
                                @foreach ($cartItems as $item)
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <div class="pe-2">
                                            <div class="fw-medium fs-sm text-truncate">
                                                {{ $item['title'] }}
                                            </div>
                                            <div class="text-muted fs-xs">
                                                Qty: {{ $item['quantity'] }}
                                            </div>
                                        </div>
                                        <div class="fw-semibold fs-sm">
                                            TZS {{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fs-sm">Subtotal</span>
                                    <span class="fw-medium">TZS {{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fs-sm">Shipping</span>
                                    <span class="fw-medium">
                                        {{ $shippingCost > 0 ? 'TZS ' . number_format($shippingCost, 2) : 'Select shipping' }}
                                    </span>
                                </div>

                                @if ($discount > 0)
                                    <div class="d-flex justify-content-between text-success mb-2">
                                        <span class="fs-sm">Discount</span>
                                        <span class="fw-medium">
                                            - TZS {{ number_format($discount, 2) }}
                                        </span>
                                    </div>
                                @endif

                                <hr>

                                <div class="d-flex justify-content-between fs-5 fw-semibold">
                                    <span>Total</span>
                                    <span>TZS {{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>
        @endif
    </section>


</div>
