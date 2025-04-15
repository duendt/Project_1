@extends('layouts.admin')
@section('title', 'Quản lý phiên bản')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý phiên bản</h2>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ APP_URL . 'admin/products' }}">Sản phẩm</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="{{ APP_URL . 'admin/variants' }}">Phiên bản</a>
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
            <a href="{{ APP_URL . 'admin/variants/create'}}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-lg"></i> Thêm phiên bản
            </a>
            <div class="table-responsive">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select name="id_product" class="form-select" aria-label="Chọn sản phẩm">
                            <option value="">Chọn sản phẩm</option>
                            @foreach ($listProduct as $product)
                            <option value="{{ $product->id_product }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="id_storage" class="form-select" aria-label="Chọn dung lượng">
                            <option value="">Chọn dung lượng</option>
                            @foreach ($listStorage as $storage)
                            <option value="{{ $storage->id_storage }}">{{ $storage->storage }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Dung lượng</th>
                            <th>Cấu hình</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Số lượng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listVariant as $variant)
                        <tr>
                            <td>{{ $variant->id_prodvar }}</td>
                            <td>{{ $variant->product_name }}</td>
                            <td>{{ $variant->color }}</td>
                            <td>{{ $variant->storage }}</td>
                            <td>
                                <p>CPU: {{ $variant->cpu }}</p>
                                <p>RAM: {{ $variant->ram }}</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#configModal{{ $variant->id_prodvar }}">Chi tiết</button>
                            </td>
                            <td>{{ number_format($variant->price, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <img src="{{ APP_URL . 'public/images/' . $variant->image }}" alt="{{ $variant->product_name }}" style="max-width: 100px;">
                            </td>
                            <td>{{ $variant->quantity }}</td>
                            <td>
                                <a href="{{ APP_URL . 'admin/variants/edit/'. $variant->id_prodvar }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ APP_URL . 'admin/variants/delete/' . $variant->id_prodvar }}" method="post">
                                    <button class="btn btn-danger btn-icon-split" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa phiên bản này không?')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Xóa</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="configModal{{ $variant->id_prodvar }}" tabindex="-1" aria-labelledby="configModalLabel{{ $variant->id_prodvar }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="configModalLabel{{ $variant->id_prodvar }}">Cấu hình chi tiết</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>CPU:</strong> {{ $variant->cpu }}</p>
                                        <p><strong>RAM:</strong> {{ $variant->ram }}</p>
                                        <p><strong>GPU:</strong> {{ $variant->gpu }}</p>
                                        <p><strong>Màn hình:</strong> {{ $variant->screen }}</p>
                                        <p><strong>Pin:</strong> {{ $variant->battery }}</p>
                                        <p><strong>Hz:</strong> {{ $variant->hz }}</p>
                                        <p><strong>Camera:</strong> {{ $variant->camera }}</p>
                                        <p><strong>Hệ điều hành:</strong> {{ $variant->operating_system }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection