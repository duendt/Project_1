<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/tai-khoan/don-hang">Đơn hàng của tôi</a></li>
            <li class="breadcrumb-item active">Chi tiết đơn hàng #<?php echo $order['id']; ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Đơn hàng #<?php echo $order['id']; ?></h5>
                        <span class="badge bg-<?php echo $order['status_color']; ?>"><?php echo $order['status_text']; ?></span>
                    </div>
                    
                    <!-- Order Timeline -->
                    <div class="order-timeline">
                        <div class="timeline-item <?php echo $order['status'] >= 1 ? 'active' : ''; ?>">
                            <div class="timeline-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Đặt hàng thành công</h6>
                                <small class="text-muted"><?php echo $order['created_at']; ?></small>
                            </div>
                        </div>
                        <div class="timeline-item <?php echo $order['status'] >= 2 ? 'active' : ''; ?>">
                            <div class="timeline-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Đã xác nhận</h6>
                                <?php if ($order['confirmed_at']): ?>
                                <small class="text-muted"><?php echo $order['confirmed_at']; ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="timeline-item <?php echo $order['status'] >= 3 ? 'active' : ''; ?>">
                            <div class="timeline-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Đang giao hàng</h6>
                                <?php if ($order['shipping_at']): ?>
                                <small class="text-muted"><?php echo $order['shipping_at']; ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="timeline-item <?php echo $order['status'] >= 4 ? 'active' : ''; ?>">
                            <div class="timeline-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Đã giao hàng</h6>
                                <?php if ($order['completed_at']): ?>
                                <small class="text-muted"><?php echo $order['completed_at']; ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Sản phẩm</h5>
                    
                    <?php foreach ($order['items'] as $item): ?>
                    <div class="order-item mb-3 pb-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <img src="<?php echo $item['image']; ?>" class="img-fluid rounded" alt="<?php echo $item['name']; ?>">
                            </div>
                            <div class="col-6">
                                <h6 class="mb-1"><?php echo $item['name']; ?></h6>
                                <?php if ($item['variant']): ?>
                                <small class="text-muted d-block">Phiên bản: <?php echo $item['variant']; ?></small>
                                <?php endif; ?>
                                <?php if ($item['color']): ?>
                                <small class="text-muted d-block">Màu sắc: <?php echo $item['color']; ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="col-2 text-center">
                                <span class="text-muted">x<?php echo $item['quantity']; ?></span>
                            </div>
                            <div class="col-2 text-end">
                                <span class="fw-bold"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Tổng quan đơn hàng</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính</span>
                        <span><?php echo number_format($order['subtotal'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển</span>
                        <span><?php echo number_format($order['shipping_fee'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <?php if ($order['discount']): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Giảm giá</span>
                        <span class="text-danger">-<?php echo number_format($order['discount'], 0, ',', '.'); ?>đ</span>
                    </div>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-0">
                        <strong>Tổng cộng</strong>
                        <strong class="text-danger"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</strong>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin giao hàng</h5>
                    
                    <p class="mb-1"><strong>Người nhận:</strong> <?php echo $order['shipping_name']; ?></p>
                    <p class="mb-1"><strong>Số điện thoại:</strong> <?php echo $order['shipping_phone']; ?></p>
                    <?php if ($order['shipping_email']): ?>
                    <p class="mb-1"><strong>Email:</strong> <?php echo $order['shipping_email']; ?></p>
                    <?php endif; ?>
                    <p class="mb-0"><strong>Địa chỉ:</strong> <?php echo $order['shipping_address']; ?></p>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin thanh toán</h5>
                    
                    <p class="mb-1">
                        <strong>Phương thức:</strong>
                        <?php
                        switch ($order['payment_method']) {
                            case 'cod':
                                echo 'Thanh toán khi nhận hàng (COD)';
                                break;
                            case 'bank':
                                echo 'Chuyển khoản ngân hàng';
                                break;
                            case 'momo':
                                echo 'Ví MoMo';
                                break;
                            case 'vnpay':
                                echo 'VNPay';
                                break;
                        }
                        ?>
                    </p>
                    <p class="mb-1">
                        <strong>Trạng thái:</strong>
                        <span class="badge bg-<?php echo $order['payment_status'] ? 'success' : 'warning'; ?>">
                            <?php echo $order['payment_status'] ? 'Đã thanh toán' : 'Chưa thanh toán'; ?>
                        </span>
                    </p>
                    <?php if ($order['payment_method'] == 'bank' && !$order['payment_status']): ?>
                    <div class="alert alert-info mt-3 mb-0">
                        <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                        <p class="mb-1"><strong>Số tài khoản:</strong> 1234567890</p>
                        <p class="mb-1"><strong>Chủ tài khoản:</strong> CÔNG TY TNHH TECHSTORE</p>
                        <p class="mb-0"><strong>Nội dung:</strong> DH<?php echo $order['id']; ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-timeline {
    position: relative;
    padding: 20px 0;
}

.order-timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 15px;
    height: 100%;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-left: 45px;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    position: absolute;
    left: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.timeline-item.active .timeline-icon {
    background: #28a745;
    color: #fff;
}

.timeline-content h6 {
    margin: 0;
    color: #212529;
}

.timeline-content small {
    color: #6c757d;
}
</style> 