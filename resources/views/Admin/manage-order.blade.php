@extends('layouts.master-admin')
@section('page_title')
    Manage Order
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
            <h1 class="fw-semibold mb-0 body-title">Manager Order</h1>
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
                            <div></div>
                            <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{ route('order-search') }}">
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
                                                <tr>
                                                    <th class="sorting_order">Code</th>
                                                    <th class="sorting_order">User Name</th>
                                                    <th class="sorting_order">Shipping Method</th>
                                                    <th class="sorting_order mobile-d-none">Status</th>
                                                    <th class="sorting_order">Amount</th>
                                                    <th class="sorting_order mobile-d-none">Dishcount Amount</th>
                                                    <th class="sorting_order mobile-d-none">Shipping Amount</th>
                                                    <th class="sorting_order">Sub Total</th>
                                                    <th class="sorting_order mobile-d-none">Payment Method</th>
                                                    <th class="sorting_order mobile-d-none">Address</th>
                                                    <th class="sorting_order">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($orders)
                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td class="sorting_order_td fw-bold table-name">{{ $order->code }}</td>
                                                            <td class="sorting_order_td">{{ $order->username }}</td>
                                                            <td class="sorting_order_td">{{ $order->shipping_method }}</td>
                                                            <td class="sorting_order_td mobile-d-none">{{ $order->status }}</td>
                                                            <td class="sorting_order_td">{{ $order->amount }}$</td>
                                                            <td class="sorting_order_td mobile-d-none">{{ $order->discount_amount }}$</td>
                                                            <td class="sorting_order_td mobile-d-none">{{ $order->shipping_amount }}$</td>
                                                            <td class="sorting_order_td">{{ $order->sub_total }}$</td>
                                                            <td class="sorting_order_td mobile-d-none">{{ $order->payment_method }}</td>
                                                            <td class="sorting_order_td mobile-d-none">{{ $order->address }}</td>
                                                            <td class="text-right">
                                                                <a class="btn btn-update" href="{{route('update-order',$order->id)}}">
                                                                    Update
                                                                </a>
                                                                <a href="{{route('delete-order',$order->id)}}" class="btn btn-delete">
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                @endforeach
                                                @else
                                                        <tr>
                                                            <td colspan="12" style="padding: 1.5rem; font-size: 1.5rem;" class="text-success fw-bold">No order found.</td>
                                                        </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        @if ($orders)
                                            <div class="d-flex justify-content-end ml-2 paginate">
                                                {{ $orders->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
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
