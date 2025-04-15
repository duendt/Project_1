@extends('layouts.admin')
@section('title', 'Quản lý người dùng')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý người dùng</h2>
        <a href="{{ APP_URL . 'admin/users/create'}}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm người dùng
        </a>
    </div>
    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Vai trò</label>
                    <select class="form-select" name="role">
                        <option value="">Tất cả</option>
                        <option value="1">Admin</option>
                        <option value="0">Người dùng</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="">Tất cả</option>
                        <option value="0">Hoạt động</option>
                        <option value="1">Bị cấm</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" name="search" placeholder="Tên, email, số điện thoại...">
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
                            <th>Trạng thái</th>
                            <th>Vai trò</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listUsers as $user)
                        <tr>
                            <td>{{ $user->id_user }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->ban == 0 ? 'Hoạt động' : 'Bị cấm' }}</td>
                            <td>{{ $user->role == 1 ? 'Admin' : 'Người dùng' }}</td>
                            <td>
                                <a href="{{ APP_URL . 'admin/users/edit/' . $user->id_user }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection