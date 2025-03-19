<?php
require_once '../config/database.php';

class Orders {
    public $id;
    public $user_id;
    public $order_date;
    public $status;
    public $total_amount;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function where($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($user_id, $car_id, $quantity, $total_price)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, status, total_amount) 
                                VALUES (:user_id, GETDATE(), :status, :total_amount)");
        $stmt->execute([
            'user_id' => $user_id,
            'status' => 'pending',
            'total_amount' => $total_price
        ]);

        $order_id = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO order_details (order_id, car_id, quantity, price) 
                                VALUES (:order_id, :car_id, :quantity, :price)");
        $stmt->execute([
            'order_id' => $order_id,
            'car_id' => $car_id,
            'quantity' => $quantity,
            'price' => $total_price
        ]);

        $stmt = $conn->prepare("UPDATE cars SET stock = stock - :quantity WHERE id = :car_id");
        $stmt->execute([
            'quantity' => $quantity,
            'car_id' => $car_id
        ]);

        return true;
    }


    public static function getUserOrders($user_id) {
        global $conn;
        
        $stmt = $conn->prepare("
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
        ");
        
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    
    public static function getOrderById($order_id) {

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
            (od.quantity * od.price) AS total_price
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_details od ON o.id = od.order_id
            JOIN cars c ON od.car_id = c.id
            WHERE o.id = :order_id
        ");
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($order_id, $status) {
        global $conn;
        $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        return $stmt->execute(['order_id' => $order_id, 'status' => $status]);
    }

    public static function delete($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>