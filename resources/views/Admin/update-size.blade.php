@extends('layouts.master-admin')
@section('page_title')
    Update Size
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
            <h1 class="fw-semibold mb-0 body-title">Update Size</h1>
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
                        <form action="" method="POST" class="w-75 mx-auto">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$size->name}}">
                                @if ($errors->has('name'))
                                    <span class='text-danger-login'>{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="ratio_price">Ratio Price</label>
                                <input type="text" id="ratio_price" class="form-control" name="ratio_price" value="{{$size->ratio_price}}">
                                @if ($errors->has('ratio_price'))
                                    <span class='text-danger-login'>{{ $errors->first('ratio_price') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-update">Update Size</button>
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
