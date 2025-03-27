<?php
require_once '../config/database.php';
require_once '../app/models/Orders.php';
require_once '../app/models/Cars.php';
require_once '../app/models/Order_details.php';

class OrderController
{

    public function showOrderForm()
    {
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /error?status=error&message=" . urlencode("Vui lòng đăng nhập trước khi mua xe!") . "&href=/home");
        }

        $cars = Cars::all();
        require_once '../app/views/orders/order.php';
    }

    public function placeOrder()
    {
        $user_id = $_SESSION["user"]["id"] ?? null;
        if (!$user_id) {
            header("Location: /error?status=error&message=" . urlencode("Vui lòng đăng nhập trước khi mua xe!"));
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $car_id = $_POST['car_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            $total_price = $_POST['total_price'] ?? 0;

            $total_price = floatval(str_replace(',', '', $total_price));

            if ($car_id <= 0 || $quantity <= 0 || $total_price <= 0) {
                header("Location: /error?status=error&message=" . urlencode("Thông tin mua xe không hợp lệ!"));
                exit();
            }

            $result = Orders::create($user_id, $car_id, $quantity, $total_price);
            if ($result) {
                header("Location: /success?status=success&message=" . urlencode("Bạn đã đặt mua xe thành công!"));
                exit();
            } else {
                header("Location: /error?status=error&message=" . urlencode("Lỗi khi đặt mua xe!"));
                exit();
            }
        }
    }

    public function getUserOrders()
    {
        global $conn;

        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }

        $user_id = $_SESSION["user"]["id"];
        $orders = Orders::getUserOrders($user_id);

        if (empty($orders)) {
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy đơn hàng!"));
            exit();
        }

        require_once '../app/views/orders/order_list.php';
    }

    public function orderDetail($orderId)
    {
        global $conn;
        $order = Order_details::find($orderId);
        if (!$order) {
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy đơn hàng!"));
            exit();
        }
        require_once '../app/views/orders/order_detail.php';
    }

    public function order_edit($id) {
        $order = Orders::getOrderById($id);
        if (!$order) {
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy đơn hàng!"));
            exit();
        }
        require_once __DIR__ . "/../views/orders/order_edit.php";
    }

    public function updateOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['order_status'];
            $result = Orders::updateStatus($id, $status);
            if ($result) {
                header("Location: /success?status=success&message=" . urlencode("Cập nhật đơn hàng thành công!") . "&href=/admin");
                exit;
            } else {
                header("Location: /error?status=error&message=" . urlencode("Cập nhật đơn hàng thất bại!" . "&href=/admin"));
                exit();
            }
        }
    }

    public function deleteOrder($id) {
        if (Orders::delete($id)) {
            header("Location: /success?status=success&message=" . urlencode("Xoá đơn hàng thành công!") . "&href=/admin");
            exit;
        } else {
            header("Location: /error?status=error&message=" . urlencode("Xoá đơn hàng thất bại!") . "&href=/admin");
            exit();
        }
    }
}
