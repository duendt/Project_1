<div class="container-fluid">
    <h2 class="mb-4">Quản lý đơn hàng</h2>

    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select">
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
                    <select class="form-select">
                        <option value="">Tất cả</option>
                        <option value="0">Thanh toán khi nhận hàng</option>
                        <option value="1">Chuyển khoản ngân hàng</option>
                        <option value="2">Thanh toán online</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" placeholder="Mã đơn, ID khách hàng...">
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
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Phương thức thanh toán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi tiết đơn hàng -->
<div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đơn hàng #<span id="orderId"></span></h5>
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
                                <p><strong>Tổng tiền:</strong> <span id="orderTotal"></span></p>
                                <p><strong>Phương thức thanh toán:</strong> <span id="paymentMethod"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Chi tiết sản phẩm</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID đơn hàng</th>
                                        <th>ID phiên bản sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="orderItems">
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Tổng cộng:</strong></td>
                                        <td id="total">0đ</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="updateStatusBtn">Cập nhật trạng thái</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cập nhật trạng thái -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" id="statusSelect">
                            <option value="0">Chờ xác nhận</option>
                            <option value="1">Đã xác nhận</option>
                            <option value="2">Đang giao</option>
                            <option value="3">Đã giao</option>
                            <option value="4">Đã hủy</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Cập nhật</button>
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