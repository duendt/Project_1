<?php 
namespace App\Models;

class Order extends BaseModel{
    protected static $table = 'orders';
    protected static $primaryKey = 'id_order';
    
    /**
     * Lấy đơn hàng của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return array Danh sách đơn hàng
     */
    public static function getUserOrders($userId)
    {
        return self::where('id_user', '=', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
    
    /**
     * Lấy chi tiết đơn hàng
     * 
     * @param int $orderId ID của đơn hàng
     * @return object|null Thông tin đơn hàng
     */
    public static function getOrderDetails($orderId)
    {
        $order = self::find($orderId);
        
        if (!$order) {
            return null;
        }
        
        // Lấy thông tin người dùng
        $user = User::find($order->id_user);
        $order->user = $user;
        
        // Lấy thông tin các sản phẩm trong đơn hàng
        $orderItems = OrderItem::where('id_order', '=', $orderId)->get();
        
        foreach ($orderItems as $item) {
            $variant = ProductVariant::find($item->id_prodvar);
            $product = Product::find($variant->id_product);
            
            $item->product_name = $product->name;
            $item->variant_name = $variant->color_name . ' - ' . $variant->storage;
            $item->image = $variant->image;
        }
        
        $order->items = $orderItems;
        
        return $order;
    }
    
    /**
     * Cập nhật trạng thái đơn hàng
     * 
     * @param int $orderId ID của đơn hàng
     * @param string $status Trạng thái mới
     * @return bool Kết quả thực hiện
     */
    public static function updateStatus($orderId, $status)
    {
        return self::update($orderId, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}