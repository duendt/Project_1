@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')
@section('content')

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
    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {{ $_SESSION['error'] }}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif
    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="">Tất cả</option>
                        <option value="0">Chờ xác nhận</option>
                        <option value="1">Đã xác nhận</option>
                        <option value="2">Đang giao</option>
                        <option value="3">Đã giao</option>
                        <option value="4">Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Phương thức thanh toán</label>
                    <select class="form-select" name="payment_method">
                        <option value="">Tất cả</option>
                        <option value="0">Thanh toán khi nhận hàng</option>
                        <option value="1">Chuyển khoản ngân hàng</option>
                        <option value="2">Thanh toán online</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" name="search" placeholder="Mã đơn, ID khách hàng...">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <button type="reset" class="btn btn-secondary">Đặt lại</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách đơn hàng -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID đơn</th>
                            <th>ID khách hàng</th>
                            <th>Tên người nhận</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listOrders as $order)
                        @php
                        $paymentMethods = [
                        0 => 'Thanh toán khi nhận hàng',
                        1 => 'Chuyển khoản ngân hàng'
                        ];
                        $statusClasses = [
                        0 => 'badge bg-warning',
                        1 => 'badge bg-info',
                        2 => 'badge bg-primary',
                        3 => 'badge bg-success',
                        4 => 'badge bg-danger'
                        ];
                        $statusTexts = [
                        0 => 'Chờ xác nhận',
                        1 => 'Đã xác nhận',
                        2 => 'Đang giao',
                        3 => 'Đã giao',
                        4 => 'Đã hủy'
                        ];
                        $total = 0;
                        foreach ($listDetail as $detail) {
                        if($detail->id_order == $order->id_order) {
                        $total += $detail->price * $detail->quantity;
                        }
                        }
                        @endphp
                        <tr>
                            <td>{{ $order->id_order }}</td>
                            <td>{{ $order->id_user }}</td>
                            <td>{{ $order->buyer_name }}</td>
                            <td>{{ number_format($total) }} VNĐ</td>
                            <td>{{ $paymentMethods[$order->pay_method] }}</td>
                            <td>
                                <span class="{{ $statusClasses[$order->status] }}">{{ $statusTexts[$order->status] }}</span>
                            </td>

                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailModal{{ $order->id_order }}">
                                   <i class="bi bi-eye"></i> Chi tiết
                                </button>
                                <a href="{{ APP_URL . 'admin/order/edit/' . $order->id_order }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i> Chỉnh sửa
                                </a>
                                @if ($order->status < 2)
                                    <form action="{{ APP_URL . 'admin/order/delete/' . $order->id_order }}" method="post" class="d-inline">
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                    </form>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals - đặt bên ngoài bảng -->
    @foreach ($listOrders as $order)
    @php
    $paymentMethods = [
    0 => 'Thanh toán khi nhận hàng',
    1 => 'Thanh toán online'
    ];
    $statusClasses = [
    0 => 'badge bg-warning',
    1 => 'badge bg-info',
    2 => 'badge bg-primary',
    3 => 'badge bg-success',
    4 => 'badge bg-danger'
    ];
    $statusTexts = [
    0 => 'Chờ xác nhận',
    1 => 'Đã xác nhận',
    2 => 'Đang giao',
    3 => 'Đã giao',
    4 => 'Đã hủy'
    ];
    $total = 0;
    foreach ($listDetail as $detail) {
    if($detail->id_order == $order->id_order) {
    $total += $detail->price * $detail->quantity;
    }
    }
    @endphp
    <div class="modal fade" id="orderDetailModal{{ $order->id_order }}" tabindex="-1" aria-labelledby="orderDetailModalLabel{{ $order->id_order }}" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel{{ $order->id_order }}">Chi tiết đơn hàng #{{ $order->id_order }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Thông tin khách hàng</h6>
                            <p><strong>ID khách hàng:</strong> {{ $order->id_user }}</p>
                            <p><strong>Tên người nhận:</strong> {{ $order->buyer_name }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                            <p><strong>Notes:</strong> {{ $order->notes }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Thông tin đơn hàng</h6>
                            <p><strong>Trạng thái:</strong> <span class="{{ $statusClasses[$order->status] }} px-2">{{ $statusTexts[$order->status] }}</span></p>
                            <p><strong>Phương thức thanh toán:</strong> {{ $paymentMethods[$order->pay_method] }}</p>
                            <p><strong>Tổng tiền:</strong> {{ number_format($total) }} VNĐ</p>
                        </div>
                    </div>

                    <h6 class="mt-4 mb-3">Chi tiết sản phẩm</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sản phẩm</th>
                                    <th>Phiên bản</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-{{ $order->id_order }}">
                                @foreach ($listDetail as $detail)
                                @if($detail->id_order == $order->id_order)
                                <tr>
                                    <td>{{ $detail->id_orderdetail }}</td>
                                    <td>
                                        @foreach ($listVariant as $variant)
                                        @if($variant->id_prodvar == $detail->id_prodvar)
                                        {{ $variant->product_name }}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($listVariant as $variant)
                                        @if($variant->id_prodvar == $detail->id_prodvar)
                                        {{ $variant->color_name }} - {{ $variant->storage }}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($detail->price) }} VNĐ</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ number_format($detail->price * $detail->quantity) }} VNĐ</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <a href="{{ APP_URL . 'admin/order/edit/' . $order->id_order }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Chỉnh sửa
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection