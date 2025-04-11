<?php

namespace App\Controller\AdminController;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Product;

class OrderController
{
    public function index()
    {
        // Truy vấn lấy danh sách đơn hàng
        $listOrders = Order::all();
        $listDetail = OrderDetail::all();
        $listVariant = ProductVariant::select(['product_variant.*', 'products.name as product_name', 'color.name as color_name', 'storage.storage'])
            ->join('products', 'products.id_product', 'product_variant.id_product')
            ->join('color', 'color.id_color', 'product_variant.id_color')
            ->join('storage', 'storage.id_storage', 'product_variant.id_storage')
            ->get();
        return view('admin.orders.index', compact('listOrders', 'listDetail', 'listVariant'));
    }
    public function create() {}
    public function edit($id)
    {

        $isOrder = Order::select(['`order`.*'])
            ->where('id_order', '=', $id)
            ->first();
        $listDetail = OrderDetail::select(['order_detail.*'])
            ->where('id_order', '=', $id)
            ->get();
        $listVariant = ProductVariant::select(['product_variant.*', 'products.name as product_name', 'color.name as color_name', 'storage.storage'])
            ->join('products', 'products.id_product', 'product_variant.id_product')
            ->join('color', 'color.id_color', 'product_variant.id_color')
            ->join('storage', 'storage.id_storage', 'product_variant.id_storage')
            ->get();

        // Lấy danh sách sản phẩm cho dropdown trong modal
        $products = Product::all();
        // dd($listVariant); 

        return view('admin.orders.editorder', compact('listDetail', 'isOrder',  'listVariant', 'products'));
    }
    public function addProduct($id)
    {
        try {
            $order = Order::find($id);
            if (!$order) {
                $_SESSION['error'] = 'Không tìm thấy đơn hàng';
                return redirect('admin/order/edit/' . $id);
            }

            $variantId = $_POST['id_variant'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if (!$variantId) {
                $_SESSION['error'] = 'Thiếu thông tin sản phẩm';
                return redirect('admin/order/edit/' . $id);
            }

            // Kiểm tra số lượng tồn kho
            $variant = ProductVariant::find($variantId);
            if (!$variant || $variant->quantity < $quantity) {
                $_SESSION['error'] = 'Số lượng sản phẩm không đủ';
                return redirect('admin/order/edit/' . $id);
            }

            // Kiểm tra sản phẩm đã tồn tại trong đơn hàng chưa
            $existingDetail = OrderDetail::select(['order_detail.*'])
                ->where('id_order', '=', $id)
                ->where('id_prodvar', '=', $variantId)
                ->get();
            $checkMatch = true;

            if ($existingDetail) {
                // Cập nhật số lượng nếu sản phẩm đã tồn tại và giá bằng giá cũ
                foreach ($existingDetail as $detail) {
                    if ($detail->price == $variant->price) {
                        $checkMatch = false;
                        $newQuantity = $detail->quantity + $quantity;
                        OrderDetail::update(['quantity' => $newQuantity], $detail->id_orderdetail);
                        break;
                    }
                }
            }
            if ($checkMatch) {
                // Thêm mới sản phẩm vào đơn hàng
                OrderDetail::create([
                    'id_order' => $id,
                    'id_prodvar' => $variantId,
                    'quantity' => $quantity,
                    'price' => $variant->price
                ]);
            }

            $_SESSION['message'] = 'Thêm sản phẩm thành công';
            return redirect('admin/order/edit/' . $id);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            return redirect('admin/order/edit/' . $id);
        }
    }
    /**
     * Cập nhật số lượng sản phẩm và trả về kết quả dạng JSON
     */
    public function updateQuantity($id)
    {
        try {
            // Lấy thông tin chi tiết đơn hàng
            $detail = OrderDetail::find($id);
            if (!$detail) {
                return $this->jsonResponse(['success' => false, 'message' => 'Không tìm thấy chi tiết đơn hàng'], 404);
            }

            // Lấy số lượng mới
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
            if ($quantity < 1) {
                return $this->jsonResponse(['success' => false, 'message' => 'Số lượng không hợp lệ'], 400);
            }

            // Lấy thông tin variant để kiểm tra số lượng tồn kho
            $variant = ProductVariant::find($detail->id_prodvar);
            if (!$variant || $variant->quantity < $quantity) {
                return $this->jsonResponse(['success' => false, 'message' => 'Số lượng sản phẩm không đủ'], 400);
            }

            // Cập nhật số lượng
            OrderDetail::update(['quantity' => $quantity], $id);

            // Tính tổng tiền mới của đơn hàng
            $orderDetails = OrderDetail::select(['order_detail.*'])
                ->where('id_order', '=', $detail->id_order)
                ->get();

            $totalAmount = 0;
            foreach ($orderDetails as $item) {
                $totalAmount += $item->price * $item->quantity;
            }

            // Cập nhật tổng tiền đơn hàng
            Order::update(['total_amount' => $totalAmount], $detail->id_order);

            return $this->jsonResponse([
                'success' => true,
                'quantity' => $quantity,
                'subtotal' => $detail->price * $quantity,
                'total' => $totalAmount
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function removeProduct($id)
    {
        try {
            $detail = OrderDetail::find($id);
            if (!$detail) {
                $_SESSION['error'] = 'Không tìm thấy chi tiết đơn hàng';
                return redirect('admin/order/edit/' . $detail->id_order);
            }

            $orderId = $detail->id_order;
            OrderDetail::delete($id);

            $_SESSION['message'] = 'Xóa sản phẩm thành công';
            return redirect('admin/order/edit/' . $orderId);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            return redirect('admin/order');
        }
    }

    public function update($id)
    {
        try {
            $order = Order::find($id);
            if (!$order) {
                $_SESSION['error'] = 'Không tìm thấy đơn hàng';
                return redirect('admin/order');
            }

            // Validate dữ liệu
            $address = trim($_POST['address'] ?? '');
            $status = $_POST['status'] ?? '';
            $pay_method = $_POST['pay_method'] ?? '';
            $phone = trim($_POST['phone'] ?? '');
            $notes = trim($_POST['notes'] ?? '');

            // Kiểm tra các trường bắt buộc
            if (empty($address)) {
                $_SESSION['error'] = 'Địa chỉ giao hàng không được để trống';
                return redirect('admin/order/edit/' . $id);
            }

            if ($status === '') {
                $_SESSION['error'] = 'Trạng thái đơn hàng không được để trống';
                return redirect('admin/order/edit/' . $id);
            }

            if ($pay_method === '') {
                $_SESSION['error'] = 'Phương thức thanh toán không được để trống';
                return redirect('admin/order/edit/' . $id);
            }

            // Kiểm tra định dạng số điện thoại
            if (!empty($phone) && !preg_match('/^(0|\+84)(\d{9,10})$/', $phone)) {
                $_SESSION['error'] = 'Số điện thoại không đúng định dạng';
                return redirect('admin/order/edit/' . $id);
            }

            // Cập nhật thông tin đơn hàng
            $updateData = [
                'buyer_name' => $_POST['buyer_name'],
                'phone' => $phone,
                'status' => $status,
                'pay_method' => $pay_method,
                'address' => $address,
                'notes' => $notes,
            ];
            Order::update($updateData, $id);

            $_SESSION['message'] = 'Cập nhật đơn hàng thành công';
            return redirect('admin/order');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            return redirect('admin/order');
        }
    }



    /**
     * Trả về response dạng JSON
     */
    private function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}
