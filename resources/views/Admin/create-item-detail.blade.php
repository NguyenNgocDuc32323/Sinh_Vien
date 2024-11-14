@extends('layouts.master-admin')
@section('page_title')
    Create Detail Item
@endsection
@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.success('{{ session('success') }}');
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.error('{{ session('error') }}');
            });
        </script>
    @endif
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h1 class="fw-semibold mb-0 body-title">Create Detail Item</h1>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
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
                        <form action="{{ route('add-item-detail',$code) }}" method="POST" class="w-75 mx-auto">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="order_code">Order Code</label>
                                <input type="text" class="form-control" id="order_code" name="order_code" value="{{ $code }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="product_id">Product ID</label>
                                <input type="text" class="form-control" id="product_id" name="product_id" value="{{ old('product_id') }}">
                                @if ($errors->has('product_id'))
                                    <span class='text-danger-login'>{{ $errors->first('product_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}">
                                @if ($errors->has('product_name'))
                                    <span class='text-danger-login'>{{ $errors->first('product_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                                @if ($errors->has('quantity'))
                                    <span class='text-danger-login'>{{ $errors->first('quantity') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="color">Color</label>
                                <select class="form-control" id="color" name="color">
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->name }}" data-ratio-price="{{ $color->ratio_price }}"
                                            {{ old('color') == $color->name ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('color'))
                                    <span class='text-danger-login'>{{ $errors->first('color') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="size">Size</label>
                                <select class="form-control" id="size" name="size">
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->name }}" data-ratio-price="{{ $size->ratio_price }}"
                                            {{ old('size') == $size->name ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('size'))
                                    <span class='text-danger-login'>{{ $errors->first('size') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" readonly>
                                @if ($errors->has('price'))
                                    <span class='text-danger-login'>{{ $errors->first('price') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="total_price">Total Price</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" value="{{ old('total_price') }}" readonly>
                                @if ($errors->has('total_price'))
                                    <span class='text-danger-login'>{{ $errors->first('total_price') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-update">Add Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var inputs = document.querySelectorAll('input[type="text"], input[type="email"],input[type="password"],input[type="number"], textarea');
            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
                });
            });
        });
    </script>
@endpush
