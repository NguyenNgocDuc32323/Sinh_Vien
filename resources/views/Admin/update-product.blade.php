@extends('layouts.master-admin')
@section('page_title')
    Update Product
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
            <h1 class="fw-semibold mb-0 body-title">Update Product</h1>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>
                <li><span>-</span></li>
                <li class="fw-medium"><span>product</span></li>
            </ul>
        </div>
        <div class="row justify-content-center align-items-center manage-block">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="update-tab" data-bs-toggle="tab" href="#update"
                                    role="tab" aria-controls="update" aria-selected="true">Update Details</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="image-tab" data-bs-toggle="tab" href="#image" role="tab"
                                    aria-controls="image" aria-selected="false">Change Image</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!-- Update Details Tab -->
                            <div class="tab-pane fade show active" id="update" role="tabpanel"
                                aria-labelledby="update-tab">
                                <form action="{{ route('update-product-detail', $product->id) }}" method="POST" class="w-75 mx-auto">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $product->name }}">
                                        @if ($errors->has('name'))
                                            <span class='text-danger-login'>{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="price">Price</label>
                                        <input type="text" class="form-control" id="price" name="price"
                                            value="{{ $product->price }}">
                                        @if ($errors->has('price'))
                                            <span class='text-danger-login'>{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="quantity">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            value="{{ $product->quantity }}">
                                        @if ($errors->has('quantity'))
                                            <span class='text-danger-login'>{{ $errors->first('quantity') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="category_id">Category</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
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
                                                <option value="{{ $label->id }}"
                                                    {{ $label->id == $product->label_id ? 'selected' : '' }}>
                                                    {{ $label->name }}
                                                </option>
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
                                                        value="{{ $color->id }}"
                                                        @if (in_array($color->id, $product->colors->pluck('id')->toArray())) checked @endif>
                                                    <p class="form-check-label fw-bold" for="color_{{ $color->id }}">
                                                        {{ $color->name }}
                                                    </p>
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
                                                        value="{{ $size->id }}"
                                                        @if (in_array($size->id, $product->sizes->pluck('id')->toArray())) checked @endif>
                                                    <p class="form-check-label fw-bold" for="size_{{ $size->id }}">
                                                        {{ $size->name }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($errors->has('sizes'))
                                            <span class='text-danger-login'>{{ $errors->first('sizes') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-update">Update Details</button>
                                    </div>
                                </form>
                            </div>
                            <!-- Change Image Tab -->
                            <div class="tab-pane fade update-image" id="image" role="tabpanel" aria-labelledby="image-tab">
                                <form action="{{ route('update-product-images', $product->id) }}" method="POST" enctype="multipart/form-data" class="w-75 mx-auto">
                                    @csrf

                                    <!-- Large Images -->
                                    <div class="form-group mb-3 update-large-image">
                                        <div class="row large-image-update">
                                            <div class="row">
                                                <!-- Large Image 1 -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                    <label class="form-label" for="large-image-1">Large Image 1</label>
                                                    @if (!empty($product->image[0]))
                                                        <div class="d-flex align-items-center mb-3">
                                                            <img src="{{ asset($product->image[0]) }}" alt="large Image 1" class="large-product-image">
                                                        </div>
                                                    @else
                                                        <p>No large image 1</p>
                                                    @endif
                                                    <input type="file" class="form-control mt-3" id="large-image-1" name="large_images[0]">
                                                    @if ($errors->has('large_images.0'))
                                                        <span class='text-danger-login'>{{ $errors->first('large_images.0') }}</span>
                                                    @endif
                                                </div>
                                                <!-- Large Image 2 -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                                                    <label class="form-label" for="large-image-2">Large Image 2</label>
                                                    @if (!empty($product->image[1]))
                                                        <div class="d-flex align-items-center mb-3">
                                                            <img src="{{ asset($product->image[1]) }}" alt="Large Image 2" class="large-product-image">
                                                        </div>
                                                    @else
                                                        <p>No large image 2</p>
                                                    @endif
                                                    <input type="file" class="form-control mt-3" id="large-image-2" name="large_images[1]">
                                                    @if ($errors->has('large_images.1'))
                                                        <span class='text-danger-login'>{{ $errors->first('large_images.1') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Small Images -->
                                    <div class="form-group mb-3 mt-5 update-small-image">
                                        <div id="small_images" class="row">
                                            @foreach ($product->images as $index => $image)
                                                <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-3">
                                                    <label class="form-label" for="small_images">Small Images {{$index+1}}</label>
                                                    <div class="small-image-container">
                                                        @if (!empty($image))
                                                            <div class="d-flex align-items-center mb-3">
                                                                <img src="{{ asset($image) }}" alt="Small Image {{ $index + 1 }}" class="small-product-image">
                                                            </div>
                                                        @else
                                                            <p>No small image {{ $index + 1 }}</p>
                                                        @endif
                                                        <input type="file" class="form-control mt-2" name="small_images[{{ $index }}]">
                                                        <input type="hidden" name="existing_images[{{ $index }}]" value="{{ $image }}">
                                                        @if ($errors->has("small_images.$index"))
                                                            <span class='text-danger-login'>{{ $errors->first("small_images.$index") }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($errors->has('small_images'))
                                            <span class='text-danger-login'>{{ $errors->first('small_images') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-update">Update Images</button>
                                    </div>
                                </form>

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
