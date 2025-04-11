@extends('layouts.admin')
@section('title', 'Chuyển đổi giỏ hàng thành đơn hàng')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/carts' }}" class="btn btn-primary">Quay lại</a>
    
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
            <h6 class="m-0 font-weight-bold text-primary">Chuyển đổi giỏ hàng #{{ $cart->id_cart }} thành đơn hàng</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/carts/convert/' . $cart->id_cart }}">
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
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ $user->address }}</textarea>
                                </div>
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID phiên bản</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Màu sắc</th>
                                        <th>Dung lượng</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $cart->id_prodvar }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $color->name }}</td>
                                        <td>{{ $storage->storage }}</td>
                                        <td>{{ number_format($cart->price) }} VNĐ</td>
                                        <td>{{ $cart->quantity }}</td>
                                        <td>{{ number_format($cart->price * $cart->quantity) }} VNĐ</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-end"><strong>Tổng cộng:</strong></td>
                                        <td><strong>{{ number_format($cart->price * $cart->quantity) }} VNĐ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Thông tin thanh toán -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Thông tin thanh toán</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Phương thức thanh toán <span class="text-danger">*</span></label>
                                    <select class="form-select" id="payment_method" name="payment_method">
                                        <option value="0">Thanh toán khi nhận hàng</option>
                                        <option value="1">Chuyển khoản ngân hàng</option>
                                        <option value="2">Thanh toán online</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="voucher_code" class="form-label">Mã giảm giá (nếu có)</label>
                                    <input type="text" class="form-control" id="voucher_code" name="voucher_code">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg"></i> Tạo đơn hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 