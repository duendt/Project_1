<?php 
namespace App\Models;

class News extends BaseModel {
    protected $tableName = 'news';
    protected $primaryKey = 'id';
    
    /**
     * Get all news records
     *
     * @return array
     */
    public static function all()
    {
        $model = new static;
        $sql = "SELECT id, title, content, image, created_at FROM $model->tableName ORDER BY created_at DESC";
        $stmt = $model->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Get a news article by ID
     *
     * @param int $id
     * @return object|null
     */
    public static function find($id) 
    {
        $model = new static;
        $sql = "SELECT id, title, content, image, created_at FROM $model->tableName WHERE id = :id";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
} 