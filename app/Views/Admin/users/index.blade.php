@extends('layouts.admin')
@section('title', 'Quản lý người dùng')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý người dùng</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-lg"></i> Thêm người dùng
        </button>
    </div>

    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Vai trò</label>
                    <select class="form-select">
                        <option value="">Tất cả</option>
                        <option value="1">Admin</option>
                        <option value="0">Người dùng</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select">
                        <option value="">Tất cả</option>
                        <option value="0">Hoạt động</option>
                        <option value="1">Bị cấm</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" placeholder="Tên, email, số điện thoại...">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <button type="reset" class="btn btn-secondary">Đặt lại</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách người dùng -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm người dùng -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vai trò</label>
                        <select class="form-select" required>
                            <option value="0">Người dùng</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chỉnh sửa người dùng -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control">
                        <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vai trò</label>
                        <select class="form-select" required>
                            <option value="0">Người dùng</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" required>
                            <option value="0">Hoạt động</option>
                            <option value="1">Bị cấm</option>
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

<!-- Modal Phân quyền -->
<div class="modal fade" id="permissionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phân quyền người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="manageProducts">
                            <label class="form-check-label" for="manageProducts">
                                Quản lý sản phẩm
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="manageOrders">
                            <label class="form-check-label" for="manageOrders">
                                Quản lý đơn hàng
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="manageUsers">
                            <label class="form-check-label" for="manageUsers">
                                Quản lý người dùng
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="manageVouchers">
                            <label class="form-check-label" for="manageVouchers">
                                Quản lý mã giảm giá
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="viewReports">
                            <label class="form-check-label" for="viewReports">
                                Xem báo cáo
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary">Lưu quyền</button>
            </div>
        </div>
    </div>
</div> 
@endsection