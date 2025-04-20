<?php
require_once '../config/database.php';

class Accessories
{
    public $id;
    public $name;
    public $price;
    public $stock;
    public $description;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all()
    {
        global $conn;
        $stmt = $conn->query("SELECT accessories.id, accessories.name, accessories.description, accessories.price 
                        FROM accessories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM accessories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM accessories WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function topSelling()
{
    global $conn;
    $stmt = $conn->query("
        SELECT a.name, SUM(od.accessory_quantity) AS sold
        FROM order_details od
        JOIN accessories a ON a.id = od.accessory_id
        WHERE od.accessory_id IS NOT NULL
        GROUP BY a.name
        ORDER BY sold DESC
        OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
