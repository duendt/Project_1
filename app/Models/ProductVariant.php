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
    
    public static function getColorImagesByProductId($productId)
    {
        $model = new static;
        $sql = "SELECT DISTINCT pv.image, pv.id_color, c.name as color_name 
                FROM product_variant pv 
                JOIN color c ON c.id_color = pv.id_color 
                WHERE pv.id_product = :id_product";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_product', $productId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public static function getProductVariants($productId)
    {
        $model = new static;
        $sql = "SELECT pv.*, p.name as product_name, c.name as color_name, s.storage,
                cf.cpu, cf.ram, cf.gpu, cf.screen, cf.operating_system, cf.camera, cf.battery, cf.id_config
                FROM product_variant pv 
                JOIN products p ON p.id_product = pv.id_product 
                JOIN color c ON c.id_color = pv.id_color 
                JOIN storage s ON s.id_storage = pv.id_storage 
                JOIN config_product cf ON cf.id_config = pv.id_config
                WHERE pv.id_product = :id_product";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_product', $productId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public static function getProductVariantById($variantId)
    {
        $model = new static;
        $sql = "SELECT pv.*, p.name as product_name, c.name as color_name, s.storage,
                cf.cpu, cf.ram, cf.gpu, cf.screen, cf.operating_system, cf.camera, cf.battery, cf.id_config
                FROM product_variant pv 
                JOIN products p ON p.id_product = pv.id_product 
                JOIN color c ON c.id_color = pv.id_color 
                JOIN storage s ON s.id_storage = pv.id_storage 
                JOIN config_product cf ON cf.id_config = pv.id_config
                WHERE pv.id_prodvar = :id_prodvar";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id_prodvar', $variantId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ)[0] ?? null;
    }
}