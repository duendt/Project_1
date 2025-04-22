@extends('layouts.admin')
@section('title', 'Thêm tin tức mới')
@section('content')
<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/news' }}" class="btn btn-primary">Quay lại</a>
    @if (isset($_SESSION['message']))
    <div class="alert alert-success">
        {{ $_SESSION['message'] }}
        @php unset($_SESSION['message']); @endphp
    </div>
    @endif

    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {!! $_SESSION['error'] !!}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif

    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm tin tức mới</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/news/create' }}" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Lưu tin tức</button>
            </form>
        </div>
    </div>
</div>
@endsection