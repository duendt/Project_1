@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý sản phẩm</h2>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="{{ APP_URL . 'admin/products' }}">Sản phẩm</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/variants' }}">Phiên bản</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/brands' }}">Thương hiệu</a>
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
            <div class="table-responsive">
                <a href="{{ APP_URL . 'admin/products/create'}}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-lg"></i> Thêm sản phẩm
                </a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Thương hiệu</th>
                            <th>Mô tả</th>
                            <th>Bảo hành</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listProduct as $list)
                        <tr>
                            <td>{{ $list->id_product }}</td>
                            <td>{{ $list->name }}</td>
                            <td>{{ $list->brand_name }}</td>
                            <td>{{ $list->description }}</td>
                            <td>{{ $list->warranty }}</td>
                            <td>{{ $list->created_at }}</td>
                            <td>
                                <a href="{{ APP_URL . 'admin/products/edit/'. $list->id_product }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ APP_URL . 'admin/products/delete/' . $list->id_product }}" method="post">
                                    <button class="btn btn-danger btn-icon-split" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không? Bạn sẽ xóa tất cả phiên bản của sản phẩm này!')">
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