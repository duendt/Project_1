@extends('layouts.admin')
@section('title', 'Chỉnh sửa thông tin người dùng')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/users' }}" class="btn btn-primary">Quay lại</a>
    @if (isset($_SESSION['message']))
    <div class="alert alert-success">
        {{ $_SESSION['message'] }}
        @php unset($_SESSION['message']); @endphp
    </div>
    @endif

    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {!! $_SESSION['error'] !!}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif

    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa thông tin người dùng</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/users/edit/' . $user->id_user }}">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ $user->address }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                    <select class="form-select" id="role" name="role">
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Người dùng</option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select class="form-select" id="ban" name="ban">
                        <option value="0" {{ $user->ban == 0 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="1" {{ $user->ban == 1 ? 'selected' : '' }}>Tạm khóa</option>
                        <option value="2" {{ $user->ban == 2 ? 'selected' : '' }}>Khóa vĩnh viễn</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection 