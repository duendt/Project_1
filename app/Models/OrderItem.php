<?php 

namespace App\Models;

class OrderItem extends BaseModel
{
    protected static $table = 'order_items';
    protected static $primaryKey = 'id_order_item';
    
    /**
     * Lấy tất cả sản phẩm trong đơn hàng
     * 
     * @param int $orderId ID của đơn hàng
     * @return array Danh sách sản phẩm trong đơn hàng
     */
    public static function getOrderItems($orderId)
    {
        $items = self::where('id_order', '=', $orderId)->get();
        
        // Lấy thông tin chi tiết sản phẩm
        foreach ($items as $item) {
            $variant = ProductVariant::find($item->id_prodvar);
            $product = Product::find($variant->id_product);
            
            $item->product_name = $product->name;
            $item->variant_name = $variant->color_name . ' - ' . $variant->storage;
            $item->image = $variant->image;
        }
        
        return $items;
    }
} 