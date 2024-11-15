@extends('layouts.master-admin')
@section('page_title')
    Create Product
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
            <h1 class="fw-semibold mb-0 body-title">Create Product</h1>
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
                        <form action="{{ route('create-product') }}" method="POST" enctype="multipart/form-data" class="w-75 mx-auto">
                            @csrf
                            <!-- Product Details -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class='text-danger-login'>{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
                                @if ($errors->has('price'))
                                    <span class='text-danger-login'>{{ $errors->first('price') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}">
                                @if ($errors->has('quantity'))
                                    <span class='text-danger-login'>{{ $errors->first('quantity') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class='text-danger-login'>{{ $errors->first('category_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="label_id">Label</label>
                                <select class="form-control" id="label_id" name="label_id">
                                    @foreach ($labels as $label)
                                        <option value="{{ $label->id }}">{{ $label->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('label_id'))
                                    <span class='text-danger-login'>{{ $errors->first('label_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="colors">Colors</label>
                                <div id="colors" class="d-flex align-items-center flex-wrap mt-3">
                                    @foreach ($colors as $color)
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="color_{{ $color->id }}" name="colors[]"
                                                value="{{ $color->id }}">
                                            <label class="form-check-label fw-bold" for="color_{{ $color->id }}">
                                                {{ $color->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($errors->has('colors'))
                                    <span class='text-danger-login'>{{ $errors->first('colors') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="sizes">Sizes</label>
                                <div id="sizes" class="d-flex align-items-center flex-wrap">
                                    @foreach ($sizes as $size)
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="size_{{ $size->id }}" name="sizes[]"
                                                value="{{ $size->id }}">
                                            <label class="form-check-label fw-bold" for="size_{{ $size->id }}">
                                                {{ $size->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($errors->has('sizes'))
                                    <span class='text-danger-login'>{{ $errors->first('sizes') }}</span>
                                @endif
                            </div>
                            <!-- Large Images -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="large_images">Large Images</label>
                                <div class="row">
                                    @for ($i = 0; $i < 2; $i++)
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                            <input type="file" class="form-control" name="large_images[]">
                                            @if ($errors->has("large_images.$i"))
                                                <span class='text-danger-login'>{{ $errors->first("large_images.$i") }}</span>
                                            @endif
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <!-- Small Images -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="small_images">Small Images</label>
                                <div id="small_images" class="d-flex flex-wrap row">
                                    @for ($i = 0; $i < 4; $i++)
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                            <input type="file" class="form-control" name="small_images[]">
                                            @if ($errors->has("small_images.$i"))
                                                <span class='text-danger-login'>{{ $errors->first("small_images.$i") }}</span>
                                            @endif
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-update-user badge btn-add-prd">Create Product</button>
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
