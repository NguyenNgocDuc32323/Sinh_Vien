@extends('layouts.master-admin')
@section('page_title')
    Update Order Detail
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
            <h1 class="fw-semibold mb-0 body-title">Update Order Detail</h1>
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
                        <form action="{{ route('update-order-detail', $code) }}" method="POST" class="w-75 mx-auto">
                            @csrf
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Product Name</th>
                                        <th>Product Quantity</th>
                                        <th>Product Color</th>
                                        <th>Product Size</th>
                                        <th>Product Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_detail as $index => $detail)
                                        <tr data-index="{{ $index }}">
                                            <td class="d-none">
                                                <input type="text" value="{{$detail->product_id}}" name="product_id[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="order_code"
                                                    value="{{ $detail->order_code }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="prd_name[]"
                                                    value="{{ $detail->product_name }}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="prd_qty[]"
                                                    data-index="{{ $index }}" value="{{ $detail->quantity }}" required>
                                            </td>
                                            <td>
                                                <select class="color-select form-control" data-index="{{ $index }}"
                                                    data-base-price="{{ $detail->price }}" name="prd_color[]">
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->name }}"
                                                            data-ratio-price="{{ $color->ratio_price }}"
                                                            {{ $color->name == $detail->color ? 'selected' : '' }}>
                                                            {{ $color->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="size-select form-control" data-index="{{ $index }}"
                                                    name="prd_size[]">
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->name }}"
                                                            data-ratio-price="{{ $size->ratio_price }}"
                                                            {{ $size->name == $detail->size ? 'selected' : '' }}>
                                                            {{ $size->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control product-price"
                                                    data-index="{{ $index }}" value="{{ $detail->price }}" readonly
                                                    name="product_price[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control total-price"
                                                    data-index="{{ $index }}"
                                                    value="{{ $detail->price * $detail->quantity }}" readonly
                                                    name="total_price[]">
                                            </td>
                                            <td class="text-right">
                                                <a href="{{route('delete-item-detail',$detail->product_id)}}" class="btn btn-delete">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-update">Update Order Detail</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            var inputs = document.querySelectorAll(
                'input[type="text"], input[type="email"], input[type="password"], input[type="number"], textarea'
            );
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
                });
            });
        });
        document.querySelectorAll('.color-select, .size-select, input[name="prd_qty[]"]').forEach(function(element) {
            element.addEventListener('input', function() {
                var index = this.getAttribute('data-index');
                var basePrice = parseFloat(document.querySelector(`.color-select[data-index="${index}"]`).getAttribute('data-base-price'));
                var quantity = parseInt(document.querySelector(`input[name="prd_qty[]"][data-index="${index}"]`).value) || 0;
                var colorPrice = parseFloat(document.querySelector(`.color-select[data-index="${index}"]`).selectedOptions[0].getAttribute('data-ratio-price')) || 0;
                var sizePrice = parseFloat(document.querySelector(`.size-select[data-index="${index}"]`).selectedOptions[0].getAttribute('data-ratio-price')) || 0;
                var productPrice = basePrice + colorPrice + sizePrice || 0;
                var totalPrice = productPrice * quantity || 0;
                document.querySelector(`.product-price[data-index="${index}"]`).value = productPrice.toFixed(2);
                document.querySelector(`.total-price[data-index="${index}"]`).value = totalPrice.toFixed(2);
            });
        });
    </script>
@endpush
