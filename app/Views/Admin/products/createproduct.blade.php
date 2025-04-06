@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')

<div class="container mt-5">
        <a href="{{ APP_URL . 'admin/products' }}" class="btn btn-primary">Quay lại</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Thêm sản phẩm mới</h6>
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Thương hiệu</label>
                    <select class="form-select" name="id_brand">
                        @foreach ($listBrand as $brand)
                        <option value="{{ $brand->id_brand }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Loại sản phẩm</label>
                    <select class="form-select" name="id_type">
                        @foreach ($listType as $type)
                        <option value="{{ $type->id_type }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bảo hành</label>
                    <input type="text" class="form-control" placeholder="Ví dụ: 12 tháng" name="warranty">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" rows="3" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
        </div>
    </div>
</div>
</div>
@endsection