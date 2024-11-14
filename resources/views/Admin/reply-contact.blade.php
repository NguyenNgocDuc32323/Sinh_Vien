@extends('layouts.master-admin')
@section('page_title')
    Admin Reply Contact
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
            <h1 class="fw-semibold mb-0 body-title">Reply Contact</h1>
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
                        <form action="{{route('contact-reply',$contact->id)}}" method="POST" class="w-75 mx-auto">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="user_name">User Name</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $contact->name }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $contact->email }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $contact->title }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="content">Content</label>
                                <textarea class="form-control content" name="content" id="reply" readonly style="height: 300px;">{{ $contact->content }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content">Response</label>
                                <textarea class="form-control" id="content" placeholder="Enter The Response" name="content"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-update">Reply Contact</button>
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
    //Content
    document.addEventListener('DOMContentLoaded', function() {
    ClassicEditor
        .create(document.querySelector('#reply'), {
            ckfinder: {
                uploadUrl: '{{ route('admin-upload-image') }}?_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            config: {
                entities: false,
                entities_processNumerical: false,
                link: {
                    addTargetToExternalLinks: true
                }
            }
        })
        .then(editor => {
            editor.plugins.get('ImageUpload').on('uploadSuccess', (evt, { data: { url } }) => {
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
    //CK EDITOR Reply
    document.addEventListener('DOMContentLoaded', function() {
    ClassicEditor
        .create(document.querySelector('#content'), {
            ckfinder: {
                uploadUrl: '{{ route('admin-upload-image') }}?_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            config: {
                entities: false,
                entities_processNumerical: false,
                link: {
                    addTargetToExternalLinks: true
                }
            }
        })
        .then(editor => {
            editor.plugins.get('ImageUpload').on('uploadSuccess', (evt, { data: { url } }) => {
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
