<?php
require_once '../config/database.php';

class Categories {
    public $id;
    public $name;
    public $description;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByCar() {
        global $conn;
        $stmt = $conn->query("SELECT categories.id, categories.name, categories.description
                            FROM categories
                            JOIN cars ON cars.category_id = categories.id
                            WHERE cars.stock > 0
                            GROUP BY categories.id, categories.name, categories.description
                            ORDER BY categories.name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   
}
?>