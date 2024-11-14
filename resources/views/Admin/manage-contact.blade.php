@extends('layouts.master-admin')
@section('page_title')
    Manage Contact
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
            <h1 class="fw-semibold mb-0 body-title">Manager Contact</h1>
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
                            <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{ route('contact-search') }}">
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
                                                    <th class="sorting">User Name</th>
                                                    <th class="sorting">Email</th>
                                                    <th class="sorting">Phone</th>
                                                    <th class="sorting">Title</th>
                                                    <th class="sorting">Status</th>
                                                    <th class="sorting mobile-d-none">Created At</th>
                                                    <th class="sorting mobile-d-none">Updated At</th>
                                                    <th class="sorting">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="category-table-body">
                                                @if ($contacts->count() > 0)
                                                    @foreach ($contacts as $contact)
                                                        <tr class="odd">
                                                            <td class="sorting_1">{{$contact->id }}</td>
                                                            <td class="sorting_1  fw-bold table-name">{{$contact->name }}</td>
                                                            <td class="sorting_1">{{$contact->email }}</td>
                                                            <td class="sorting_1">{{$contact->phone }}</td>
                                                            <td class="sorting_1">{{$contact->title }}</td>
                                                            <td class="sorting_1">{{$contact->status}}</td>
                                                            <td class="sorting_1 mobile-d-none">{{$contact->created_at}}</td>
                                                            <td class="sorting_1 mobile-d-none">{{$contact->updated_at}}</td>
                                                            <td class="text-right">
                                                                <div class="btn-group d-flex justify-content-center align-items-center">
                                                                    <a class="btn btn-update" href="{{route('contact-reply',$contact->id)}}">Reply</a>
                                                                    <a href="{{route('delete-contact',$contact->id)}}" class="btn btn-delete">Delete</a>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="10" style="padding: 1.5rem; font-size: 1.5rem;" class="text-success fw-bold">No contact found.</td>
                                                    </tr>
                                                    @endif
                                            </tbody>
                                        </table>
                                        @if ($contacts)
                                            <div class="d-flex justify-content-end ml-2 paginate">
                                                {{ $contacts->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
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
