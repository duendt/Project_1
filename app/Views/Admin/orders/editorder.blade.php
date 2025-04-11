@extends('layouts.admin')
@section('title', 'Chỉnh sửa đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chỉnh sửa đơn hàng #{{ $isOrder->id_order }}</h2>
        <a href="{{ APP_URL . 'admin/order' }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
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

    <form method="POST" action="{{ APP_URL . 'admin/order/update/' . $isOrder->id_order }}" id="editOrderForm">
        <div class="row">
            <!-- Thông tin khách hàng -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" value="{{ $isOrder->buyer_name }}" name="buyer_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" value="{{ $isOrder->phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" rows="3">{{ $isOrder->address }}</textarea>
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
                            <label class="form-label">Trạng thái đơn hàng <span class="text-danger">*</span></label>
                            <select class="form-select" name="status">
                                <option value="0" {{ $isOrder->status == 0 ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="1" {{ $isOrder->status == 1 ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="2" {{ $isOrder->status == 2 ? 'selected' : '' }}>Đang giao</option>
                                <option value="3" {{ $isOrder->status == 3 ? 'selected' : '' }}>Đã giao</option>
                                <option value="4" {{ $isOrder->status == 4 ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <select class="form-select" name="pay_method">
                                <option value="0" {{ $isOrder->pay_method == 0 ? 'selected' : '' }}>Thanh toán khi nhận hàng</option>
                                <option value="1" {{ $isOrder->pay_method == 1 ? 'selected' : '' }}>Thanh toán online</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea class="form-control" name="notes" rows="3">{{ $isOrder->notes ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Cập nhật đơn hàng
                    </button>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="col-md-8" style="margin-left: auto;">
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
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach ($listDetail as $detail)
                                    <tr>
                                        @php
                                        $productInfo = null;
                                        foreach ($listVariant as $variant) {
                                        if ($detail->id_prodvar == $variant->id_prodvar) {
                                        $productInfo = $variant;
                                        break;
                                        }
                                        }
                                        $total += $detail->price * $detail->quantity;
                                        @endphp

                                        <td>{{ $productInfo ? $productInfo->product_name : 'N/A' }}</td>
                                        <td>{{ $productInfo ? $productInfo->color_name . ' - ' . $productInfo->storage : 'N/A' }}</td>
                                        <td>{{ number_format($detail->price) }} VNĐ</td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <button type="button" class="btn btn-outline-secondary decrease-btn" data-id="{{ $detail->id_orderdetail }}">-</button>
                                                <input type="number" class="form-control text-center quantity-input" value="{{ $detail->quantity }}" min="1" data-id="{{ $detail->id_orderdetail }}" readonly>
                                                <button type="button" class="btn btn-outline-secondary increase-btn" data-id="{{ $detail->id_orderdetail }}">+</button>
                                            </div>
                                        </td>
                                        <td class="subtotal">{{ number_format($detail->price * $detail->quantity) }} VNĐ</td>
                                        <td>
                                            <form method="POST" action="{{ APP_URL . 'admin/order/remove-product/' . $detail->id_orderdetail }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Tổng tiền:</strong></td>
                                        <td colspan="2"><strong id="totalAmount">{{ number_format($total) }} VNĐ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
            <form method="POST" action="{{ APP_URL . 'admin/order/add-product/' . $isOrder->id_order }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sản phẩm</label>
                        <select class="form-select" id="productSelect" required>
                            <option value="">-- Chọn sản phẩm --</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id_product }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phiên bản</label>
                        <select class="form-select" id="variantSelect" name="id_variant" required>
                            <option value="">-- Chọn phiên bản --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="text" class="form-control" id="priceInput" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="quantityInput" name="quantity" min="1" value="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khai báo các elements
        const productSelect = document.getElementById('productSelect');
        const variantSelect = document.getElementById('variantSelect');
        const priceInput = document.getElementById('priceInput');
        const decreaseBtns = document.querySelectorAll('.decrease-btn');
        const increaseBtns = document.querySelectorAll('.increase-btn');
        const quantityInputs = document.querySelectorAll('.quantity-input');

        // Dữ liệu từ server
        const variants = <?php echo json_encode($listVariant ?? []); ?>;

        // Xử lý khi chọn sản phẩm
        productSelect.addEventListener('change', function() {
            const productId = this.value;
            variantSelect.innerHTML = '<option value="">-- Chọn phiên bản --</option>';
            priceInput.value = ''; // Reset giá

            if (productId) {
                const productVariants = variants.filter(v => v.id_product == productId);
                productVariants.forEach(variant => {
                    const option = document.createElement('option');
                    option.value = variant.id_prodvar;
                    option.textContent = `${variant.color_name} - ${variant.storage}`;
                    option.dataset.price = variant.price;
                    variantSelect.appendChild(option);
                });
            }
        });

        // Xử lý khi chọn variant
        variantSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.dataset.price) {
                priceInput.value = new Intl.NumberFormat('vi-VN').format(selectedOption.dataset.price) + ' VNĐ';
            } else {
                priceInput.value = '';
            }
        });

        // Xử lý nút giảm số lượng
        decreaseBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const detailId = this.dataset.id;
                const input = this.parentNode.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);

                if (currentValue > 1) {
                    updateQuantity(detailId, currentValue - 1, input);
                }
            });
        });

        // Xử lý nút tăng số lượng
        increaseBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const detailId = this.dataset.id;
                const input = this.parentNode.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);

                updateQuantity(detailId, currentValue + 1, input);
            });
        });

        // Hàm cập nhật số lượng qua AJAX
        function updateQuantity(detailId, newQuantity, inputElement) {
            // Hiển thị loading
            inputElement.value = '...';

            // Cập nhật UI trước khi gửi request
            const row = inputElement.closest('tr');
            const priceText = row.querySelector('td:nth-child(3)').textContent;
            const price = parseFloat(priceText.replace(/[^\d]/g, ''));
            const subtotal = price * newQuantity;

            // Cập nhật thành tiền ngay lập tức
            row.querySelector('.subtotal').textContent = new Intl.NumberFormat('vi-VN').format(subtotal) + ' VNĐ';

            // Cập nhật tổng tiền ngay lập tức
            updateTotal();

            // Tạo request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ APP_URL }}' + 'admin/order/update-quantity/' + detailId, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.status >= 200 && this.status < 300) {
                    try {
                        const response = JSON.parse(this.responseText);
                        // Cập nhật giá trị số lượng
                        inputElement.value = newQuantity;

                        // Hiển thị thông báo lỗi nếu có
                        if (!response.success) {
                            console.warn('Lỗi không dừng thực thi:', response.message);
                        }
                    } catch (e) {
                        console.error('Lỗi phân tích JSON:', e);
                        // Vẫn cập nhật UI
                        inputElement.value = newQuantity;
                    }
                } else {
                    // Vẫn cập nhật UI
                    inputElement.value = newQuantity;
                    console.error('Lỗi HTTP:', this.status);
                }
            };

            xhr.onerror = function() {
                // Vẫn cập nhật UI
                inputElement.value = newQuantity;
                console.error('Lỗi kết nối mạng');
            };

            // Gửi request
            xhr.send('quantity=' + newQuantity);
        }

        // Hàm cập nhật tổng tiền
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(cell => {
                const subtotalText = cell.textContent;
                const subtotal = parseFloat(subtotalText.replace(/[^\d]/g, ''));
                total += subtotal;
            });

            document.getElementById('totalAmount').textContent = new Intl.NumberFormat('vi-VN').format(total) + ' VNĐ';
        }
    });
</script>
@endsection