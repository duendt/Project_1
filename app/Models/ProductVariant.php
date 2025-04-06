<?php 
namespace App\Models;

class ProductVariant extends BaseModel{
    protected $tableName = 'product_variant';
    protected $primaryKey = 'id_prodvar';

    public static function deleteByProductId($productId)
    {
        $model = new static;
        $sql = "DELETE FROM $model->tableName WHERE id_product = :id_product";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_product', $productId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function deleteByColorId($colorId)
    {
        $model = new static;
        $sql = "DELETE FROM $model->tableName WHERE id_color = :id_color";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_color', $colorId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function deleteByStorageId($storageId)
    {
        $model = new static;
        $sql = "DELETE FROM $model->tableName WHERE id_storage = :id_storage";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_storage', $storageId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function deleteByConfigId($configId)
    {
        $model = new static;
        $sql = "DELETE FROM $model->tableName WHERE id_config = :id_config";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_config', $configId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}