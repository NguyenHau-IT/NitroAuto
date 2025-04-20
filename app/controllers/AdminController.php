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
        $cars = Cars::all();
        $users = Users::all();
        $favorites = Favorites::all();

        $raw_orders = Orders::all();

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

        $brands = Brands::all();
        $categories = Categories::all();
        $test_drives = TestDriveRegistration::all();
        $accessoires = Accessories::all();
        $banners = Banner::all();
        $usedCars = Used_cars::getall();
        $services = CarServices::all();
        $promotions = Promotions::all();
        $servicesOrders = ServiceOrder::all();
        $reviews = Reviews::manager();

        require_once '../app/views/admin/dashboard.php';
    }
}
