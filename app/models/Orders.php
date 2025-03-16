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

    public static function create($user_id, $car_id, $quantity, $total_price) {
        global $conn;
    
        // Thêm đơn hàng vào bảng orders
        $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, status, total_amount) 
                                VALUES (:user_id, GETDATE(), :status, :total_amount)");
        $stmt->execute([
            'user_id' => $user_id,
            'status' => 'pending', // Trạng thái mặc định
            'total_amount' => $total_price
        ]);
        
        // Lấy ID của đơn hàng vừa tạo
        $order_id = $conn->lastInsertId();
    
        // Thêm sản phẩm vào bảng order_details
        $stmt = $conn->prepare("INSERT INTO order_details (order_id, car_id, quantity, price) 
                                VALUES (:order_id, :car_id, :quantity, :price)");
        $stmt->execute([
            'order_id' => $order_id,
            'car_id' => $car_id,
            'quantity' => $quantity,
            'price' => $total_price // Hoặc giá 1 xe nếu `total_price` là tổng giá
        ]);

        // Thêm thông tin thanh toán vào bảng payments
        $stmt = $conn->prepare("INSERT INTO payments (order_id, amount,method, payment_date, status) 
                    VALUES (:order_id, :amount,:method, GETDATE(), :status)");
                    
        $stmt->execute([
            'order_id' => $order_id,
            'amount' => $total_price,
            'method' => 'Orther',
            'status' => 'Pending' // Trạng thái mặc định
        ]);
    
        return $order_id;
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
}
?>