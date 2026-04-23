<div>

    <div class="dropdn dropdn_fullheight minicart">
        <a href="/cart" class="dropdn-link js-dropdn-link minicart-link only-icon" data-panel="#dropdnMinicart">
            <i class="icon-basket"></i>
            <span class="minicart-qty">
                @if ($cartCount > 0)
                    {{ $cartCount }}
                @else
                    0
                @endif
            </span>
            <span class="minicart-total hide-mobile">Tsh {{ number_format($cartTotal,2) }}</span>
        </a>
    </div>

</div>
