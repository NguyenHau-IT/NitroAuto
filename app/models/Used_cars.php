<?php
require_once '../config/database.php';

class Used_cars {
    public $id;
    public $user_id;
    public $brand_id;
    public $category_id;
    public $name;
    public $price;
    public $year;
    public $mileage;
    public $fuel_type;
    public $transmission;
    public $color;
    public $description;
    public $status;
    public $created_at;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM used_cars");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM used_cars WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>