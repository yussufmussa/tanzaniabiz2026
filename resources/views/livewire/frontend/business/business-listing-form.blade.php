<div>
    
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" id="listingTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button wire:click="goToStep(1)" class="nav-link {{ $currentStep == 1 ? 'active' : '' }}"
                        type="button">
                        <span class="step-indicator">1</span> General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button wire:click="goToStep(2)"
                        class="nav-link {{ $currentStep == 2 ? 'active' : '' }} {{ !$listingId ? 'disabled' : '' }}"
                        type="button" {{ !$listingId ? 'disabled' : '' }}>
                        <span class="step-indicator">2</span> Business Photos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button wire:click="goToStep(3)"
                        class="nav-link {{ $currentStep == 3 ? 'active' : '' }} {{ !$listingId ? 'disabled' : '' }}"
                        type="button" {{ !$listingId ? 'disabled' : '' }}>
                        <span class="step-indicator">3</span> Products
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button wire:click="goToStep(4)"
                        class="nav-link {{ $currentStep == 4 ? 'active' : '' }} {{ !$listingId ? 'disabled' : '' }}"
                        type="button" {{ !$listingId ? 'disabled' : '' }}>
                        <span class="step-indicator">4</span> Extra Info
                    </button>
                </li>
            </ul>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tab Content -->
            <div class="tab-content mt-4">

                {{-- ==================== STEP 1: GENERAL INFO ==================== --}}
                @include('livewire.frontend.business.partials.general_tab')

                {{-- ==================== STEP 2: PHOTOS ==================== --}}
                @include('livewire.frontend.business.partials.photo_tab')

                {{-- ==================== STEP 3: PRODUCTS ==================== --}}
                @include('livewire.frontend.business.partials.product_tab')

                {{-- ==================== STEP 4: EXTRA INFO ==================== --}}
                @include('livewire.frontend.business.partials.extra_tab')

    </div>
</div>
