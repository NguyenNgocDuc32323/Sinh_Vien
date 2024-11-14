@extends('layouts.master-admin')
@section('page_title')
    Manage Transaction
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
            <h1 class="fw-semibold mb-0 body-title">Manager Transaction</h1>
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
                            </div>
                            <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{ route('transaction-search') }}">
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
                                                    <th class="sorting">ID</th>
                                                    <th class="sorting">Code</th>
                                                    <th class="sorting">User Name</th>
                                                    <th class="sorting">Amount</th>
                                                    <th class="sorting">Payment Method</th>
                                                    <th class="sorting">Status</th>
                                                    <th class="sorting">Description</th>
                                                    <th class="sorting">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="category-table-body">
                                                @if ($transactions->count() > 0)
                                                    @foreach ($transactions as $transaction)
                                                        <tr>
                                                            <td class="sorting_1">{{ $transaction->id }}</td>
                                                            <td class="fw-bold table-name">{{ $transaction->code }}</td>
                                                            <td>{{ $transaction->username}}</td>
                                                            <td>{{ number_format($transaction->amount, 2) }}$</td>
                                                            <td>{{ $transaction->payment_method }}</td>
                                                            <td>{{ $transaction->status }}</td>
                                                            <td>{{ $transaction->description }}</td>
                                                            <td class="text-right">
                                                                @if ($transaction->admin_check == 0)
                                                                    <a class="btn btn-confirm" href="{{route('confirm-transaction',$transaction->id)}}">
                                                                        Confirm
                                                                    </a>
                                                                @elseif ($transaction->admin_check == 1)
                                                                    <a class="btn btn-delete" href="{{route('delete-transaction',$transaction->id)}}">
                                                                        Delete
                                                                    </a>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" style="padding: 1.5rem; font-size: 1.5rem;" class="text-success fw-bold">No transactions found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>

                                        @if ($transactions)
                                            <div class="d-flex justify-content-end ml-2 paginate">
                                                {{ $transactions->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
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
