@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý cấu hình</h2>
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
            <a class="nav-link active" href="{{ APP_URL . 'admin/configs' }}">Cấu hình</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-body">
            <a href="{{ APP_URL . 'admin/configs/create'}}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-lg"></i> Thêm cấu hình
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
                            <th>CPU</th>
                            <th>RAM</th>
                            <th>GPU</th>
                            <th>Màn hình</th>
                            <th>Pin</th>
                            <th>Tần số</th>
                            <th>Camera</th>
                            <th>Hệ điều hành</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listConfig as $config)
                        <tr>
                            <td>{{ $config->id_config }}</td>
                            <td>{{ $config->cpu }}</td>
                            <td>{{ $config->ram }}</td>
                            <td>{{ $config->gpu }}</td>
                            <td>{{ $config->screen }}</td>
                            <td>{{ $config->battery }}</td>
                            <td>{{ $config->hz }}</td>
                            <td>{{ $config->camera }}</td>
                            <td>{{ $config->operating_system }}</td>
                            <td>
                                <a href="{{ APP_URL . 'admin/configs/edit/'. $config->id_config }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ APP_URL . 'admin/configs/delete/' . $config->id_config }}" method="post">
                                    <button class="btn btn-danger btn-icon-split" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa cấu hình này không? Bạn sẽ xóa tất cả phiên bản có cấu hình này!')">
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