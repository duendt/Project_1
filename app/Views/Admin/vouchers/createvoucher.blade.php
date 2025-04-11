@extends('layouts.admin')
@section('title', 'Thêm mã giảm giá mới')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/vouchers' }}" class="btn btn-primary">Quay lại</a>
    @if (isset($_SESSION['message']))
    <div class="alert alert-success">
        {{ $_SESSION['message'] }}
        @php unset($_SESSION['message']); @endphp
    </div>
    @endif

    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {{ $_SESSION['error'] }}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif

    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm mã giảm giá mới</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ APP_URL . 'admin/vouchers/create' }}">
                <div class="mb-3">
                    <label for="code" class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="code" name="code">
                </div>
                <div class="mb-3">
                    <label for="discount" class="form-label">Giảm giá (%) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="discount" name="discount" min="1" max="100">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1">
                </div>
                <button type="submit" class="btn btn-primary">Lưu mã giảm giá</button>
            </form>
        </div>
    </div>
</div>
@endsection 