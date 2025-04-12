@php
// Kiểm tra tồn tại sản phẩm
if (!isset($product)) {
    header('Location: /404');
    exit;
}
@endphp
@extends('layouts.main')
@section('title', 'Chi tiết sản phẩm')
@section('content')

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="product-images">
                <!-- Main Image -->
                <div class="main-image-container mb-3">
                    <img id="main-product-image" src="" class="img-fluid w-100 border rounded main-image" alt="{{ $product->name }}">
                    <div class="image-zoom-overlay">
                        <i class="fas fa-search-plus"></i>
                    </div>
                </div>
                
                <!-- Thumbnail Images -->
                <div class="thumbnail-container">
                    <div class="thumbnail-slider">
                        @foreach ($colorImages as $image)
                        <div class="thumbnail-item me-2">
                            <img src="{{ APP_URL . 'public/images/' . $image->image }}" 
                                 class="img-fluid thumbnail color-image" 
                                 data-color-id="{{ $image->id_color }}" 
                                 alt="{{ $product->name }}"
                                 onclick="changeMainImage(this)">
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Image Zoom Modal -->
                <div class="modal fade" id="imageZoomModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $product->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="zoomed-image" src="" class="img-fluid zoomed-image" alt="{{ $product->name }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <!-- Price -->
            <div class="mb-4">
                <span id="current-price" class="h3 text-danger">
                    @if(isset($product->display_price))
                        {{ number_format($product->display_price, 0, ',', '.') }}đ
                    @else
                        Liên hệ
                    @endif
                </span>
            </div>

            <!-- Short Description -->
            <div class="mb-4">
                <p>{{ $product->short_description ?? '' }}</p>
            </div>

            <!-- Colors -->
            <div class="mb-4">
                <h5>Màu sắc</h5>
                <div class="btn-group" role="group">
                    @php $uniqueColors = []; @endphp
                    @foreach ($variants as $variant)
                        @if (!in_array($variant->id_color, $uniqueColors))
                            @php $uniqueColors[] = $variant->id_color; @endphp
                            <input type="radio" class="btn-check" name="color" id="color{{ $variant->id_color }}" 
                                  value="{{ $variant->id_color }}" data-color-name="{{ $variant->color_name }}">
                            <label class="btn btn-outline-secondary" for="color{{ $variant->id_color }}">
                                {{ $variant->color_name }}
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Storage -->
            <div class="mb-4" id="storage-options">
                <h5>Dung lượng</h5>
                <div class="btn-group" role="group">
                    @php $uniqueStorages = []; @endphp
                    @foreach ($variants as $variant)
                        @if (!in_array($variant->id_storage, $uniqueStorages))
                            @php $uniqueStorages[] = $variant->id_storage; @endphp
                            <input type="radio" class="btn-check" name="storage" id="storage{{ $variant->id_storage }}" 
                                  value="{{ $variant->id_storage }}" data-storage="{{ $variant->storage }}">
                            <label class="btn btn-outline-primary" for="storage{{ $variant->id_storage }}">
                                {{ $variant->storage }}
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Hidden Variants Data -->
            <div id="variants-data" style="display: none;" 
                 data-variants="{{ json_encode($variants) }}"
                 data-product-id="{{ $product->id_product }}"></div>

            <!-- Quantity -->
            <div class="mb-4">
                <h5>Số lượng</h5>
                <div class="input-group" style="width: 150px;">
                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(-1)">-</button>
                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1">
                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(1)">+</button>
                </div>
            </div>

            <!-- Add to Cart -->
            <div class="d-grid gap-2">
                <button class="btn btn-danger" onclick="addToCart()">
                    <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-bolt me-2"></i>Mua ngay
                </button>
            </div>

            <!-- Product Features -->
            <div class="mt-4">
                <h5>Đặc điểm nổi bật</h5>
                <ul class="list-unstyled">
                    @foreach ($product->features ?? [] as $feature)
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button">
                        Thông số kỹ thuật
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
                        Mô tả sản phẩm
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button">
                        Đánh giá
                    </button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0" id="productTabContent">
                <div class="tab-pane fade show active" id="specification">
                    <table class="table table-striped">
                        <tbody id="specifications-table">
                            <tr>
                                <th style="width: 30%">CPU</th>
                                <td id="spec-cpu">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>RAM</th>
                                <td id="spec-ram">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>GPU</th>
                                <td id="spec-gpu">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>Màn hình</th>
                                <td id="spec-screen">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>Hệ điều hành</th>
                                <td id="spec-os">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>Camera</th>
                                <td id="spec-camera">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>Pin</th>
                                <td id="spec-battery">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>Màu sắc</th>
                                <td id="spec-color">Đang tải...</td>
                            </tr>
                            <tr>
                                <th>Dung lượng</th>
                                <td id="spec-storage">Đang tải...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="description">
                    {{ $product->description ?? '' }}
                </div>
                <div class="tab-pane fade" id="review">
                    <!-- Review Form -->
                    <div class="mb-4">
                        <h5>Viết đánh giá của bạn</h5>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Đánh giá</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nhận xét của bạn</label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                    </div>

                    <!-- Review List -->
                    <div class="review-list">
                        @foreach ($product->reviews ?? [] as $review)
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>{{ $review->user_name }}</h6>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->date }}</small>
                            </div>
                            <p class="mt-2 mb-0">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
