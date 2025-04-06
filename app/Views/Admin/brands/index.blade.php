@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý thương hiệu</h2>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/products' }}">Sản phẩm</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/variants' }}">Phiên bản</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="{{ APP_URL . 'admin/brands' }}">Thương hiệu</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/types' }}">Loại sản phẩm</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/colors' }}">Màu sắc</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/storages' }}">Dung lượng</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/configs' }}">Cấu hình</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-body">
            <a href="{{ APP_URL . 'admin/brands/create'}}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-lg"></i> Thêm thương hiệu
            </a>
            @if (isset($_SESSION['confim']))
                <div class="alert alert-success">
                    {{ $_SESSION['confim'] }}
                    @php unset($_SESSION['confim']); @endphp
                </div>
                @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên thương hiệu</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listBrand as $brand)
                        <tr>
                            <td>{{ $brand->id_brand }}</td>
                            <td>{{ $brand->name }}</td>
                            <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $brand->description }}
                            </td>
                            <td>
                                <a href="{{ APP_URL . 'admin/brands/edit/'. $brand->id_brand }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ APP_URL . 'admin/brands/delete/' . $brand->id_brand }}" method="post">
                                    <button class="btn btn-danger btn-icon-split" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này không? Nếu xóa, tất cả sản phẩm thuộc thương hiệu này và phiên bản liên quan cũng sẽ bị xóa!')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Xóa</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection