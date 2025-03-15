<?php
require_once '../config/database.php';
require_once '../app/models/Orders.php';
require_once '../app/models/Cars.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        global $conn;
        $this->orderModel = new Orders($conn);
    }

    public function showOrderForm() {
        $user = $_SESSION["user"] ?? null;
        if (!$user) {
            die("Bạn chưa đăng nhập.");
        }

        $cars = Cars::all();
        require_once '../app/views/orders/order.php';
    }

    public function placeOrder() {
        $user_id = $_SESSION["user"]["id"] ?? null;
        if (!$user_id) {
            die("Bạn chưa đăng nhập.");
        }
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $car_id = $_POST['car_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            $total_price = $_POST['total_price'] ?? 0;

            $total_price = floatval(str_replace(',', '', $total_price));
    
            if ($car_id <= 0 || $quantity <= 0 || $total_price <= 0) {
                die("Thông tin không hợp lệ!");
            }
    
            $result = $this->orderModel->create($user_id, $car_id, $quantity, $total_price);
            if ($result) {
                require_once '../app/views/orders/order_success.php';
                exit();
            } else {
                die("Lỗi khi đặt hàng.");
            }
        }
    }
      
    public function getUserOrders() {
        global $conn;
    
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login.php");
            exit;
        }
    
        $user_id = $_SESSION["user"]["id"];
        $orders = Orders::getUserOrders($user_id);
    
        if (empty($orders)) {
            $message = "Không có đơn hàng nào.";
        }
    
        require_once '../app/views/orders/order_list.php';
    }
    
}
?>
