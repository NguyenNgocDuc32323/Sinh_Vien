@php
    $currentRouteName = Route::currentRouteName();
    $currentRouteDisplay = ucfirst(str_replace(['-', '.'], ' ', $currentRouteName));
@endphp
@include('Layouts.header')
<div class="layout-container">
    @include('Layouts.navbar')
    <div class="banner d-flex align-items-center justify-content-center"
        style="background-image: url({{ asset('images/Dashboard/banner_shop_4.webp') }})">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>
                    @if (strpos($currentRouteName, 'shop') !== false)
                        Shop
                    @else
                        {{ $currentRouteDisplay }}
                    @endif
                </h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item breadcrumb-route">
                            {{ $currentRouteDisplay }}
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="shop-layout">
        <div class="row">
            <div class="col-lg-3">
                @include('layouts.sidebar')
            </div>
            <div class="col collection-content">
                @include('layouts.main')
            </div>
        </div>
    </div>
</div>
@include('Layouts.footer')
