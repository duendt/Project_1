@extends('layouts.admin')
@section('title', 'Thêm màu sắc mới')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/colors' }}" class="btn btn-primary">Quay lại</a>
    @if (isset($_SESSION['message']))
    <div class="alert alert-success">
        {{ $_SESSION['message'] }}
        @php unset($_SESSION['message']); @endphp
    </div>
    @endif

    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {{ $_SESSION['error'] }}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif

    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm màu sắc mới</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/colors/create' }}">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên màu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <button type="submit" class="btn btn-primary">Lưu màu sắc</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Liên kết color picker với input
    document.getElementById('color_picker').addEventListener('input', function() {
        // Bỏ ký tự # từ mã màu
        document.getElementById('color_code').value = this.value.substring(1);
    });
    
    // Cập nhật color picker từ input
    document.getElementById('color_code').addEventListener('input', function() {
        document.getElementById('color_picker').value = '#' + this.value;
    });
</script>
@endsection