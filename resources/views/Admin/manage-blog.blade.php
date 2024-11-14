@extends('layouts.master-admin')
@section('page_title')
    Manage Blog
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
            <h1 class="fw-semibold mb-0 body-title">Manage Blog</h1>
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
                                <a href="{{route('create-blog')}}" class="btn btn-primary btn-add-prd">
                                    <i class="fa-solid fa-plus"></i> Create New blog
                                </a>
                            </div>
                            <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{route('blog-search')}}">
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
                                                    <th class="sorting">Name</th>
                                                    <th class="sorting">Title</th>
                                                    <th class="sorting">Image</th>
                                                    <th class="sorting">Category ID</th>
                                                    <th class="sorting">Created At</th>
                                                    <th class="sorting">Updated At</th>
                                                    <th class="sorting">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="category-table-body">
                                                @if ($blogs->count() > 0)
                                                    @foreach ($blogs as $blog)
                                                        <tr>
                                                            <td class="sorting_1">{{$blog->id}}</td>
                                                            <td class="fw-bold table-name">{{$blog->name}}</td>
                                                            <td class="sorting_1">{{$blog->title}}</td>
                                                            <td class="sorting_1">
                                                                <img src="{{asset($blog->image)}}" alt="Blog Image" class="img-fluid" style="width: 100px;height: 100px;">
                                                            </td>
                                                            <td class="sorting_1">{{$blog->category_id}}</td>
                                                            <td class="sorting_1">{{$blog->created_at}}</td>
                                                            <td class="sorting_1">{{$blog->updated_at}}</td>
                                                            <td class="text-right">
                                                                <a class="btn btn-update" href="{{route('update-blog',$blog->id)}}">
                                                                    Update
                                                                </a>
                                                                <a href="{{route('delete-blog',$blog->id)}}" class="btn btn-delete">
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" style="padding: 1.5rem; font-size: 1.5rem;" class="text-success fw-bold">No blog found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        @if ($blogs)
                                            <div class="d-flex justify-content-end ml-2 paginate">
                                                {{ $blogs->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
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
