@extends('layouts.admin')
@section('title', 'Cập nhật thương hiệu')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/brands' }}" class="btn btn-primary">Quay lại</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Cập nhật thương hiệu</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/brands/edit/' . $brand->id_brand }}">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $brand->name }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $brand->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>

@endsection