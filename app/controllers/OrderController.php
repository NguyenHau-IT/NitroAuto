<?php
require_once '../config/database.php';
require_once '../app/models/Orders.php';
require_once '../app/models/Cars.php';
require_once '../app/models/Order_details.php';

class OrderController
{
    public function OrderForm()
    {
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập trước khi mua xe!") );
            exit();
        }

        $cars = Cars::all();
        $accessories = Accessories::all();
        require_once '../app/views/orders/order.php';
    }

    public function Order()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user_id = $_SESSION["user"]["id"] ?? null;
    
            $car_id = isset($_POST['car_id']) && $_POST['car_id'] !== '' ? (int)$_POST['car_id'] : null;
            $quantity = isset($_POST['quantity']) && $_POST['quantity'] !== '' ? (int)$_POST['quantity'] : null;
    
            $accessory_id = isset($_POST['accessory_id']) && $_POST['accessory_id'] !== '' ? (int)$_POST['accessory_id'] : null;
            $accessory_quantity = isset($_POST['accessory_quantity']) && $_POST['accessory_quantity'] !== '' ? (int)$_POST['accessory_quantity'] : null;
    
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
    
            $hasCar = $car_id !== null && $quantity > 0;
            $hasAccessory = $accessory_id !== null && $accessory_quantity > 0;
    
            if (!$hasCar && !$hasAccessory) {
                header("Location: /OrderForm?status=error&message=" . urlencode("Vui lòng chọn xe hoặc phụ kiện!"));
                exit();
            }
    
            if (empty($address) || empty($phone)) {
                $user = Users::find($user_id);
                if ($user) {
                    $address = $user['address'];
                    $phone = $user['phone'];
                } else {
                    header("Location: /error?status=error&message=" . urlencode("Vui lòng đăng nhập để mua hàng!"));
                    exit();
                }
            }
    
            $result = Orders::create($user_id, $car_id, $quantity, $accessory_id, $accessory_quantity, $address, $phone);
    
            if ($result) {
                header("Location: /home?status=success&message=" . urlencode("Bạn đã đặt mua thành công!"));
            } else {
                header("Location: /OrderForm?status=error&message=" . urlencode("Lỗi khi đặt mua!"));
            }
            exit();
        }
    }    
    
    public function getUserOrders()
    {
        global $conn;
    
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập để xem lịch sử!") );
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
                o.total_amount AS total_price,
                u.full_name AS user_name,
                od.car_id,
                c.name AS car_name,
                od.quantity,
                od.price,
                od.accessory_id,
                a.name AS accessory_name,
                od.accessory_quantity,
                a.price AS accessory_price,
                od.accessory_total,
                od.subtotal
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_details od ON o.id = od.order_id
            LEFT JOIN cars c ON od.car_id = c.id
            LEFT JOIN accessories a ON od.accessory_id = a.id
            WHERE o.user_id = :user_id
        ";
    
        if ($startDate) {
            $query .= " AND o.order_date >= :startDate";
        }
    
        if ($endDate) {
            $query .= " AND o.order_date <= :endDate";
        }
    
        $query .= " ORDER BY o.order_date DESC";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
    
        if ($startDate) {
            $stmt->bindParam(':startDate', $startDate);
        }
    
        if ($endDate) {
            $stmt->bindParam(':endDate', $endDate);
        }
    
        $stmt->execute();
        $orders = $stmt->fetchAll();
    
        $groupedOrders = [];
        foreach ($orders as $order) {
            $orderId = $order['order_id'];
            if (!isset($groupedOrders[$orderId])) {
                $groupedOrders[$orderId] = [
                    'order_id' => $order['order_id'],
                    'order_date' => $order['order_date'],
                    'status' => $order['status'],
                    'total_price' => $order['total_price'],
                    'items' => [],
                ];
            }
    
            $groupedOrders[$orderId]['items'][] = [
                'car_name' => $order['car_name'],
                'quantity' => $order['quantity'],
                'accessory_name' => $order['accessory_name'],
                'accessory_quantity' => $order['accessory_quantity'],
            ];
        }
    
        require_once '../app/views/orders/order_list.php';
    }   

    public function orderDetail($Id)
    {
        $order = Orders::getOrderById($Id);
        if (!$order) {
            header("Location: /user_orders?status=error&message=" . urlencode("Không tìm thấy đơn hàng!"));
            exit();
        }
        require_once '../app/views/orders/order_detail.php';
    }

    public function order_edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['order_status'];
            $result = Orders::updateStatus($id, $status);
            if ($result) {
                header("Location: /admin");
                exit;
            } else {
                header("Location: /amdin?status=error&message=" . urlencode("Cập nhật đơn hàng thất bại!"));
                exit();
            }
        }
        $order = Orders::getOrderById($id);
        if (!$order) {
            header("Location: /admin?status=error&message=" . urlencode("Không tìm thấy đơn hàng!"));
            exit();
        }
        require_once __DIR__ . "/../views/orders/order_edit.php";
    }

    public function deleteOrder($id)
    {
        if (Orders::delete($id)) {
            header("Location: /admin");
            exit;
        } else {
            header("Location: /admin?status=error&message=" . urlencode("Xoá đơn hàng thất bại!"));
            exit();
        }
    }
}
