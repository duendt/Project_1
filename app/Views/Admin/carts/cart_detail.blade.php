@extends('layouts.admin')
@section('title', 'Chi tiết giỏ hàng')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/carts' }}" class="btn btn-primary">Quay lại</a>
    
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết giỏ hàng #{{ $cart->id_cart }}</h6>
        </div>
        <div class="card-body">
            <!-- Thông tin khách hàng -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin khách hàng</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID khách hàng:</strong> {{ $cart->id_user }}</p>
                            <p><strong>Họ tên:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Địa chỉ:</strong> {{ $user->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin sản phẩm</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID phiên bản:</strong> {{ $cart->id_prodvar }}</p>
                            <p><strong>Tên sản phẩm:</strong> {{ $product->name }}</p>
                            <p><strong>Màu sắc:</strong> {{ $color->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dung lượng:</strong> {{ $storage->storage }}</p>
                            <p><strong>Giá:</strong> {{ number_format($cart->price) }} VNĐ</p>
                            <p><strong>Số lượng:</strong> {{ $cart->quantity }}</p>
                            <p><strong>Thành tiền:</strong> {{ number_format($cart->price * $cart->quantity) }} VNĐ</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-end mt-3">
                <a href="{{ APP_URL . 'admin/carts/convert/' . $cart->id_cart }}" class="btn btn-success">
                    <i class="bi bi-arrow-right"></i> Chuyển thành đơn hàng
                </a>
                <form action="{{ APP_URL . 'admin/carts/delete/' . $cart->id_cart }}" method="post" class="d-inline">
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa giỏ hàng này không?')">
                        <i class="bi bi-trash"></i> Xóa giỏ hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 