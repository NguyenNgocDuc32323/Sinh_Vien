@extends('layouts.master-admin')
@section('page_title')
    Update Slide
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
            <h1 class="fw-semibold mb-0 body-title">Update Slide</h1>
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
                        <form action="{{route('update-slide-post',$slide->id)}}" method="POST" class="w-75 mx-auto" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $slide->name }}">
                                @if ($errors->has('name'))
                                    <span class='text-danger-login'>{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ $slide->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class='text-danger-login'>{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="images">Current Image</label>
                                <img src="{{ asset($slide->images) }}" alt="Slide Image" style="max-width: 100%;">
                                <input type="file" class="form-control mt-3" id="images" name="images">
                                @if ($errors->has('images'))
                                    <span class='text-danger-login'>{{ $errors->first('images') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3 mt-3">
                                <button type="submit" class="btn btn-update">Update slide</button>
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
</script>
@endpush
