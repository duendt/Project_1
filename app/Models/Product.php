<?php 
namespace App\Models;

class Product extends BaseModel{
    protected $tableName = 'products';
    protected $primaryKey = 'id_product';
    public static function deleteByBrandId($brandId)
    {
        $model = new static;
        $sql = "DELETE FROM $model->tableName WHERE id_brand = :id_brand";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_brand', $brandId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function deleteByTypeId($typeId)
    {
        $model = new static;
        $sql = "DELETE FROM $model->tableName WHERE id_type = :id_type";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_type', $typeId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}