// Lấy dữ liệu biến thể
let variantsDataRaw = document.getElementById('variants-data').getAttribute('data-variants');
let variantsData = [];

try {
    variantsData = JSON.parse(variantsDataRaw);
    console.log('Dữ liệu biến thể ban đầu (JSON):', variantsDataRaw);
    console.log('Dữ liệu biến thể sau khi parse:', variantsData);
} catch (error) {
    console.error('Lỗi khi parse dữ liệu JSON:', error);
    console.log('Chuỗi JSON gốc:', variantsDataRaw);
}

let selectedVariant = null;
let selectedColorId = null;
let selectedStorageId = null;

// Debug - Hiển thị dữ liệu biến thể trong console
console.log('Dữ liệu biến thể ban đầu:', variantsData);

// Thêm xử lý dữ liệu biến thể ngay khi trang tải
function processVariantData() {
    if (!variantsData || variantsData.length === 0) {
        console.error('Không có dữ liệu biến thể!');
        return;
    }
    
    // Đảm bảo price trong biến thể là số và hợp lệ
    variantsData = variantsData.map(variant => {
        // Chuyển đổi ID sang số nguyên
        variant.id_color = parseInt(variant.id_color);
        variant.id_storage = parseInt(variant.id_storage);
        variant.id_product = parseInt(variant.id_product);
        variant.id_prodvar = parseInt(variant.id_prodvar);
        
        // Xử lý giá
        let price = null;
        if (variant.price && !isNaN(parseFloat(variant.price)) && parseFloat(variant.price) > 0) {
            price = parseFloat(variant.price);
        }
        
        return {
            ...variant,
            price: price
        };
    });
    
    // Lọc ra các biến thể không có giá hoặc giá <= 0
    variantsData = variantsData.filter(variant => variant.price !== null && variant.price > 0);
    
    console.log('Dữ liệu biến thể sau khi xử lý:', variantsData);
    
    // Kiểm tra nếu không còn biến thể nào sau khi lọc
    if (variantsData.length === 0) {
        console.error('Không có biến thể nào có giá hợp lệ!');
    }
}

// Hàm khởi tạo ban đầu
function initProductDetails() {
    // Xử lý dữ liệu biến thể
    processVariantData();
    
    // Chọn màu sắc đầu tiên
    const firstColor = document.querySelector('input[name="color"]');
    if (firstColor) {
        firstColor.checked = true;
        selectedColorId = firstColor.value;
        console.log('Màu sắc được chọn ban đầu:', selectedColorId);
        updateAvailableStorage(selectedColorId);
        updateProductImage(selectedColorId);
    }

    // Thêm sự kiện cho các nút chọn màu
    document.querySelectorAll('input[name="color"]').forEach(radio => {
        radio.addEventListener('change', function() {
            selectedColorId = this.value;
            console.log('Thay đổi màu sắc:', selectedColorId);
            updateAvailableStorage(selectedColorId);
            updateProductImage(selectedColorId);
        });
    });

    // Thêm sự kiện cho các nút chọn dung lượng
    document.querySelectorAll('input[name="storage"]').forEach(radio => {
        radio.addEventListener('change', function() {
            selectedStorageId = this.value;
            console.log('Thay đổi dung lượng:', selectedStorageId);
            updateProductPrice();
        });
    });

    // Thêm sự kiện cho hình ảnh
    document.querySelectorAll('.color-image').forEach(img => {
        img.addEventListener('click', function() {
            const colorId = this.getAttribute('data-color-id');
            document.querySelector(`input[name="color"][value="${colorId}"]`).checked = true;
            selectedColorId = colorId;
            console.log('Chọn màu sắc từ hình ảnh:', selectedColorId);
            updateAvailableStorage(selectedColorId);
            updateProductImage(selectedColorId);
        });
    });
    
    // Khởi tạo thông số kỹ thuật ngay lập tức (vì đây là tab mặc định)
    initSpecifications();
    
    // Thêm sự kiện click cho tab mô tả sản phẩm
    document.getElementById('description-tab').addEventListener('click', function() {
        // Logic bổ sung nếu cần khi chọn tab mô tả
    });
}

// Cập nhật các tùy chọn dung lượng dựa trên màu đã chọn
function updateAvailableStorage(colorId) {
    // Lọc các biến thể theo màu sắc đã chọn
    const availableVariants = variantsData.filter(variant => variant.id_color == colorId);
    console.log('Các biến thể có sẵn cho màu sắc', colorId, ':', availableVariants);
    
    // Lấy các dung lượng có sẵn cho màu sắc này
    const availableStorages = [...new Set(availableVariants.map(variant => variant.id_storage))];
    console.log('Các dung lượng có sẵn:', availableStorages);
    
    // Ẩn tất cả các nút dung lượng
    document.querySelectorAll('input[name="storage"]').forEach(radio => {
        radio.disabled = true;
        radio.parentElement.style.display = 'none';
    });
    
    // Hiển thị và kích hoạt các nút dung lượng có sẵn
    availableStorages.forEach(storageId => {
        const radio = document.querySelector(`input[name="storage"][value="${storageId}"]`);
        if (radio) {
            radio.disabled = false;
            radio.parentElement.style.display = 'inline-block';
        }
    });
    
    // Chọn dung lượng đầu tiên nếu có
    const firstStorage = document.querySelector('input[name="storage"]:not([disabled])');
    if (firstStorage) {
        firstStorage.checked = true;
        selectedStorageId = firstStorage.value;
        console.log('Dung lượng được chọn tự động:', selectedStorageId);
        updateProductPrice();
    } else {
        // Nếu không có dung lượng nào khả dụng
        selectedStorageId = null;
        document.getElementById('current-price').textContent = 'Không khả dụng';
    }
}

