<?php
require_once '../config/database.php';

class Brands {
    public $id;
    public $name;
    public $country;
    public $logo;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM brands");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM brands WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $country, $logo) {
        global $conn;
    
        $stmt = $conn->prepare("INSERT INTO brands (name, country, logo) 
                                VALUES (:name, :country, :logo)");
        return true;
    }
}
?>