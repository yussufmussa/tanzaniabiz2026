<div>

    <!-- Breadcrumb -->
<nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cart</li>
    </ol>
</nav>

<section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
    <h1 class="h3 mb-4">Shopping Cart</h1>

    @if(count($cart) > 0)
        <div class="row">

            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="pe-lg-2 pe-xl-3 me-xl-3">

                    <table class="table position-relative z-2 mb-4">
                        <thead>
                        <tr>
                            <th class="fs-sm fw-normal py-3 ps-0">Product</th>
                            <th class="fs-sm fw-normal py-3 d-none d-xl-table-cell">Price</th>
                            <th class="fs-sm fw-normal py-3 d-none d-md-table-cell">Quantity</th>
                            <th class="fs-sm fw-normal py-3 d-none d-md-table-cell">Total</th>
                            <th class="py-0 px-0 text-end">
                                <button wire:click="clearCart"
                                        type="button"
                                        class="nav-link text-decoration-underline py-3 px-0">
                                    Clear cart
                                </button>
                            </th>
                        </tr>
                        </thead>

                        <tbody class="align-middle">
                        @foreach($cart as $productId => $product)
                            <tr>
                                <!-- Product -->
                                <td class="py-3 ps-0">
                                    <div class="d-flex align-items-center">
                                        <a class="flex-shrink-0" href="#">
                                            <img src="{{ asset('uploads/products/thumbnails/'.$product['thumbnail']) }}"
                                                 width="110"
                                                 alt="{{ $product['title'] }}">
                                        </a>
                                        <div class="w-100 min-w-0 ps-2 ps-xl-3">
                                            <h5 class="mb-2 fs-sm fw-medium text-truncate">
                                                {{ $product['title'] }}
                                            </h5>

                                            <!-- Mobile qty -->
                                            <div class="count-input rounded-2 d-md-none mt-3">
                                                <button class="btn btn-sm btn-icon"
                                                        wire:click="updateQuantity({{ $productId }}, {{ $product['quantity'] - 1 }})">
                                                    <i class="ci-minus"></i>
                                                </button>
                                                <input type="number"
                                                       class="form-control form-control-sm"
                                                       value="{{ $product['quantity'] }}"
                                                       readonly>
                                                <button class="btn btn-sm btn-icon"
                                                        wire:click="updateQuantity({{ $productId }}, {{ $product['quantity'] + 1 }})">
                                                    <i class="ci-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Price -->
                                <td class="h6 py-3 d-none d-xl-table-cell">
                                    Tsh {{ number_format($product['price']) }}
                                </td>

                                <!-- Quantity -->
                                <td class="py-3 d-none d-md-table-cell">
                                    <div class="count-input">
                                        <button class="btn btn-icon"
                                                wire:click="updateQuantity({{ $productId }}, {{ $product['quantity'] - 1 }})">
                                            <i class="ci-minus"></i>
                                        </button>
                                        <input type="number"
                                               class="form-control"
                                               value="{{ $product['quantity'] }}"
                                               readonly>
                                        <button class="btn btn-icon"
                                                wire:click="updateQuantity({{ $productId }}, {{ $product['quantity'] + 1 }})">
                                            <i class="ci-plus"></i>
                                        </button>
                                    </div>
                                </td>

                                <!-- Total -->
                                <td class="h6 py-3 d-none d-md-table-cell">
                                    Tsh {{ number_format($product['price'] * $product['quantity'], 2) }}
                                </td>

                                <!-- Remove -->
                                <td class="text-end py-3 px-0">
                                    <button wire:click="removeItem({{ $productId }})"
                                            type="button"
                                            class="btn-close fs-sm"
                                            aria-label="Remove">
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <a class="nav-link animate-underline px-0" href="/products">
                        <i class="ci-chevron-left fs-lg me-1"></i>
                        Continue shopping
                    </a>
                </div>
            </div>

            <!-- Cart Total -->
            <div class="col-lg-4">
                <div class="bg-body-tertiary rounded-4 p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fs-sm">Subtotal</span>
                        <span class="h5 mb-0">
                            Tsh {{ number_format($total, 2) }}
                        </span>
                    </div>

                    <a href="{{ route('checkout') }}"
                       class="btn btn-lg btn-primary w-100">
                        Proceed to checkout
                        <i class="ci-chevron-right fs-lg ms-1"></i>
                    </a>
                </div>
            </div>

        </div>
    @else
        <!-- Empty cart -->
        <div class="text-center py-5">
            <i class="ci-shopping-cart fs-1 text-muted mb-3"></i>
            <h5>Your cart is empty</h5>
            <a href="/products" class="btn btn-primary mt-3">
                Browse products
            </a>
        </div>
    @endif
</section>

</div>