// Cập nhật giá dựa trên màu và dung lượng đã chọn
function updateProductPrice() {
    if (!selectedColorId || !selectedStorageId) {
        console.log('Chưa chọn màu sắc hoặc dung lượng');
        return;
    }
    
    console.log('Đang tìm biến thể với màu:', selectedColorId, 'và dung lượng:', selectedStorageId);
    
    // Đảm bảo dữ liệu ID là số
    const colorId = parseInt(selectedColorId);
    const storageId = parseInt(selectedStorageId);
    
    // Tìm biến thể phù hợp với màu sắc và dung lượng đã chọn
    const variant = variantsData.find(v => 
        v.id_color === colorId && 
        v.id_storage === storageId
    );
    
    console.log('Biến thể được chọn:', variant);
    
    if (variant) {
        selectedVariant = variant;
        
        // Đảm bảo price là một số hợp lệ
        let price = 0;
        
        // Kiểm tra trường hợp giá nằm trong biến thể
        if (variant.price && variant.price > 0) {
            price = variant.price;
            console.log('Sử dụng giá từ biến thể:', price);
        } else {
            console.log('Không tìm thấy giá hợp lệ');
            document.getElementById('current-price').textContent = 'Liên hệ';
            return;
        }
        
        // Cập nhật giá hiện tại
        const formattedPrice = new Intl.NumberFormat('vi-VN').format(price) + 'đ';
        console.log('Giá mới:', formattedPrice, '(', price, ')');
        document.getElementById('current-price').textContent = formattedPrice;
        
        // Cập nhật thông số kỹ thuật
        updateSpecifications(variant);
    } else {
        console.log('Không tìm thấy biến thể phù hợp');
        document.getElementById('current-price').textContent = 'Không khả dụng';
    }
}

// Cập nhật thông số kỹ thuật dựa trên biến thể được chọn
function updateSpecifications(variant) {
    if (!variant) return;
    
    console.log('Cập nhật thông số kỹ thuật cho biến thể:', variant);
    
    // Cập nhật các thông số
    document.getElementById('spec-cpu').textContent = variant.cpu || 'Không có thông tin';
    document.getElementById('spec-ram').textContent = variant.ram || 'Không có thông tin';
    document.getElementById('spec-gpu').textContent = variant.gpu || 'Không có thông tin';
    document.getElementById('spec-screen').textContent = variant.screen || 'Không có thông tin';
    document.getElementById('spec-os').textContent = variant.operating_system || 'Không có thông tin';
    document.getElementById('spec-camera').textContent = variant.camera || 'Không có thông tin';
    document.getElementById('spec-battery').textContent = variant.battery || 'Không có thông tin';
    document.getElementById('spec-color').textContent = variant.color_name || 'Không có thông tin';
    document.getElementById('spec-storage').textContent = variant.storage || 'Không có thông tin';
}

// Hàm khởi tạo thông số ban đầu
function initSpecifications() {
    // Nếu đã có biến thể được chọn, hiển thị thông số của nó
    if (selectedVariant) {
        updateSpecifications(selectedVariant);
    } else if (variantsData && variantsData.length > 0) {
        // Nếu chưa, hiển thị thông số của biến thể đầu tiên
        updateSpecifications(variantsData[0]);
    }
}

// Cập nhật hình ảnh chính theo màu đã chọn
function updateProductImage(colorId) {
    document.querySelectorAll('.color-image').forEach(img => {
        if (img.getAttribute('data-color-id') === colorId) {
            // Cập nhật ảnh chính
            changeMainImage(img);
            // Đánh dấu thumbnail được chọn
            img.classList.add('active');
        } else {
            img.classList.remove('active');
        }
    });
}

// Thay đổi ảnh chính
function changeMainImage(thumbnail) {
    // Lấy URL ảnh từ thumbnail
    const imageUrl = thumbnail.getAttribute('src');
    
    // Cập nhật ảnh chính
    const mainImage = document.getElementById('main-product-image');
    mainImage.setAttribute('src', imageUrl);
    
    // Cập nhật ảnh phóng to
    document.getElementById('zoomed-image').setAttribute('src', imageUrl);
    
    // Cập nhật class active cho thumbnail
    document.querySelectorAll('.thumbnail').forEach(img => {
        img.classList.remove('active');
    });
    thumbnail.classList.add('active');
}

// Khởi tạo ảnh chính khi trang tải
function initProductImages() {
    // Chọn ảnh đầu tiên làm ảnh chính
    const firstThumbnail = document.querySelector('.color-image');
    if (firstThumbnail) {
        changeMainImage(firstThumbnail);
    }
    
    // Thêm sự kiện click cho nút zoom
    document.querySelector('.image-zoom-overlay').addEventListener('click', function() {
        // Mở modal phóng to
        const zoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        zoomModal.show();
    });
    
    // Thêm sự kiện click cho ảnh chính
    document.getElementById('main-product-image').addEventListener('click', function() {
        // Mở modal phóng to
        const zoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        zoomModal.show();
    });
}

