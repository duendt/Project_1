@extends('layouts.admin')
@section('title', 'Chi tiết sử dụng mã giảm giá')

@section('content')

<div class="container mt-5">
    <a href="{{ APP_URL . 'admin/vouchers' }}" class="btn btn-primary">Quay lại</a>
    
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết sử dụng mã giảm giá: {{ $voucher->code }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày sử dụng</th>
                            <th>Giá trị đơn hàng</th>
                            <th>Giá trị giảm</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usageDetails as $usage)
                        <tr>
                            <td>{{ $usage->order_id }}</td>
                            <td>{{ $usage->customer_name }}</td>
                            <td>{{ $usage->usage_date }}</td>
                            <td>{{ number_format($usage->order_value) }} VNĐ</td>
                            <td>{{ number_format($usage->discount_value) }} VNĐ</td>
                        </tr>
                        @endforeach
                        
                        @if(count($usageDetails) === 0)
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