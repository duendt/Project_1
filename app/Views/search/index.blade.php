@extends('layouts.main')
@section('title', 'Tìm kiếm sản phẩm')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">Kết quả tìm kiếm cho: "{{ $k }}"</h2>
    @if (!$products)
        <p>Không tìm thấy sản phẩm nào phù hợp.</p>
    @else
        <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ APP_URL . 'public/images/' . $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <div class="mb-2">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ APP_URL . 'san-pham/' . $product->id_product }}" class="btn btn-primary">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection