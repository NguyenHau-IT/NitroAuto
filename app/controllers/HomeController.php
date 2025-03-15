<?php
require_once '../config/database.php'; // Kết nối database
require_once '../app/models/Brands.php'; // Sử dụng model Brands

class HomeController {
    public function index() {
        global $conn;
        $stmt = $conn->prepare("
        SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description,
               (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id and image_type = 'normal') AS image,
                (SELECT name FROM Brands WHERE brands.id = Cars.brand_id) AS brand
        FROM cars
        WHERE stock > 0
        ORDER BY cars.id ASC
    ");
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../app/views/index.php';
    }

    public function showCarDetail($id) {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
        $stmt->execute([$id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt2 = $conn->prepare("SELECT image_url, image_type FROM car_images WHERE car_id = ? AND image_type = '3D'");
        $stmt2->execute([$id]);
        $images = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/cars/car_detail.php';
    }
}
?>
