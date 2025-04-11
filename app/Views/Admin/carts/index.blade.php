@extends('layouts.admin')
@section('title', 'Quản lý giỏ hàng')
@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Quản lý giỏ hàng</h2>

    @if (isset($_SESSION['confim']))
    <div class="alert alert-success">
        {{ $_SESSION['confim'] }}
        @php unset($_SESSION['confim']); @endphp
    </div>
    @endif

    @if (isset($_SESSION['message']))
    <div class="alert alert-success">
        {{ $_SESSION['message'] }}
        @php unset($_SESSION['message']); @endphp
    </div>
    @endif

    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" name="search" placeholder="ID giỏ hàng, ID khách hàng...">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <button type="reset" class="btn btn-secondary">Đặt lại</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách giỏ hàng -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID giỏ hàng</th>
                            <th>ID khách hàng</th>
                            <th>Tên khách hàng</th>
                            <th>ID phiên bản SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listCarts as $cart)
                        <tr>
                            <td>{{ $cart->id_cart }}</td>
                            <td>{{ $cart->id_user }}</td>
                            <td>{{ $cart->user_name }}</td>
                            <td>{{ $cart->id_prodvar }}</td>
                            <td>{{ $cart->product_name }}</td>
                            <td>{{ number_format($cart->price) }} VNĐ</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>{{ number_format($cart->price * $cart->quantity) }} VNĐ</td>
                            <td>
                                <a href="{{ APP_URL . 'admin/carts/detail/' . $cart->id_cart }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                <a href="{{ APP_URL . 'admin/carts/convert/' . $cart->id_cart }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-arrow-right"></i> Đơn hàng
                                </a>
                                <form action="{{ APP_URL . 'admin/carts/delete/' . $cart->id_cart }}" method="post" class="d-inline">
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa giỏ hàng này không?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($listCarts) === 0)
                        <tr>
                            <td colspan="9" class="text-center">Không có dữ liệu</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 