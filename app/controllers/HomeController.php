<?php
require_once '../config/database.php';
require_once '../app/models/Brands.php';

class HomeController 
{
    public function index() {
        global $conn;
        $stmt = $conn->prepare("
        SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description,
               (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id and image_type = 'normal') AS image,
                (SELECT name FROM Brands WHERE brands.id = Cars.brand_id) AS brand
        FROM cars
        ORDER BY cars.id ASC
    ");
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $brands = Brands::all();
        require_once '../app/views/index.php';
    }
}
?>
