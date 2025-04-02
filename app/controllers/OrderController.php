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
            header("Location: /error?status=error&message=" . urlencode("Vui lòng đăng nhập trước khi mua xe!") . "&href=/home");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $car_id = $_POST['car_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            $total_price = $_POST['total_price'] ?? 0;
            $address = $_POST['address'] ?? null;
            $phone = $_POST['phone'] ?? null;

            $total_price = floatval(str_replace(',', '', $total_price));

            if ($car_id <= 0 || $quantity <= 0 || $total_price <= 0) {
                header("Location: /error?status=error&message=" . urlencode("Thông tin mua xe không hợp lệ!") . "&href=/home");
                exit();
            }

            if (empty($address) || empty($phone)) {
                $user = Users::find($user_id);
                if ($user) {
                    $address = $user['address'];
                    $phone = $user['phone'];
                } else {
                    header("Location: /error?status=error&message=" . urlencode("Không tìm thấy thông tin người dùng!") . "&href=/home");
                    exit();
                }
            }

            $result = Orders::create($user_id, $car_id, $quantity, $total_price, $address, $phone);
            if ($result) {
                header("Location: /success?status=success&message=" . urlencode("Bạn đã đặt mua xe thành công!") . "&href=/home");
                exit();
            } else {
                header("Location: /error?status=error&message=" . urlencode("Lỗi khi đặt mua xe!") . "&href=/home");
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
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

        $query = "
            SELECT 
                o.id AS order_id,
                o.order_date,
                o.status,
                o.total_amount,
                od.car_id,
                c.name AS car_name,
                od.quantity,
                od.price,
                (od.quantity * od.price) AS total_price
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            JOIN cars c ON od.car_id = c.id
            WHERE o.user_id = :user_id
            ORDER BY o.id DESC
        ";

        if ($startDate) {
            $query .= " AND order_date >= :startDate";
        }

        if ($endDate) {
            $query .= " AND order_date <= :endDate";
        }

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':user_id', $user_id); // Bind the user_id to the query

        if ($startDate) {
            $stmt->bindParam(':startDate', $startDate);
        }

        if ($endDate) {
            $stmt->bindParam(':endDate', $endDate);
        }

        $stmt->execute();

        $orders = $stmt->fetchAll(); // Fetch all results from the query

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

    public function order_edit($id)
    {
        $order = Orders::getOrderById($id);
        if (!$order) {
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy đơn hàng!"));
            exit();
        }
        require_once __DIR__ . "/../views/orders/order_edit.php";
    }

    public function updateOrder()
    {
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

    public function deleteOrder($id)
    {
        if (Orders::delete($id)) {
            header("Location: /success?status=success&message=" . urlencode("Xoá đơn hàng thành công!") . "&href=/admin");
            exit;
        } else {
            header("Location: /error?status=error&message=" . urlencode("Xoá đơn hàng thất bại!") . "&href=/admin");
            exit();
        }
    }
}
