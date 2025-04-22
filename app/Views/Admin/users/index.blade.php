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