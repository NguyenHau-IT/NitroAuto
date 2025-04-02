<?php
require_once '../config/database.php';


class AdminController
{
    public function index()
    {
        global $conn;
        
        $stmt = $conn->query("
        SELECT cars.*, 
               brands.name AS brand_name, 
               categories.name AS category_name,
               (SELECT image_url FROM car_images WHERE car_images.car_id = cars.id AND image_type = 'normal') AS image_url,
               (SELECT image_url FROM car_images WHERE car_images.car_id = cars.id AND image_type = '3d') AS image_3d_url
        FROM cars
        LEFT JOIN brands ON cars.brand_id = brands.id
        LEFT JOIN categories ON cars.category_id = categories.id
    ");
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt_users = $conn->query("SELECT * FROM users");
        $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

        $stmt_favorites = $conn->query("
        SELECT favorites.id, users.full_name AS user_name, cars.name AS car_name, favorites.created_at
        FROM favorites
        JOIN users ON favorites.user_id = users.id
        JOIN cars ON favorites.car_id = cars.id
    ");
        $favorites = $stmt_favorites->fetchAll(PDO::FETCH_ASSOC);

        $stmt_orders = $conn->query("
        SELECT orders.*, users.full_name AS user_name, cars.name AS car_name, order_details.quantity, order_details.price
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN order_details ON orders.id = order_details.order_id
        JOIN cars ON order_details.car_id = cars.id
    ");
        $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

        $stmt_brands = $conn->query("SELECT * FROM brands");
        $brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);

        $stmt_categories = $conn->query("SELECT * FROM categories");
        $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

        $stmt_test_drives = $conn->query("
        SELECT TestDriveRegistration.*, users.full_name AS user_name, cars.name AS car_name
        FROM TestDriveRegistration
        JOIN users ON TestDriveRegistration.user_id = users.id
        JOIN cars ON TestDriveRegistration.car_id = cars.id
    ");
        $test_drives = $stmt_test_drives->fetchAll(PDO::FETCH_ASSOC);
        require_once '../app/views/admin/dashboard.php';
    }
}
