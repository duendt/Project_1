@extends('layouts.admin')
@section('title', 'Quản lý mã giảm giá')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý mã giảm giá</h2>
        <a href="{{ APP_URL . 'admin/vouchers/create'}}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm mã giảm giá
        </a>
    </div>

    @if (isset($_SESSION['confim']))
    <div class="alert alert-success">
        {{ $_SESSION['confim'] }}
        @php unset($_SESSION['confim']); @endphp
    </div>
    @endif

    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" name="search" placeholder="Mã giảm giá...">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <button type="reset" class="btn btn-secondary">Đặt lại</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách mã giảm giá -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã giảm giá</th>
                            <th>Giảm giá (%)</th>
                            <th>Số lượng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listVouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->id_voucher }}</td>
                            <td>{{ $voucher->code }}</td>
                            <td>{{ $voucher->discount }}</td>
                            <td>{{ $voucher->quantity }}</td>
                            <td>
                                <a href="{{ APP_URL . 'admin/vouchers/edit/' . $voucher->id_voucher }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <a href="{{ APP_URL . 'admin/vouchers/usage/' . $voucher->id_voucher }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Chi tiết sử dụng
                                </a>
                                <form action="{{ APP_URL . 'admin/vouchers/delete/' . $voucher->id_voucher }}" method="post" class="d-inline">
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($listVouchers) === 0)
                        <tr>
                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 