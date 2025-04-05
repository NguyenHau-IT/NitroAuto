<?php
require_once '../config/database.php';

class Orders
{
    public $id;
    public $user_id;
    public $order_date;
    public $status;
    public $total_amount;
    public $address;
    public $phone;

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
        $stmt = $conn->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function where($user_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($user_id, $car_id, $quantity, $accessory_id, $accessory_quantity, $total_price, $address, $phone)
    {
        global $conn;

        // Kiểm tra tồn kho xe
        if ($car_id && $quantity > 0) {
            $stmt = $conn->prepare("SELECT price, stock FROM cars WHERE id = :car_id");
            $stmt->execute(['car_id' => $car_id]);
            $car = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$car || $car['stock'] < $quantity) return false;

            $car_price = (float)$car['price'];
            $car_subtotal = $car_price * $quantity;
        }

        // Kiểm tra tồn kho phụ kiện nếu có
        $accessory_price = 0;
        $accessory_total = 0;
        if ($accessory_id && $accessory_quantity > 0) {
            $stmt = $conn->prepare("SELECT price, stock FROM accessories WHERE id = :id");
            $stmt->execute(['id' => $accessory_id]);
            $accessory = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$accessory || $accessory['stock'] < $accessory_quantity) return false;

            $accessory_price = (float)$accessory['price'];
            $accessory_total = $accessory_price * $accessory_quantity;
        }

        // Tính tổng tiền
        $total_price = $car_subtotal + $accessory_total;

        // Tạo đơn hàng mới (SQL Server syntax)
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, order_date, status, total_amount, address, phone)
            OUTPUT INSERTED.id
            VALUES (:user_id, GETDATE(), 'pending', :total_amount, :address, :phone)
        ");
        $stmt->execute([
            'user_id' => $user_id,
            'total_amount' => $total_price,
            'address' => $address,
            'phone' => $phone
        ]);

        // Lấy ID đơn hàng vừa tạo (SQL Server)
        $order_id = $stmt->fetchColumn();
        if (!$order_id) return false;

        // Lưu thông tin xe và phụ kiện vào order_details
        $stmt = $conn->prepare("
            INSERT INTO order_details 
            (order_id, car_id, quantity, price, accessory_id, accessory_quantity, accessory_price)
            VALUES 
            (:order_id, :car_id, :quantity, :price, :accessory_id, :accessory_quantity, :accessory_price)
        ");
        $stmt->execute([
            'order_id' => $order_id,
            'car_id' => $car_id ?: null,
            'quantity' => $quantity ?: null,
            'price' => $car_price ?: null,
            'accessory_id' => $accessory_id ?: null,
            'accessory_quantity' => $accessory_quantity ?: null,
            'accessory_price' => $accessory_price ?: null
        ]);

        $stmt = $conn->prepare("
            UPDATE cars SET stock = stock - :quantity
            WHERE id = :car_id
        ");
        $stmt->execute([
            'quantity' => $quantity,
            'car_id' => $car_id
        ]);

        if ($accessory_id && $accessory_quantity > 0) {
            $stmt = $conn->prepare("
            UPDATE accessories SET stock = stock - :accessory_quantity
            WHERE id = :accessory_id
        ");
            $stmt->execute([
                'accessory_quantity' => $accessory_quantity,
                'accessory_id' => $accessory_id
            ]);
        }

        return true;
    }

    public static function getOrderById($order_id)
    {

        global $conn;

        $stmt = $conn->prepare("
            SELECT 
            o.id AS order_id,
            o.order_date,
            o.status,
            o.total_amount,
            o.user_id,
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
            od.subtotal,
            od.price AS car_price,
            (od.subtotal + od.accessory_total) AS total_price
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_details od ON o.id = od.order_id
            JOIN cars c ON od.car_id = c.id
            LEFT JOIN accessories a ON od.accessory_id = a.id
            LEFT JOIN car_accessories ca ON od.car_id = ca.car_id AND od.accessory_id = ca.accessory_id
            WHERE o.id = :order_id
        ");
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($order_id, $status)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        return $stmt->execute(['order_id' => $order_id, 'status' => $status]);
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function createMainOrder($user_id, $address, $phone, $total_price)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO orders (user_id, address, phone, total_amount, order_date)
                          VALUES (?, ?, ?, ?, GETDATE())");
        $stmt->execute([$user_id, $address, $phone, $total_price]);

        return $conn->lastInsertId();
    }

    public static function addOrderItem(
        $order_id,
        $accessory_id,
        $quantity,
        $price
    ) {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO order_details 
            (order_id, accessory_id, accessory_quantity, accessory_price)
            VALUES (?, ?, ?, ?)");

        return $stmt->execute([
            $order_id,
            $accessory_id,
            $quantity,
            $price,
        ]);
    }
}
