<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active">Giỏ hàng</li>
        </ol>
    </nav>

    <?php if (empty($cart_items)): ?>
    <!-- Empty Cart -->
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
        <h3>Giỏ hàng trống</h3>
        <p class="text-muted">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
        <a href="/san-pham" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>
    <?php else: ?>
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Giỏ hàng của bạn (<?php echo count($cart_items); ?> sản phẩm)</h5>
                    
                    <!-- Cart Item List -->
                    <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item mb-4 pb-4 border-bottom">
                        <div class="row align-items-center">
                            <!-- Product Image -->
                            <div class="col-md-2">
                                <img src="<?php echo $item['image']; ?>" class="img-fluid" alt="<?php echo $item['name']; ?>">
                            </div>
                            
                            <!-- Product Info -->
                            <div class="col-md-4">
                                <h6 class="mb-1"><?php echo $item['name']; ?></h6>
                                <?php if ($item['variant']): ?>
                                <small class="text-muted d-block">Phiên bản: <?php echo $item['variant']; ?></small>
                                <?php endif; ?>
                                <?php if ($item['color']): ?>
                                <small class="text-muted d-block">Màu sắc: <?php echo $item['color']; ?></small>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Quantity -->
                            <div class="col-md-3">
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                                    <input type="number" class="form-control text-center" value="<?php echo $item['quantity']; ?>" min="1" onchange="updateQuantity(<?php echo $item['id']; ?>, this.value - <?php echo $item['quantity']; ?>)">
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">+</button>
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="col-md-2 text-end">
                                <div class="price mb-1"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</div>
                                <?php if ($item['original_price']): ?>
                                <small class="text-muted text-decoration-line-through"><?php echo number_format($item['original_price'] * $item['quantity'], 0, ',', '.'); ?>đ</small>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Remove Button -->
                            <div class="col-md-1 text-end">
                                <button class="btn btn-link text-danger" onclick="removeItem(<?php echo $item['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <!-- Cart Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/san-pham" class="btn btn-link">
                            <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                        </a>
                        <button class="btn btn-outline-danger" onclick="clearCart()">
                            <i class="fas fa-trash me-2"></i>Xóa giỏ hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Tổng giỏ hàng</h5>
                    
                    <!-- Summary Details -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính</span>
                        <span><?php echo number_format($cart_summary['subtotal'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển</span>
                        <span><?php echo number_format($cart_summary['shipping_fee'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <?php if ($cart_summary['discount']): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Giảm giá</span>
                        <span class="text-danger">-<?php echo number_format($cart_summary['discount'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <!-- Total -->
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Tổng cộng</strong>
                        <strong class="text-danger h5 mb-0"><?php echo number_format($cart_summary['total'], 0, ',', '.'); ?>đ</strong>
                    </div>
                    
                    <!-- Coupon Code -->
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Mã giảm giá" id="couponCode">
                            <button class="btn btn-outline-primary" type="button" onclick="applyCoupon()">Áp dụng</button>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <a href="/checkout" class="btn btn-primary w-100">
                        Tiến hành thanh toán
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function updateQuantity(productId, change) {
    const newQuantity = parseInt(document.querySelector(`input[data-product-id="${productId}"]`).value) + change;
    if (newQuantity < 1) return;
    
    fetch('/api/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    });
}

function removeItem(productId) {
    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;
    
    fetch('/api/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    });
}

function clearCart() {
    if (!confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) return;
    
    fetch('/api/cart/clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    });
}

function applyCoupon() {
    const couponCode = document.getElementById('couponCode').value;
    if (!couponCode) {
        alert('Vui lòng nhập mã giảm giá!');
        return;
    }
    
    fetch('/api/cart/coupon', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            coupon_code: couponCode
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Mã giảm giá không hợp lệ!');
        }
    });
}
</script> 