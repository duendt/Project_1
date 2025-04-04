<div class="container-fluid">
    <h2 class="mb-4">Quản lý giỏ hàng</h2>

    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" placeholder="ID giỏ hàng, ID khách hàng...">
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
                            <th>ID phiên bản SP</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi tiết giỏ hàng -->
<div class="modal fade" id="cartDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết giỏ hàng #<span id="cartId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Thông tin khách hàng -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Thông tin khách hàng</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID khách hàng:</strong> <span id="customerId"></span></p>
                                <p><strong>Họ tên:</strong> <span id="customerName"></span></p>
                                <p><strong>Email:</strong> <span id="customerEmail"></span></p>
                                <p><strong>Số điện thoại:</strong> <span id="customerPhone"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Địa chỉ:</strong> <span id="customerAddress"></span></p>
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
                                <p><strong>ID phiên bản:</strong> <span id="prodVarId"></span></p>
                                <p><strong>Tên sản phẩm:</strong> <span id="productName"></span></p>
                                <p><strong>Màu sắc:</strong> <span id="productColor"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Dung lượng:</strong> <span id="productStorage"></span></p>
                                <p><strong>Giá:</strong> <span id="productPrice"></span></p>
                                <p><strong>Số lượng:</strong> <span id="productQuantity"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="convertToOrderBtn">Chuyển thành đơn hàng</button>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-left: 50px;
    margin-bottom: 20px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d6efd;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-item .time {
    font-size: 0.875rem;
    color: #6c757d;
}

.timeline-item .content {
    margin-top: 5px;
}
</style> 