function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + change;
    
    if (newValue >= 1) {
        quantityInput.value = newValue;
    }
}

function addToCart() {
    if (!selectedVariant) {
        alert('Vui lòng chọn màu sắc và dung lượng!');
        return;
    }
    
    const quantity = parseInt(document.getElementById('quantity').value);
    
    // Call API to add product to cart
    fetch('/api/cart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            product_id: selectedVariant.id_product,
            variant_id: selectedVariant.id_prodvar,
            quantity: quantity
        })
    })
    .then(response => {
        if (response.status === 401) {
            // Người dùng chưa đăng nhập
            if (confirm('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng. Đến trang đăng nhập ngay?')) {
                window.location.href = '/dang-nhap';
            }
            return null;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            alert('Đã thêm sản phẩm vào giỏ hàng!');
            // Update cart count in header
            updateCartCount();
        } else if (data) {
            alert(data.error || 'Có lỗi xảy ra. Vui lòng thử lại!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại!');
    });
}

function updateCartCount() {
    // Update cart badge count
    const cartBadge = document.querySelector('.cart-badge');
    if (cartBadge) {
        const currentCount = parseInt(cartBadge.textContent || '0');
        cartBadge.textContent = currentCount + 1;
    }
}

// Khởi tạo khi trang tải xong
document.addEventListener('DOMContentLoaded', function() {
    initProductDetails();
    initProductImages();
});
</script>
@endsection
@section('styles')
<style>
/* Product Images */
.product-images .main-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    background-color: #f8f9fa;
    text-align: center;
    height: 400px;
}

.product-images .main-image {
    object-fit: contain;
    height: 100%;
    width: 100%;
    transition: transform 0.3s ease;
}

.product-images .main-image:hover {
    transform: scale(1.05);
}

.image-zoom-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(255, 255, 255, 0.7);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    opacity: 0;
}

.main-image-container:hover .image-zoom-overlay {
    opacity: 1;
}

.image-zoom-overlay:hover {
    background-color: rgba(255, 255, 255, 0.9);
    transform: scale(1.1);
}

.zoomed-image {
    max-height: 80vh;
    object-fit: contain;
}

.thumbnail-container {
    position: relative;
    padding: 0;
}

.thumbnail-slider {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 10px 0;
    -ms-overflow-style: none;  /* Hide scrollbar IE and Edge */
    scrollbar-width: none;  /* Hide scrollbar Firefox */
}

.thumbnail-slider::-webkit-scrollbar {
    display: none; /* Hide scrollbar Chrome, Safari, Opera */
}

.thumbnail-item {
    flex: 0 0 80px;
    height: 80px;
    border-radius: 5px;
    overflow: hidden;
    position: relative;
    border: 1px solid #dee2e6;
    margin-right: 10px;
}

.thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: all 0.2s ease;
}

.thumbnail:hover {
    opacity: 0.8;
    transform: scale(1.1);
}

.thumbnail.active {
    border: 2px solid #0d6efd;
}

/* Rating System */
.rating {
    display: inline-flex;
    flex-direction: row-reverse;
}

.rating input {
    display: none;
}

.rating label {
    cursor: pointer;
    color: #ddd;
    font-size: 1.5rem;
    padding: 0 0.1em;
}

.rating input:checked ~ label {
    color: #ffd700;
}

.rating label:hover,
.rating label:hover ~ label {
    color: #ffd700;
}

.original-price {
    color: #6c757d;
    text-decoration: line-through;
    font-size: 0.9em;
}

.product-card {
    transition: transform 0.2s;
}

.product-card:hover {
    transform: translateY(-5px);
}
</style> 
@endsection