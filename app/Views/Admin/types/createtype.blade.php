@extends('layouts.admin')
@section('title', 'Thêm loại sản phẩm mới')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/types' }}" class="btn btn-primary">Quay lại</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Thêm loại sản phẩm mới</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/types/create' }}">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên loại sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <button type="submit" class="btn btn-primary">Lưu loại sản phẩm</button>
            </form>
        </div>
    </div>
</div>
@endsection