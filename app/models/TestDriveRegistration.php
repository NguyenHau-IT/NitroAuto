<?php
require_once '../config/database.php';

class TestDriveRegistration
{
    public $id;
    public $user_id;
    public $car_id;
    public $preferred_date;
    public $preferred_time;
    public $location;
    public $status;
    public $created_at;

    public function __construct($db, $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function create($user_id, $car_id, $preferred_date, $preferred_time, $location)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO TestDriveRegistration
                        (user_id, car_id, preferred_date, preferred_time, location, status, created_at) 
                VALUES (:user_id, :car_id, :preferred_date, :preferred_time, :location, :status, GETDATE())");
        $stmt->execute([
            'user_id' => $user_id,
            'car_id' => $car_id,
            'preferred_date' => $preferred_date,
            'preferred_time' => $preferred_time,
            'location' => $location,
            'status' => 'Pending'
        ]);

        return true;
    }

    public static function all()
    {
        global $conn;
        $stmt = $conn->query("SELECT * FROM TestDriveRegistration");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT 
                                    td.id,
                                    td.user_id,
                                    td.car_id,
                                    td.preferred_date,
                                    td.preferred_time,
                                    td.location,
                                    td.status,
                                    td.created_at,
                                    u.full_name,
                                    u.email,
                                    u.phone,
                                    u.address,
                                    c.name AS car_name,
                                    c.price AS car_price
                                FROM TestDriveRegistration td
                                JOIN Users u ON td.user_id = u.id
                                JOIN Cars c ON td.car_id = c.id
                                WHERE td.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public static function findByUser($user_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM TestDriveRegistration WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByCar($car_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM TestDriveRegistration WHERE car_id = :car_id");
        $stmt->execute(['car_id' => $car_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE TestDriveRegistration SET user_id = :user_id, car_id = :car_id, preferred_date = :preferred_date, preferred_time = :preferred_time, location = :location, status = :status WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'user_id' => $data['user_id'],
            'car_id' => $data['car_id'],
            'preferred_date' => $data['preferred_date'],
            'preferred_time' => $data['preferred_time'],
            'location' => $data['location'],
            'status' => $data['status']
        ]);
        return $stmt->rowCount();
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM TestDriveRegistration WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }

    public static function updateStatus($id, $status)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE TestDriveRegistration SET status = :status WHERE id = :id");
        $stmt->execute(['id' => $id, 'status' => $status]);
        return $stmt->rowCount();
    }
}
