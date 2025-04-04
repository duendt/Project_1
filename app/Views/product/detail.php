<?php
// Kiểm tra tồn tại sản phẩm
if (!isset($product)) {
    header('Location: /404');
    exit;
}
?>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/san-pham">Sản phẩm</a></li>
            <li class="breadcrumb-item active"><?php echo $product['name']; ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="product-images">
                <div class="main-image mb-3">
                    <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="thumbnail-images row g-2">
                    <?php foreach ($product['gallery'] ?? [] as $image): ?>
                    <div class="col-3">
                        <img src="<?php echo $image; ?>" class="img-fluid thumbnail" alt="<?php echo $product['name']; ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h1 class="mb-3"><?php echo $product['name']; ?></h1>
            
            <!-- Price -->
            <div class="mb-4">
                <span class="h3 text-danger"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                <?php if ($product['original_price']): ?>
                <span class="text-decoration-line-through ms-2"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>đ</span>
                <?php endif; ?>
            </div>

            <!-- Short Description -->
            <div class="mb-4">
                <p><?php echo $product['short_description'] ?? ''; ?></p>
            </div>

            <!-- Variants -->
            <?php if (!empty($product['variants'])): ?>
            <div class="mb-4">
                <h5>Phiên bản</h5>
                <div class="btn-group" role="group">
                    <?php foreach ($product['variants'] as $variant): ?>
                    <input type="radio" class="btn-check" name="variant" id="variant<?php echo $variant['id']; ?>" value="<?php echo $variant['id']; ?>">
                    <label class="btn btn-outline-primary" for="variant<?php echo $variant['id']; ?>">
                        <?php echo $variant['name']; ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Colors -->
            <?php if (!empty($product['colors'])): ?>
            <div class="mb-4">
                <h5>Màu sắc</h5>
                <div class="btn-group" role="group">
                    <?php foreach ($product['colors'] as $color): ?>
                    <input type="radio" class="btn-check" name="color" id="color<?php echo $color['id']; ?>" value="<?php echo $color['id']; ?>">
                    <label class="btn btn-outline-secondary" for="color<?php echo $color['id']; ?>">
                        <?php echo $color['name']; ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

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
                    <?php foreach ($product['features'] ?? [] as $feature): ?>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i><?php echo $feature; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
                        Mô tả sản phẩm
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button">
                        Thông số kỹ thuật
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button">
                        Đánh giá
                    </button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0" id="productTabContent">
                <div class="tab-pane fade show active" id="description">
                    <?php echo $product['description'] ?? ''; ?>
                </div>
                <div class="tab-pane fade" id="specification">
                    <table class="table">
                        <tbody>
                            <?php foreach ($product['specifications'] ?? [] as $spec): ?>
                            <tr>
                                <th style="width: 30%"><?php echo $spec['name']; ?></th>
                                <td><?php echo $spec['value']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="review">
                    <!-- Review Form -->
                    <div class="mb-4">
                        <h5>Viết đánh giá của bạn</h5>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Đánh giá</label>
                                <div class="rating">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>">
                                    <label for="star<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                                    <?php endfor; ?>
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
                        <?php foreach ($product['reviews'] ?? [] as $review): ?>
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6><?php echo $review['user_name']; ?></h6>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <small class="text-muted"><?php echo $review['date']; ?></small>
                            </div>
                            <p class="mt-2 mb-0"><?php echo $review['comment']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Sản phẩm liên quan</h3>
            <div class="row">
                <?php foreach ($related_products ?? [] as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <div class="mb-2">
                                <span class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                                <?php if ($product['original_price']): ?>
                                <span class="original-price ms-2"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-outline-danger btn-sm" onclick="addToCart(<?php echo $product['id']; ?>)">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                </button>
                                <a href="/san-pham/<?php echo $product['slug']; ?>" class="btn btn-link btn-sm">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + change;
    
    if (newValue >= 1) {
        quantityInput.value = newValue;
    }
}

function addToCart() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const variantId = document.querySelector('input[name="variant"]:checked')?.value;
    const colorId = document.querySelector('input[name="color"]:checked')?.value;
    
    // Call API to add product to cart
    fetch('/api/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: <?php echo $product['id']; ?>,
            quantity: quantity,
            variant_id: variantId,
            color_id: colorId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Đã thêm sản phẩm vào giỏ hàng!');
            // Update cart count in header
            updateCartCount();
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
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
</script>

<style>
.product-images .thumbnail {
    cursor: pointer;
    transition: opacity 0.2s;
}

.product-images .thumbnail:hover {
    opacity: 0.8;
}

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