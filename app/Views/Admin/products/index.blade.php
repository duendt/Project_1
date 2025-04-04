@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý sản phẩm</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-lg"></i> Thêm sản phẩm
        </button>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">
                Sản phẩm
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="variants-tab" data-bs-toggle="tab" data-bs-target="#variants" type="button" role="tab">
                Phiên bản
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="brands-tab" data-bs-toggle="tab" data-bs-target="#brands" type="button" role="tab">
                Thương hiệu
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="types-tab" data-bs-toggle="tab" data-bs-target="#types" type="button" role="tab">
                Loại sản phẩm
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="color-tab" data-bs-toggle="tab" data-bs-target="#colors" type="button" role="tab">
                Màu sắc
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="storage-tab" data-bs-toggle="tab" data-bs-target="#storages" type="button" role="tab">
                Dung lượng
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="config-tab" data-bs-toggle="tab" data-bs-target="#configs" type="button" role="tab">
                Cấu hình
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="productTabsContent">
        <!-- Products Tab -->
        <div class="tab-pane fade show active" id="products" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <select name="typeProduct" id="typeProduct" class="form-select" aria-label="Default select example" style="border: 1px solid black;">
                            <option value="">Tất cả sản phẩm</option>
                            @foreach ($listType as $list)
                            <option value="{{ $list->id_type }}">{{ $list->name }}</option>
                            @endforeach
                        </select>
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
                                        <a href="{{ APP_URL . 'products/edit/'. $list->id_product }}" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $list->id_product }}">
                                        <i class="bi bi-pencil"></i> Sửa
                                        </a>
                                        <a href="{{ APP_URL . 'products/edit/'. $list->id_product }}">Sửa</a>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal{{ $list->id }}">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                                <!-- Edit products -->
                                <div class="modal fade" id="editProductModal{{ $list->id_product }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa sản phẩm: {{ $list->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form  method="POST" enctype="multipart/form-data" action="{{ APP_URL . 'admin/products/edit/' . $list->id_product }}">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tên sản phẩm</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $list->name }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Thương hiệu</label>
                                                        <select name="id_brand" id="typeProduct" class="form-select" aria-label="Default select example">
                                                            @foreach ($listBrand as $brand)
                                                            <option value="{{ $brand->id_brand }}" @if ($list->id_brand == $brand->id_brand) selected @endif>{{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Loại sản phẩm</label>
                                                        <select name="id_type" id="typeProduct" class="form-select" aria-label="Default select example">
                                                            @foreach ($listType as $type)
                                                            <option value="{{ $type->id_type }}" @if ($list->id_type == $type->id_type) selected @endif>{{ $type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Mô tả</label>
                                                        <textarea name="description" class="form-control" rows="4">{{ $list->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Bảo hành</label>
                                                        <input type="text" name="warranty" class="form-control" value="{{ $list->warranty }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </form>
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

        <!-- Variants Tab -->
        <div class="tab-pane fade" id="variants" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                        <i class="bi bi-plus-lg"></i> Thêm phiên bản sản phẩm
                    </button>
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
                                <tr>
                                    <td colspan="9" class="text-center">Không có dữ liệu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Brands Tab -->
        <div class="tab-pane fade" id="brands" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                        <i class="bi bi-plus-lg"></i> Thêm thương hiệu
                    </button>
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
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBrandModal{{ $brand->id_brand }}">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBrandModal{{ $brand->id_brand }}">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                                <!-- Edit Brand Modal -->
                                <div class="modal fade" id="editBrandModal{{ $brand->id_brand }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa thương hiệu: {{ $brand->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ APP_URL . 'admin/brands/edit/' . $brand->id_brand }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label">Tên thương hiệu</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $brand->name }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Mô tả</label>
                                                        <textarea name="description" class="form-control" rows="3">{{ $brand->description }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </form>
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

        <!-- Product Types Tab -->
        <div class="tab-pane fade" id="types" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTypeModal">
                        <i class="bi bi-plus-lg"></i> Thêm loại sản phẩm
                    </button>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên loại</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listType as $type)
                                <tr>
                                    <td>{{ $type->id_type }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTypeModal{{ $type->id_type }}">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTypeModal{{ $type->id_type }}">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                                <!-- Edit Type Modal -->
                                <div class="modal fade" id="editTypeModal{{ $type->id_type }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa loại sản phẩm: {{ $type->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ APP_URL . 'admin/types/edit/' . $type->id_type }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label">Tên loại</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $type->name }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </form>
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

        <!-- Colors Tab -->
        <div class="tab-pane fade" id="colors" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addColorModal">
                        <i class="bi bi-plus-lg"></i> Thêm màu sắc
                    </button>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên màu</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listColor as $color)
                                <tr>
                                    <td>{{ $color->id_color }}</td>
                                    <td>{{ $color->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editColorModal{{ $color->id_color }}">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteColorModal{{ $color->id_color }}">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                                <!-- Edit Color Modal -->
                                <div class="modal fade" id="editColorModal{{ $color->id_color }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa màu sắc: {{ $color->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ APP_URL . 'admin/colors/edit/' . $color->id_color }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label">Tên màu</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $color->name }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </form>
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

        <!-- Storages Tab -->
        <div class="tab-pane fade" id="storages" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStorageModal">
                        <i class="bi bi-plus-lg"></i> Thêm dung lượng
                    </button>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dung lượng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listStorage as $storage)
                                <tr>
                                    <td>{{ $storage->id_storage }}</td>
                                    <td>{{ $storage->storage }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStorageModal{{ $storage->id_storage }}">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStorageModal{{ $storage->id_storage }}">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                                <!-- Edit Storage Modal -->
                                <div class="modal fade" id="editStorageModal{{ $storage->id_storage }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa dung lượng: {{ $storage->storage }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ APP_URL . 'admin/storages/edit/' . $storage->id_storage }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label">Dung lượng</label>
                                                        <input type="text" name="storage" class="form-control" value="{{ $storage->storage }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </form>
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

        <!-- Configs Tab -->
        <div class="tab-pane fade" id="configs" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addConfigModal">
                        <i class="bi bi-plus-lg"></i> Thêm cấu hình
                    </button>
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
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editConfigModal{{ $config->id_config }}">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfigModal{{ $config->id_config }}">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                                <!-- Edit Config Modal -->
                                <div class="modal fade" id="editConfigModal{{ $config->id_config }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sửa cấu hình: {{ $config->id_config }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ APP_URL . 'admin/configs/edit/' . $config->id_config }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">CPU</label>
                                                            <input type="text" name="cpu" class="form-control" value="{{ $config->cpu }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">RAM</label>
                                                            <input type="text" name="ram" class="form-control" value="{{ $config->ram }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">GPU</label>
                                                            <input type="text" name="gpu" class="form-control" value="{{ $config->gpu }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Màn hình</label>
                                                            <input type="text" name="screen" class="form-control" value="{{ $config->screen }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Pin</label>
                                                            <input type="text" name="battery" class="form-control" value="{{ $config->battery }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Tần số</label>
                                                            <input type="text" name="hz" class="form-control" value="{{ $config->hz }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Camera</label>
                                                            <input type="text" name="camera" class="form-control" value="{{ $config->camera }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Hệ điều hành</label>
                                                            <input type="text" name="operating_system" class="form-control" value="{{ $config->operating_system }}">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </form>
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
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm sản phẩm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Thương hiệu</label>
                            <select class="form-select">
                                @foreach ($listBrand as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Loại sản phẩm</label>
                            <select class="form-select">
                                @foreach ($listType as $type)
                                <option value="{{ $type->id_type }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bảo hành</label>
                            <input type="text" class="form-control" placeholder="Ví dụ: 12 tháng">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm thương hiệu mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Tên thương hiệu</label>
                        <input type="text" class="form-control">
                        <label class="form-label">Sản phẩm</label>
                        <select class="form-select">
                            <option>Chọn sản phẩm</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Màu sắc</label>
                        <select class="form-select">
                            <option>Chọn màu sắc</option>
                        </select>
                    </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Dung lượng</label>
                    <select class="form-select">
                        <option>Chọn dung lượng</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cấu hình</label>
                    <select class="form-select">
                        <option>Chọn cấu hình</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Giá</label>
                    <input type="number" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số lượng</label>
                    <input type="number" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Hình ảnh</label>
                <input type="file" class="form-control">
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="button" class="btn btn-primary">Lưu</button>
        </div>
    </div>
</div>
</div>

<!-- Add Color Modal -->
<div class="modal fade" id="addColorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm màu sắc mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Tên màu</label>
                        <input type="text" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Storage Modal -->
<div class="modal fade" id="addStorageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm dung lượng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Dung lượng</label>
                        <input type="text" class="form-control" placeholder="Ví dụ: 128GB">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Config Modal -->
<div class="modal fade" id="addConfigModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm cấu hình mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">CPU</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RAM</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">GPU</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Màn hình</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pin</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tần số</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Camera</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hệ điều hành</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
@endsection