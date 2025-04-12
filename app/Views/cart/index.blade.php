@extends('layouts.main')
@section('title', 'Giỏ hàng')
@section('content')
<div class="container my-5">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>
    
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
    
    @if(empty($cartItems))
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-shopping-cart fa-5x text-muted"></i>
        </div>
        <h3>Giỏ hàng trống</h3>
        <p class="text-muted">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
        <a href="{{ APP_URL }}" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
    </div>
    @else
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0">Sản phẩm</h5>
                        </div>
                        <div class="col-6 text-end">
                            <form action="{{ APP_URL . 'api/cart/clear' }}" method="post" id="clearCartForm">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmClearCart()">
                                    <i class="fas fa-trash-alt me-2"></i>Xóa tất cả
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($cartItems as $item)
                        <li class="list-group-item py-3">
                            <div class="row align-items-center cart-item" data-id="{{ $item->id_cart }}">
                                <div class="col-md-2 col-3">
                                    <img src="{{ APP_URL . 'public/images/' . $item->image }}" class="img-fluid rounded" alt="{{ $item->product_name }}">
                                </div>
                                <div class="col-md-5 col-9">
                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                    <p class="mb-1 text-muted small">{{ $item->variant_name }}</p>
                                    <div class="d-md-none mt-2">
                                        <span class="fw-bold text-danger">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                                <div class="col-md-2 d-none d-md-block">
                                    <span class="fw-bold text-danger">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                                </div>
                                <div class="col-md-2 col-7 mt-3 mt-md-0">
                                    <div class="input-group input-group-sm quantity-control">
                                        <button class="btn btn-outline-secondary decrease-btn" type="button" data-id="{{ $item->id_cart }}">-</button>
                                        <input type="number" class="form-control text-center quantity-input" value="{{ $item->quantity }}" min="1" data-id="{{ $item->id_cart }}">
                                        <button class="btn btn-outline-secondary increase-btn" type="button" data-id="{{ $item->id_cart }}">+</button>
                                    </div>
                                </div>
                                <div class="col-md-1 col-5 text-end mt-3 mt-md-0">
                                    <form action="{{ APP_URL . 'api/cart/remove' }}" method="post" class="remove-form">
                                        <input type="hidden" name="cart_id" value="{{ $item->id_cart }}">
                                        <button type="button" class="btn btn-sm btn-link text-danger remove-item" data-id="{{ $item->id_cart }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-12 mt-2 text-end">
                                    <span class="fw-bold item-subtotal" data-id="{{ $item->id_cart }}">{{ number_format($item->subtotal, 0, ',', '.') }}đ</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ APP_URL }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Tổng đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tạm tính</span>
                        <span class="fw-bold" id="subtotal">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển</span>
                        <span id="shipping-fee">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Tổng cộng</span>
                        <span class="fw-bold text-danger h5" id="total-amount">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ APP_URL . 'thanh-toan' }}" class="btn btn-primary">
                            Tiến hành thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút tăng số lượng
    document.querySelectorAll('.increase-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-id');
            const inputElement = document.querySelector(`.quantity-input[data-id="${cartId}"]`);
            let currentValue = parseInt(inputElement.value);
            updateQuantity(cartId, currentValue + 1);
        });
    });
    
    // Xử lý nút giảm số lượng
    document.querySelectorAll('.decrease-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-id');
            const inputElement = document.querySelector(`.quantity-input[data-id="${cartId}"]`);
            let currentValue = parseInt(inputElement.value);
            if (currentValue > 1) {
                updateQuantity(cartId, currentValue - 1);
            }
        });
    });
    
    // Xử lý khi người dùng nhập trực tiếp số lượng
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const cartId = this.getAttribute('data-id');
            let newValue = parseInt(this.value);
            
            if (isNaN(newValue) || newValue < 1) {
                newValue = 1;
                this.value = 1;
            }
            
            updateQuantity(cartId, newValue);
        });
    });
    
    // Xử lý nút xóa sản phẩm
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-id');
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                const form = this.closest('.remove-form');
                form.submit();
            }
        });
    });
});

// Cập nhật số lượng sản phẩm
function updateQuantity(cartId, quantity) {
    fetch('{{ APP_URL . "api/cart/update" }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            cart_id: cartId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật số lượng hiển thị
            document.querySelector(`.quantity-input[data-id="${cartId}"]`).value = data.quantity;
            
            // Cập nhật tổng tiền của sản phẩm
            document.querySelector(`.item-subtotal[data-id="${cartId}"]`).textContent = data.subtotal_formatted;
            
            // Cập nhật tổng giỏ hàng
            updateCartTotal();
        } else {
            alert('Có lỗi xảy ra: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
    });
}

// Cập nhật tổng giỏ hàng
function updateCartTotal() {
    let total = 0;
    
    document.querySelectorAll('.item-subtotal').forEach(element => {
        const subtotalText = element.textContent.replace(/\./g, '').replace('đ', '');
        total += parseInt(subtotalText);
    });
    
    const formattedTotal = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
    document.getElementById('subtotal').textContent = formattedTotal;
    document.getElementById('total-amount').textContent = formattedTotal;
}

// Xác nhận xóa tất cả
function confirmClearCart() {
    if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
        document.getElementById('clearCartForm').submit();
    }
}
</script>
@endsection 