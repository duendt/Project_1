<?php 
namespace App\Models;

class Order extends BaseModel {
    protected $tableName = '`order`'; // Đảm bảo tên bảng đúng, sử dụng dấu backtick nếu cần
    protected $primaryKey = 'id_order';
    
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