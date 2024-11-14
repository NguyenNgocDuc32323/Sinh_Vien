@extends('layouts.master-admin')
@section('page_title')
    Create Ads
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
            <h1 class="fw-semibold mb-0 body-title">Create Ads</h1>
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
                        <form action="{{ route('create-ads-post') }}" method="POST" class="w-75 mx-auto" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class='text-danger-login'>{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Enter The Description" name="description"
                                style="min-height: 300px; width: 100%;">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class='text-danger-login'>{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="expired_at">Expired At</label>
                                <input type="datetime-local" name="expired_at" id="expired_at" class="form-control" value="{{ old('expired_at') }}">
                                @if ($errors->has('expired_at'))
                                    <span class='text-danger-login'>{{ $errors->first('expired_at') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($errors->has('image'))
                                    <span class='text-danger-login'>{{ $errors->first('image') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-update">Create Ads</button>
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
        //CK EDITOR
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    ckfinder: {
                        uploadUrl: '{{ route('upload-image') }}?_token=' + document.querySelector(
                            'meta[name="csrf-token"]').getAttribute('content'),
                    },
                    config: {
                        entities: false,
                        entities_processNumerical: false,
                    },
                    link: {
                        addTargetToExternalLinks: true
                    },
                })
                .then(editor => {
                    editor.plugins.get('ImageUpload').on('uploadSuccess', (evt, {
                        data: {
                            url
                        }
                    }) => {
                        console.log('Hình ảnh được tải lên thành công:', url);
                    });

                    editor.plugins.get('ImageUpload').on('uploadError', (error) => {
                        console.error('Lỗi khi tải lên hình ảnh:', error);
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi khởi tạo CKEditor:', error);
                });
        });
    </script>
@endpush
