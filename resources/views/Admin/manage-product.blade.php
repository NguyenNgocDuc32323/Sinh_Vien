@extends('layouts.master-admin')
@section('page_title')
    Manage Product
@endsection
@section('content')
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.success('{{ session('success') }}');
        });
    </script>
    @endif
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.error('{{ session('error') }}');
        });
    </script>
@endif
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h1 class="fw-semibold mb-0 body-title">Manager product</h1>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{route('home')}}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>
                <li><span>-</span></li>
                <li class="fw-medium"><span>User</span></li>
            </ul>
        </div>
        <div class="row justify-content-center align-items-center manage-block">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 card-body-item">
                            <div>
                                <a href="{{route('create-product')}}" class="btn btn-primary btn-add-prd">
                                    <i class="fa-solid fa-plus"></i> Create New Product
                                </a>
                            </div>
                            <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{ route('product-search') }}">
                                @csrf
                                <input type="text" id="search-input" name="search-input" class="form-control" placeholder="Search">
                                <button type="submit" class="btn-search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="order-listing" class="table dataTable no-footer">
                                            <thead>
                                                <tr class="bg-primary text-white">
                                                    <th class="sorting">Avatar</th>
                                                    <th class="sorting">Name</th>
                                                    <th class="sorting">Price</th>
                                                    <th class="sorting">Inventory</th>
                                                    <th class="sorting">Color/Ratio</th>
                                                    <th class="sorting">Size/Ratio</th>
                                                    <th class="sorting">Label</th>
                                                    <th class="sorting mobile-d-none">Category</th>
                                                    <th class="sorting">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="product-table-body">
                                                @if ($products->count() > 0)
                                                    @foreach ($products as $product)
                                                        <tr class="odd">
                                                            <td class="sorting_1">
                                                                <img src="{{asset($product->image[0])}}" class="img-fluid product-img">
                                                            </td>
                                                            <td class="fw-bold table-name">{{ $product->name }}</td>
                                                            <td>{{ $product->price }}$</td>
                                                            <td>{{$product->quantity}}</td>
                                                            <td>
                                                                @php
                                                                    $colorNames = explode(',', $product->color_names);
                                                                    $colorPrices = explode(',', $product->color_prices);
                                                                @endphp
                                                                @foreach ($colorNames as $index => $color)
                                                                    {{ $color }} - {{ $colorPrices[$index] }}<br>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $sizeNames = explode(',', $product->size_names);
                                                                    $sizePrices = explode(',', $product->size_prices);
                                                                @endphp
                                                                @foreach ($sizeNames as $index => $size)
                                                                    {{ $size }} - {{ $sizePrices[$index] }}<br>
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $product->label_name }}</td>
                                                            <td class="mobile-d-none">{{$product->category_name}} Bottles</td>
                                                            <td class="text-right">
                                                                <a class="btn btn-update" href="{{ route('update-product', [$product->id]) }}">
                                                                    Update
                                                                </a>
                                                                <a href="{{ route('delete-product', [$product->id]) }}" class="btn btn-delete">
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="11" style="padding: 1.5rem; font-size: 1.5rem;" class="text-success fw-bold">No product found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        @if ($products)
                                            <div class="d-flex justify-content-end ml-2 paginate">
                                                {{ $products->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
<script>
</script>
@endpush
