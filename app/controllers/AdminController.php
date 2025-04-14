<?php
require_once '../config/database.php';
require_once '../app/models/Brands.php';
require_once '../app/models/Categories.php';
require_once '../app/models/Banner.php';
require_once '../app/models/Cars.php';
require_once '../app/models/HistoryViewCar.php';
require_once '../app/models/Users.php';
require_once '../app/models/Favorites.php';
require_once '../app/models/Orders.php';
require_once '../app/models/Order_details.php';
require_once '../app/models/Car_images.php';
require_once '../app/models/Accessories.php';
require_once '../app/models/TestDriveRegistration.php';
require_once '../app/models/Promotions.php';
require_once '../app/models/Used_cars.php';
require_once '../app/models/CarServices.php';
require_once '../app/models/ServiceOrder.php';


class AdminController
{
    public function index()
    {
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
            header("Location: /home?status=error&message=" . urlencode("Bạn không có quyền truy cập vào trang này!"));
            exit();
        }

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
        SELECT 
            orders.id, orders.order_date,
            orders.status, orders.address,
            orders.total_amount AS total_price, users.full_name AS user_name, 
            cars.name AS car_name, order_details.quantity, 
            order_details.price, order_details.subtotal,
            accessories.name AS accessory_name, order_details.accessory_quantity, 
            accessories.price AS accessory_price, order_details.accessory_total
        FROM orders
        JOIN users ON orders.user_id = users.id
        LEFT JOIN order_details ON orders.id = order_details.order_id
        LEFT JOIN cars ON order_details.car_id = cars.id
        LEFT JOIN accessories ON order_details.accessory_id = accessories.id
        ORDER BY orders.order_date DESC
    ");

        $raw_orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

        // Gộp theo order_id
        $orders = [];

        foreach ($raw_orders as $row) {
            $id = $row['id'];

            if (!isset($orders[$id])) {
                $orders[$id] = [
                    'id' => $id,
                    'user_name' => $row['user_name'],
                    'order_date' => $row['order_date'],
                    'status' => $row['status'],
                    'address' => $row['address'],
                    'total_price' => $row['total_price'],
                    'cars' => [],
                    'accessories' => [],
                ];
            }

            if (!empty($row['car_name'])) {
                $orders[$id]['cars'][] = [
                    'name' => $row['car_name'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                ];
            }

            if (!empty($row['accessory_name'])) {
                $orders[$id]['accessories'][] = [
                    'name' => $row['accessory_name'],
                    'quantity' => $row['accessory_quantity'],
                    'price' => $row['accessory_price'],
                ];
            }
        }



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

        $accessoires = Accessories::all();
        $banners = Banner::all();
        $usedCars = Used_cars::getall();
        $services = CarServices::all();
        $promotions = Promotions::all();
        $servicesOrders = ServiceOrder::all();

        require_once '../app/views/admin/dashboard.php';
    }
}
