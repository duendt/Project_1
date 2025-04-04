<div class="container py-4">
    <h1 class="mb-4">Thanh toán</h1>

    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8">
            <form id="checkoutForm" onsubmit="return submitOrder(event)">
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Thông tin giao hàng</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fullname" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <select class="form-select" name="province" required onchange="updateShippingFee()">
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    <?php foreach ($provinces as $province): ?>
                                    <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                <select class="form-select" name="district" required onchange="updateShippingFee()">
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                                <select class="form-select" name="ward" required>
                                    <option value="">Chọn phường/xã</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Phương thức thanh toán</h5>
                        
                        <div class="payment-methods">
                            <!-- COD -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i>
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                                <label class="form-check-label" for="bank">
                                    <i class="fas fa-university text-primary me-2"></i>
                                    Chuyển khoản ngân hàng
                                </label>
                                <div class="bank-details ms-4 mt-2" style="display: none;">
                                    <div class="alert alert-info">
                                        <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                        <p class="mb-1"><strong>Số tài khoản:</strong> 1234567890</p>
                                        <p class="mb-1"><strong>Chủ tài khoản:</strong> CÔNG TY TNHH TECHSTORE</p>
                                        <p class="mb-0"><strong>Nội dung:</strong> [Mã đơn hàng] - [Số điện thoại]</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Momo -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                                <label class="form-check-label" for="momo">
                                    <img src="/images/momo-logo.png" alt="Momo" height="20" class="me-2">
                                    Ví MoMo
                                </label>
                            </div>

                            <!-- VNPay -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="vnpay" value="vnpay">
                                <label class="form-check-label" for="vnpay">
                                    <img src="/images/vnpay-logo.png" alt="VNPay" height="20" class="me-2">
                                    VNPay
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Note -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ghi chú</h5>
                        <textarea class="form-control" name="note" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Đơn hàng (<?php echo count($cartItems); ?> sản phẩm)</h5>

                    <!-- Products List -->
                    <div class="order-products mb-4">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex mb-3">
                            <img src="<?php echo $item['image']; ?>" class="rounded" width="50" height="50" alt="<?php echo $item['name']; ?>">
                            <div class="ms-3">
                                <h6 class="mb-0"><?php echo $item['name']; ?></h6>
                                <small class="text-muted">
                                    SL: <?php echo $item['quantity']; ?> x 
                                    <?php echo number_format($item['price'], 0, ',', '.'); ?>đ
                                </small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Order Total -->
                    <div class="order-summary">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính</span>
                            <span><?php echo number_format($summary['subtotal'], 0, ',', '.'); ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển</span>
                            <span id="shippingFee">
                                <?php if ($summary['shipping_fee'] > 0): ?>
                                <?php echo number_format($summary['shipping_fee'], 0, ',', '.'); ?>đ
                                <?php else: ?>
                                Miễn phí
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if ($summary['discount'] > 0): ?>
                        <div class="d-flex justify-content-between mb-2 text-danger">
                            <span>Giảm giá</span>
                            <span>-<?php echo number_format($summary['discount'], 0, ',', '.'); ?>đ</span>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between mb-4 pt-2 border-top">
                            <strong>Tổng cộng</strong>
                            <strong class="text-danger" id="totalAmount">
                                <?php echo number_format($summary['total'], 0, ',', '.'); ?>đ
                            </strong>
                        </div>

                        <button type="submit" form="checkoutForm" class="btn btn-danger w-100">
                            Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show/hide bank details
document.querySelectorAll('input[name="payment_method"]').forEach(input => {
    input.addEventListener('change', function() {
        const bankDetails = document.querySelector('.bank-details');
        bankDetails.style.display = this.value === 'bank' ? 'block' : 'none';
    });
});

// Update districts when province changes
document.querySelector('select[name="province"]').addEventListener('change', function() {
    const provinceId = this.value;
    if (provinceId) {
        // Call API to get districts
        fetch(`/api/districts/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                const districtSelect = document.querySelector('select[name="district"]');
                districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                data.forEach(district => {
                    districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                });
            });
    }
});

// Update wards when district changes
document.querySelector('select[name="district"]').addEventListener('change', function() {
    const districtId = this.value;
    if (districtId) {
        // Call API to get wards
        fetch(`/api/wards/${districtId}`)
            .then(response => response.json())
            .then(data => {
                const wardSelect = document.querySelector('select[name="ward"]');
                wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                data.forEach(ward => {
                    wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                });
            });
    }
});

// Update shipping fee
function updateShippingFee() {
    const provinceId = document.querySelector('select[name="province"]').value;
    const districtId = document.querySelector('select[name="district"]').value;
    
    if (provinceId && districtId) {
        // Call API to calculate shipping fee
        fetch(`/api/shipping-fee?province=${provinceId}&district=${districtId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('shippingFee').textContent = 
                    data.fee > 0 ? `${data.fee.toLocaleString('vi-VN')}đ` : 'Miễn phí';
                
                // Update total amount
                const total = <?php echo $summary['subtotal']; ?> + data.fee - <?php echo $summary['discount']; ?>;
                document.getElementById('totalAmount').textContent = `${total.toLocaleString('vi-VN')}đ`;
            });
    }
}

// Submit order
function submitOrder(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Call API to create order
    fetch('/api/orders', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect based on payment method
            const paymentMethod = formData.get('payment_method');
            switch (paymentMethod) {
                case 'momo':
                    window.location.href = data.momoPaymentUrl;
                    break;
                case 'vnpay':
                    window.location.href = data.vnpayPaymentUrl;
                    break;
                default:
                    window.location.href = `/order-success/${data.orderId}`;
            }
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    });
    
    return false;
}
</script> 