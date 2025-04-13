@extends('layouts.main')
@section('title', 'Đơn hàng của tôi')
@section('content')
<div class="container py-4">
    <h1 class="mb-4">Đơn hàng của tôi</h1>

    @if (isset($_SESSION['success']))
    <div class="alert alert-success">
        {{ $_SESSION['success'] }}
        @php unset($_SESSION['success']); @endphp
    </div>
    @endif

    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {{ $_SESSION['error'] }}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif

    @if (count($orders) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID đơn</th>
                    <th>Người nhận</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                @php
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
                foreach ($order->details as $detail) {
                    $total += $detail->price * $detail->quantity;
                }
                @endphp
                <tr>
                    <td>{{ $order->id_order }}</td>
                    <td>{{ $order->buyer_name }}</td>
                    <td>{{ number_format($total) }} VNĐ</td>
                    <td>
                        <span class="{{ $statusClasses[$order->status] }}">{{ $statusTexts[$order->status] }}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailModal{{ $order->id_order }}">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">
        Bạn chưa có đơn hàng nào.
    </div>
    @endif

    <!-- Modals -->
    @foreach ($orders as $order)
    <div class="modal fade" id="orderDetailModal{{ $order->id_order }}" tabindex="-1" aria-labelledby="orderDetailModalLabel{{ $order->id_order }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel{{ $order->id_order }}">Chi tiết đơn hàng #{{ $order->id_order }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Thông tin đơn hàng</h6>
                    <p><strong>Trạng thái:</strong> <span class="{{ $statusClasses[$order->status] }}">{{ $statusTexts[$order->status] }}</span></p>
                    <p><strong>Tổng tiền:</strong> {{ number_format($total) }} VNĐ</p>
                    <p><strong>Phương thức thanh toán:</strong>
                        @php
                        $paymentMethods = [
                            0 => 'Thanh toán khi nhận hàng (COD)',
                            1 => 'Chuyển khoản ngân hàng'
                        ];
                        @endphp
                        {{ $paymentMethods[$order->pay_method] ?? 'Không xác định' }}
                    </p>

                    <h6 class="mt-4">Chi tiết sản phẩm</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Phiên bản</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $detail)
                                <tr>
                                    <td>{{ $detail->product_name }}</td>
                                    <td>{{ $detail->variant_name }}</td>
                                    <td>{{ number_format($detail->price) }} VNĐ</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ number_format($detail->subtotal) }} VNĐ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mt-4">Thông tin giao hàng</h6>
                    <p><strong>Người nhận:</strong> {{ $order->buyer_name }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    @if ($order->notes)
                    <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection