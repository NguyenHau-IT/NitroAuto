<?php
require_once '../config/database.php';

class Orders
{
    public $id, $user_id, $order_date, $status, $total_amount, $address, $phone;

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
        $stmt = $conn->query("
            SELECT 
                orders.id, orders.order_date,
                orders.status, orders.address,
                orders.total_amount, users.full_name AS user_name, 
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        try {
            $conn->beginTransaction();

            $car_price = 0;
            $car_subtotal = 0;
            if ($car_id && $quantity > 0) {
                $stmt = $conn->prepare("SELECT price, stock FROM cars WHERE id = :car_id");
                $stmt->execute(['car_id' => $car_id]);
                $car = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$car || $car['stock'] < $quantity) throw new Exception('Car stock insufficient');

                $car_price = (float)$car['price'];
                $car_subtotal = $car_price * $quantity;
            }

            $accessory_price = 0;
            $accessory_total = 0;
            if ($accessory_id && $accessory_quantity > 0) {
                $stmt = $conn->prepare("SELECT price, stock FROM accessories WHERE id = :id");
                $stmt->execute(['id' => $accessory_id]);
                $accessory = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$accessory || $accessory['stock'] < $accessory_quantity) throw new Exception('Accessory stock insufficient');

                $accessory_price = (float)$accessory['price'];
                $accessory_total = $accessory_price * $accessory_quantity;
            }

            $total_price = $car_subtotal + $accessory_total;

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
            $order_id = $stmt->fetchColumn();
            if (!$order_id) throw new Exception('Insert order failed');

            $stmt = $conn->prepare("
                INSERT INTO order_details 
                (order_id, car_id, quantity, price, accessory_id, accessory_quantity, accessory_price, subtotal, accessory_total)
                VALUES 
                (:order_id, :car_id, :quantity, :price, :accessory_id, :accessory_quantity, :accessory_price, :subtotal, :accessory_total)
            ");
            $stmt->execute([
                'order_id' => $order_id,
                'car_id' => $car_id ?: null,
                'quantity' => $quantity ?: null,
                'price' => $car_price ?: null,
                'accessory_id' => $accessory_id ?: null,
                'accessory_quantity' => $accessory_quantity ?: null,
                'accessory_price' => $accessory_price ?: null,
                'subtotal' => $car_subtotal,
                'accessory_total' => $accessory_total
            ]);

            if ($car_id) {
                $stmt = $conn->prepare("UPDATE cars SET stock = stock - :quantity WHERE id = :car_id");
                $stmt->execute(['quantity' => $quantity, 'car_id' => $car_id]);
            }

            if ($accessory_id) {
                $stmt = $conn->prepare("UPDATE accessories SET stock = stock - :accessory_quantity WHERE id = :accessory_id");
                $stmt->execute(['accessory_quantity' => $accessory_quantity, 'accessory_id' => $accessory_id]);
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
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
                u.email,
                u.phone,
                u.address,
                od.car_id,
                c.name AS car_name,
                od.quantity,
                od.price AS car_price,
                od.subtotal,
                od.accessory_id,
                a.name AS accessory_name,
                od.accessory_quantity,
                od.accessory_price,
                od.accessory_total,
                (od.subtotal + od.accessory_total) AS total_price
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_details od ON o.id = od.order_id
            LEFT JOIN cars c ON od.car_id = c.id
            LEFT JOIN accessories a ON od.accessory_id = a.id
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
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, address, phone, total_amount, order_date)
            VALUES (?, ?, ?, ?, GETDATE())
        ");
        $stmt->execute([$user_id, $address, $phone, $total_price]);
        return $conn->lastInsertId();
    }

    public static function addOrderItem($order_id, $accessory_id, $quantity, $price)
    {
        global $conn;
        $stmt = $conn->prepare("
            INSERT INTO order_details 
            (order_id, accessory_id, accessory_quantity, accessory_price)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$order_id, $accessory_id, $quantity, $price]);
    }

    public static function count()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM orders");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] ?? 0;
    }

    public static function totalRevenue()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT SUM(total_amount) as revenue FROM orders WHERE status = :status");
        $stmt->execute(['status' => 'Confirmed']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['revenue'] ?? 0;
    }

    public static function cancelRate()
    {
        global $conn;
        $total = self::count();
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM orders WHERE status = :status");
        $stmt->execute(['status' => 'Cancelled']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $cancelled = $row['count'] ?? 0;
        return $total > 0 ? round(($cancelled / $total) * 100, 2) : 0;
    }

    public static function revenueByMonth()
    {
        global $conn;
        $stmt = $conn->prepare("
            SELECT MONTH(order_date) as month, SUM(total_amount) as revenue
            FROM orders
            WHERE YEAR(order_date) = YEAR(GETDATE()) AND status = 'Confirmed'
            GROUP BY MONTH(order_date)
            ORDER BY month ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countByStatus($status)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM orders WHERE status = :status");
        $stmt->execute(['status' => $status]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }
}
