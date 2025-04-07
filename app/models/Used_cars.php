<?php
require_once '../config/database.php';

class Used_cars
{
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
    $stmt = $conn->query("
        SELECT 
            used_cars.id,
            used_cars.name,
            used_cars.brand_id,
            used_cars.year,
            used_cars.price,
            used_cars.fuel_type,
            used_cars.description,
            used_cars.created_at,
            categories.name AS category_name,
            brands.name AS brand,
            used_cars.created_at,
            (
                SELECT TOP 1 image_url 
                FROM used_car_images 
                WHERE used_car_images.used_car_id = used_cars.id 
                  AND image_type = 'normal'
            ) AS image_url
        FROM used_cars
        JOIN brands ON used_cars.brand_id = brands.id
        JOIN categories ON used_cars.category_id = categories.id
        JOIN users ON used_cars.user_id = users.id
        ORDER BY used_cars.created_at DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM used_cars WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
