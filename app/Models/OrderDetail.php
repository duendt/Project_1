<?php 
namespace App\Models;

class OrderDetail extends BaseModel{
    protected $tableName = 'order_detail';
    protected $primaryKey = 'id_orderdetail';
    public static function getByOrder($idOrder)
    {
        $model = new static;
        $sql = "SELECT * FROM $model->tableName WHERE id_order = :id_order";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_order', $idOrder, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}