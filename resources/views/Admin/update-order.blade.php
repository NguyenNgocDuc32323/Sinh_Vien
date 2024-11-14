@extends('layouts.master-admin')
@section('page_title')
    Update Order
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
            <h1 class="fw-semibold mb-0 body-title">Update Order</h1>
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
                        <form action="{{ route('update-order-post', $order->id) }}" method="POST" class="w-75 mx-auto" id="update-order-form">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="code">Code</label>
                                <input type="text" class="form-control mt-3" id="code" name="code" value="{{ $order->code }}" readonly>
                                @if ($errors->has('code'))
                                    <span class='text-danger'>{{ $errors->first('code') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="shipping_method">Shipping Method</label>
                                <select class="form-control mt-3" id="shipping_method" name="shipping_method">
                                    <option value="Standard Shipping" {{ $order->shipping_method == 'Standard Shipping' ? 'selected' : '' }}>Standard Shipping</option>
                                    <option value="Express Shipping" {{ $order->shipping_method == 'Express Shipping' ? 'selected' : '' }}>Express Shipping</option>
                                    <option value="Overnight Shipping" {{ $order->shipping_method == 'Overnight Shipping' ? 'selected' : '' }}>Overnight Shipping</option>
                                </select>
                                @if ($errors->has('shipping_method'))
                                    <span class='text-danger'>{{ $errors->first('shipping_method') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <input type="text" class="form-control mt-3" id="status" name="status" value="{{ $order->status }}">
                                @if ($errors->has('status'))
                                    <span class='text-danger'>{{ $errors->first('status') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="is_finished">Finished</label>
                                <select class="form-control mt-3" id="is_finished" name="is_finished">
                                    <option value="1" {{ $order->is_finished == 1 ? 'selected' : '' }}>Finished</option>
                                    <option value="0" {{ $order->is_finished == 0 ? 'selected' : '' }}>Unfinished</option>
                                </select>
                                @if ($errors->has('is_finished'))
                                    <span class='text-danger'>{{ $errors->first('is_finished') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="payment_id">Payment Method</label>
                                <select class="form-control" id="payment_id" name="payment_id">
                                    @foreach ($payments as $payment)
                                        <option value="{{ $payment->id }}" {{ $order->payment_id == $payment->id ? 'selected' : '' }}>
                                            {{ $payment->payment_method }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('payment_id'))
                                    <span class='text-danger'>{{ $errors->first('payment_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control mt-3" id="amount" name="amount" value="{{ $order->amount }}" readonly>
                                @if ($errors->has('amount'))
                                    <span class='text-danger'>{{ $errors->first('amount') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="discount_amount">Discount Amount</label>
                                <input type="text" class="form-control mt-3" id="discount_amount" name="discount_amount" value="{{ $order->discount_amount }}" readonly>
                                @if ($errors->has('discount_amount'))
                                    <span class='text-danger'>{{ $errors->first('discount_amount') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="shipping_amount">Shipping Amount</label>
                                <input type="text" class="form-control mt-3" id="shipping_amount" name="shipping_amount" value="{{ $order->shipping_amount }}" readonly>
                                @if ($errors->has('shipping_amount'))
                                    <span class='text-danger'>{{ $errors->first('shipping_amount') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="sub_total">Sub Total</label>
                                <input type="text" class="form-control mt-3" id="sub_total" name="sub_total" value="{{ $order->sub_total }}" readonly>
                                @if ($errors->has('sub_total'))
                                    <span class='text-danger'>{{ $errors->first('sub_total') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-update">Update Order</button>
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
        var inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], input[type="number"], textarea');
        inputs.forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const discountAmountInput = document.getElementById('discount_amount');
        const shippingAmountInput = document.getElementById('shipping_amount');
        const subTotalInput = document.getElementById('sub_total');

        function updateValues() {
            const amount = parseFloat(amountInput.value) || 0;
            let shippingAmount = 0;
            let discountAmount = 0;
            if (amount > 200) {
                shippingAmount = 0;
            } else if (amount > 100) {
                shippingAmount = amount * 0.05;
            } else {
                shippingAmount = amount * 0.1;
            }
            const baseAmountForDiscount = amount + shippingAmount;
            if (baseAmountForDiscount >= 200 && baseAmountForDiscount < 500) {
                discountAmount = baseAmountForDiscount * 0.05;
            } else if (baseAmountForDiscount >= 500 && baseAmountForDiscount < 1000) {
                discountAmount = baseAmountForDiscount * 0.1;
            } else if (baseAmountForDiscount >= 1000) {
                discountAmount = baseAmountForDiscount * 0.15;
            }

            const subTotal = amount + shippingAmount - discountAmount;

            shippingAmountInput.value = shippingAmount.toFixed(2);
            discountAmountInput.value = discountAmount.toFixed(2);
            subTotalInput.value = subTotal.toFixed(2);
        }

        amountInput.addEventListener('input', updateValues);
        updateValues();
    });
</script>
@endpush
