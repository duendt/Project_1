@extends('layouts.main')
@section('title', 'Danh sách sản phẩm')
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ APP_URL . 'public/images/' . $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text fw-bold text-danger">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ APP_URL . 'san-pham/' . $product->id_product }}" class="btn btn-primary">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection