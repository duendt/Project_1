@extends('layouts.main')
@section('title', 'Thanh toán')
@section('content')
<div class="container py-4">
    <h1 class="mb-4">Thanh toán</h1>
    @if(isset($_SESSION['success']))
    <div class="alert alert-success">
        {{ $_SESSION['success'] }}
        @php unset($_SESSION['success']); @endphp
    </div>
    @endif

    @if(isset($_SESSION['error']))
    <div class="alert alert-danger">
        {{ $_SESSION['error'] }}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif
    <div class="row">
        <!-- Thông tin giao hàng -->
        <div class="col-lg-8">
            <form id="checkoutForm" action="{{ APP_URL . 'check-out' }}" method="POST">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Thông tin giao hàng</h5>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="buyer_name" value="{{ $user->name ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" rows="3">{{ $user->address }}</textarea>
                            <span class="text-danger">Vui lòng nhập địa chỉ chính xác để nhận hàng nhanh nhất!</span>
                        </div>
                    </div>
                </div>

                <!-- Phương thức thanh toán -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Phương thức thanh toán</h5>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="pay_method" id="cod" value="0" checked>
                            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="pay_method" id="bank" value="1">
                            <label class="form-check-label" for="bank">Chuyển khoản ngân hàng</label>
                        </div>
                    </div>
                </div>

                <!-- Ghi chú -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ghi chú</h5>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Ghi chú về đơn hàng..."></textarea>
                    </div>
                </div>

                <!-- Tóm tắt đơn hàng -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Đơn hàng ({{ count($checkoutItems) }} sản phẩm)</h5>
                            <ul class="list-group mb-4">
                                @foreach ($checkoutItems as $index => $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $item['name'] }}</h6>
                                        <small class="text-muted">SL: {{ $item['quantity'] }} x {{ number_format($item['price'], 0, ',', '.') }}đ</small>
                                    </div>
                                    <span class="text-danger">{{ number_format($item['subtotal'], 0, ',', '.') }}đ</span>
                                </li>
                                <!-- Truyền dữ liệu sản phẩm qua form -->
                                <input type="hidden" name="order_items[{{ $index }}][variant_id]" value="{{ $item['variant_id'] }}">
                                <input type="hidden" name="order_items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
                                <input type="hidden" name="order_items[{{ $index }}][price]" value="{{ $item['price'] }}">
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính</span>
                                <span>{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển</span>
                                <span>{{ $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . 'đ' : 'Miễn phí' }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2">
                                <strong>Tổng cộng</strong>
                                <strong class="text-danger">{{ number_format($total, 0, ',', '.') }}đ</strong>
                            </div>
                            <input type="hidden" name="fromCart" value="{{ $fromCart }}">
                            <button type="submit" form="checkoutForm" class="btn btn-danger w-100 mt-3">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>

</script>
@endsection