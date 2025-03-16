<?php
require_once '../config/database.php';

class Payments {
    public $id;
    public $order_id;
    public $payment_date;
    public $amount;
    public $method;
    public $status;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM payments");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM payments WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function whereUserId($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM payments WHERE order_id IN (SELECT id FROM orders WHERE user_id = :user_id)");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($order_id, $payment_date, $amount, $method, $status) {
        global $conn;
    
        $stmt = $conn->prepare("INSERT INTO payments (order_id, payment_date, amount, method, status) 
                                VALUES (:order_id, :payment_date, :amount, :method, :status)");
        return $stmt->execute([
            'order_id' => $order_id,
            'payment_date' => $payment_date,
            'amount' => $amount,
            'method' => $method,
            'status' => $status
        ]);
    }

    public static function update($id, $order_id, $payment_date, $amount, $method, $status) {
        global $conn;
    
        $stmt = $conn->prepare("UPDATE payments SET order_id = :order_id, payment_date = :payment_date, amount = :amount, method = :method, status = :status WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'order_id' => $order_id,
            'payment_date' => $payment_date,
            'amount' => $amount,
            'method' => $method,
            'status' => $status
        ]);
    }
}
?>