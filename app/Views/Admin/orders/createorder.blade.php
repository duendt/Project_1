@extends('layouts.admin')
@section('title', 'Tạo đơn hàng mới')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tạo đơn hàng mới</h2>
        <a href="{{ APP_URL . 'admin/order' }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    @if (isset($_SESSION['error']))
    <div class="alert alert-danger">
        {{ $_SESSION['error'] }}
        @php unset($_SESSION['error']); @endphp
    </div>
    @endif

    <form action="{{ APP_URL . 'admin/order/store' }}" method="post" id="createOrderForm">
        <div class="row">
            <!-- Thông tin khách hàng -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Chọn khách hàng</label>
                            <select class="form-select" name="id_user" required>
                                <option value="">-- Chọn khách hàng --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id_user }}">{{ $user->user_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ giao hàng</label>
                            <textarea class="form-control" name="address" rows="3" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Thông tin thanh toán -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Phương thức thanh toán</label>
                            <select class="form-select" name="pay_method" required>
                                <option value="0">Thanh toán khi nhận hàng</option>
                                <option value="1">Thanh toán online</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea class="form-control" name="note" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Danh sách sản phẩm</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="productTable">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Phiên bản</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sản phẩm sẽ được thêm vào đây bằng JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Tổng tiền:</strong></td>
                                        <td colspan="2"><strong id="totalAmount">0 VNĐ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Tạo đơn hàng
            </button>
        </div>
    </form>
</div>

<!-- Modal thêm sản phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Sản phẩm</label>
                    <select class="form-select" id="productSelect">
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id_product }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phiên bản</label>
                    <select class="form-select" id="variantSelect" disabled>
                        <option value="">-- Chọn phiên bản --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="text" class="form-control" id="priceInput" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số lượng</label>
                    <input type="number" class="form-control" id="quantityInput" min="1" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="addProductBtn">Thêm</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let products = <?php echo json_encode($products ?? []); ?>;
let variants = <?php echo json_encode($variants ?? []); ?>;
let selectedProducts = [];

document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('productSelect');
    const variantSelect = document.getElementById('variantSelect');
    const priceInput = document.getElementById('priceInput');
    const quantityInput = document.getElementById('quantityInput');
    const addProductBtn = document.getElementById('addProductBtn');
    const productTable = document.getElementById('productTable').getElementsByTagName('tbody')[0];
    const totalAmountElement = document.getElementById('totalAmount');

    // Xử lý khi chọn sản phẩm
    productSelect.addEventListener('change', function() {
        const productId = this.value;
        variantSelect.innerHTML = '<option value="">-- Chọn phiên bản --</option>';
        priceInput.value = '';
        
        if (productId) {
            variantSelect.disabled = false;
            const productVariants = variants.filter(v => v.id_product == productId);
            productVariants.forEach(variant => {
                const option = document.createElement('option');
                option.value = variant.id_prodvar;
                option.textContent = `${variant.color_name} - ${variant.storage}`;
                option.dataset.price = variant.price;
                variantSelect.appendChild(option);
            });
        } else {
            variantSelect.disabled = true;
        }
    });

    // Xử lý khi chọn phiên bản
    variantSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        priceInput.value = selectedOption.dataset.price ? 
            new Intl.NumberFormat('vi-VN').format(selectedOption.dataset.price) + ' VNĐ' : '';
    });

    // Xử lý khi thêm sản phẩm
    addProductBtn.addEventListener('click', function() {
        const productId = productSelect.value;
        const variantId = variantSelect.value;
        const quantity = parseInt(quantityInput.value);

        if (!productId || !variantId || !quantity) {
            alert('Vui lòng chọn đầy đủ thông tin sản phẩm');
            return;
        }

        const variant = variants.find(v => v.id_prodvar == variantId);
        const product = products.find(p => p.id_product == productId);

        // Kiểm tra xem sản phẩm đã được thêm chưa
        const existingProduct = selectedProducts.find(p => p.id_prodvar == variantId);
        if (existingProduct) {
            existingProduct.quantity += quantity;
        } else {
            selectedProducts.push({
                id_prodvar: variantId,
                product_name: product.product_name,
                variant_name: `${variant.color_name} - ${variant.storage}`,
                price: variant.price,
                quantity: quantity
            });
        }

        updateProductTable();
        updateTotalAmount();

        // Reset form
        productSelect.value = '';
        variantSelect.value = '';
        variantSelect.disabled = true;
        priceInput.value = '';
        quantityInput.value = '1';

        // Đóng modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
        modal.hide();
    });

    // Cập nhật bảng sản phẩm
    function updateProductTable() {
        productTable.innerHTML = '';
        selectedProducts.forEach((product, index) => {
            const row = productTable.insertRow();
            row.innerHTML = `
                <td>${product.product_name}</td>
                <td>${product.variant_name}</td>
                <td>${new Intl.NumberFormat('vi-VN').format(product.price)} VNĐ</td>
                <td>
                    <div class="input-group input-group-sm">
                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                        <input type="number" class="form-control text-center" value="${product.quantity}" min="1" 
                            onchange="updateQuantity(${index}, this.value - ${product.quantity})">
                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                </td>
                <td>${new Intl.NumberFormat('vi-VN').format(product.price * product.quantity)} VNĐ</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
        });

        // Thêm input hidden cho form
        updateHiddenInputs();
    }

    // Cập nhật tổng tiền
    function updateTotalAmount() {
        const total = selectedProducts.reduce((sum, product) => sum + (product.price * product.quantity), 0);
        totalAmountElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' VNĐ';
    }

    // Cập nhật số lượng sản phẩm
    window.updateQuantity = function(index, change) {
        const product = selectedProducts[index];
        const newQuantity = product.quantity + change;
        
        if (newQuantity > 0) {
            product.quantity = newQuantity;
            updateProductTable();
            updateTotalAmount();
        }
    };

    // Xóa sản phẩm
    window.removeProduct = function(index) {
        selectedProducts.splice(index, 1);
        updateProductTable();
        updateTotalAmount();
    };

    // Cập nhật input hidden cho form
    function updateHiddenInputs() {
        // Xóa các input hidden cũ
        const oldInputs = document.querySelectorAll('input[name^="products"]');
        oldInputs.forEach(input => input.remove());

        // Thêm input hidden mới
        selectedProducts.forEach((product, index) => {
            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = `products[${index}][id_prodvar]`;
            productInput.value = product.id_prodvar;
            document.getElementById('createOrderForm').appendChild(productInput);

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = `products[${index}][quantity]`;
            quantityInput.value = product.quantity;
            document.getElementById('createOrderForm').appendChild(quantityInput);
        });
    }

    // Validate form trước khi submit
    document.getElementById('createOrderForm').addEventListener('submit', function(e) {
        if (selectedProducts.length === 0) {
            e.preventDefault();
            alert('Vui lòng thêm ít nhất một sản phẩm vào đơn hàng');
        }
    });
});
</script>
@endsection 