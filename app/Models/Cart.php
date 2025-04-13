<?php 
namespace App\Models;

class Cart extends BaseModel{
    protected $tableName = 'cart';
    protected $primaryKey = 'id_cart';
    
    public static function clearCartByUser($userId) {
        $model = new static;
        $sql = "DELETE FROM $model->tableName WHERE id_user = :user_id";
        $stmt = $model->conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
    }
   
}