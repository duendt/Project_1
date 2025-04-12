<?php 
namespace App\Models;

class Cart extends BaseModel{
    protected static $table = 'carts';
    protected static $primaryKey = 'id_cart';
    
    /**
     * Lấy tất cả sản phẩm trong giỏ hàng của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return array Danh sách sản phẩm trong giỏ hàng
     */
    public static function getUserCart($userId)
    {
        $result = self::where('id_user', '=', $userId)->get();
        return $result ?: [];
    }
    
    /**
     * Lấy số lượng sản phẩm trong giỏ hàng của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return int Số lượng sản phẩm trong giỏ hàng
     */
    public static function getCartCount($userId)
    {
        $result = self::where('id_user', '=', $userId)->get();
        
        if (!$result) {
            return 0;
        }
        
        return count($result);
    }
    
    /**
     * Xóa tất cả sản phẩm trong giỏ hàng của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return bool Kết quả thực hiện
     */
    public static function clearUserCart($userId)
    {
        global $conn;
        
        $sql = "DELETE FROM " . static::$table . " WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId]);
        
        return $stmt->rowCount() > 0;
    }
}