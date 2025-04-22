@extends('layouts.admin')
@section('title', 'Chỉnh sửa tin tức')
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
            <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa tin tức</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/news/edit/' . $news->id }}" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $news->title }}">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="content" name="content" rows="8">{{ $news->content }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="text-muted">Chọn hình ảnh mới nếu muốn thay đổi, nếu không hình ảnh cũ sẽ được giữ lại</small>
                    @if (!empty($news->image))
                    <p class="form-label">Hình ảnh hiện tại:</p>
                        <div class="mt-2">
                            <img src="{{ APP_URL . 'public/images/' . $news->image }}" alt="Current Image" style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật tin tức</button>
            </form>
        </div>
    </div>
</div>
@endsection
