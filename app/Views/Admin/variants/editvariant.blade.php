@extends('layouts.admin')
@section('title', 'Chỉnh sửa phiên bản sản phẩm')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/variants' }}" class="btn btn-primary">Quay lại</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa phiên bản sản phẩm</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/variants/edit/' . $variant->id_prodvar }}" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_product" class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_product" name="id_product">
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach ($listProduct as $product)
                                <option value="{{ $product->id_product }}" {{ $variant->id_product == $product->id_product ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_color" class="form-label">Màu sắc <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_color" name="id_color">
                                <option value="">-- Chọn màu sắc --</option>
                                @foreach ($listColor as $color)
                                <option value="{{ $color->id_color }}" {{ $variant->id_color == $color->id_color ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_storage" class="form-label">Dung lượng <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_storage" name="id_storage">
                                <option value="">-- Chọn dung lượng --</option>
                                @foreach ($listStorage as $storage)
                                <option value="{{ $storage->id_storage }}" {{ $variant->id_storage == $storage->id_storage ? 'selected' : '' }}>
                                    {{ $storage->storage }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_config" class="form-label">Cấu hình <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_config" name="id_config">
                                <option value="">-- Chọn cấu hình --</option>
                                @foreach ($listConfig as $config)
                                <option value="{{ $config->id_config }}" {{ $variant->id_config == $config->id_config ? 'selected' : '' }}>
                                    CPU: {{ $config->cpu }} | RAM: {{ $config->ram }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price" name="price" min="0" value="{{ $variant->price }}">
                                <span class="input-group-text">VNĐ</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="{{ $variant->quantity }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="text-muted">Chọn hình ảnh mới nếu muốn thay đổi, nếu không hình ảnh cũ sẽ được giữ lại</small>
                    
                    @if (!empty($variant->image))
                    <div class="mt-2">
                        <p>Hình ảnh hiện tại:</p>
                        <img src="{{ APP_URL . 'public/images/' . $variant->image }}" alt="Hình ảnh hiện tại" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật phiên bản</button>
            </form>
        </div>
    </div>
</div>
@endsection