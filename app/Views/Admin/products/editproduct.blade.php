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
    <h1>Sửa sản phẩm</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Thương hiệu</label>
            <select name="id_brand" id="typeProduct" class="form-select" aria-label="Default select example">
                @foreach ($brands as $brand)
                <option value="{{ $brand->id_brand }}" @if ($product->id_brand == $brand->id_brand) selected @endif>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Loại sản phẩm</label>
            <select name="id_type" id="typeProduct" class="form-select" aria-label="Default select example">
                @foreach ($listType as $type)
                <option value="{{ $type->id_type }}" @if ($product->id_type == $type->id_type) selected @endif>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Bảo hành</label>
            <input type="text" name="warranty" class="form-control" value="{{ $product->warranty }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection