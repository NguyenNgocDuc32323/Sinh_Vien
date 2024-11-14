@extends('layouts.master-admin')
@section('page_title')
    Manage Order Detail
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
            <h1 class="fw-semibold mb-0 body-title">Manager Order Detail</h1>
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
                            <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{ route('order-detail-search') }}">
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
                                                    <th class="sorting">Code</th>
                                                    <th class="sorting">Product Name</th>
                                                    <th class="sorting">Image</th>
                                                    <th class="sorting">Price</th>
                                                    <th class="sorting">Quantity</th>
                                                    <th class="sorting">Color</th>
                                                    <th class="sorting">Size</th>
                                                    <th class="sorting mobile-d-none">Created At</th>
                                                    <th class="sorting mobile-d-none">Updated At</th>
                                                    <th class="sorting">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($order_details)
                                                @foreach($order_details as $detail)
                                                    <tr>
                                                        <td class="sorting_1 fw-bold table-name">{{ $detail->code }}</td>
                                                        <td>{{ $detail->product_name }}</td>
                                                        <td>
                                                            <img src="{{ asset($detail->product_image) }}" alt="{{ $detail->product_name }}" width="100" height="100">
                                                        </td>
                                                        <td>${{ number_format($detail->price, 2) }}</td>
                                                        <td>{{ $detail->quantity }}</td>
                                                        <td>{{ $detail->color }}</td>
                                                        <td>{{ $detail->size }}</td>
                                                        <td class="mobile-d-none">{{ $detail->created_at->format('Y-m-d H:i:s') }}</td>
                                                        <td class="mobile-d-none">{{ $detail->updated_at->format('Y-m-d H:i:s') }}</td>
                                                        <td class="text-right">
                                                            <a class="btn btn-update" href="{{route('update-order-detail',$detail->code)}}">
                                                                Update
                                                            </a>
                                                            <a href="{{route('delete-order-detail',[$detail->code])}}" class="btn btn-delete">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="10" style="padding: 1.5rem; font-size: 1.5rem;" class="text-success fw-bold">No order detail found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        @if ($order_details)
                                            <div class="d-flex justify-content-end ml-2 paginate">
                                                {{ $order_details->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
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
