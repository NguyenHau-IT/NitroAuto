<?php
require_once '../config/database.php';

class Users
{
    public $id;
    public $full_name;
    public $email;
    public $phone;
    public $password;
    public $address;
    public $role;
    public $created_at;

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
        $stmt = $conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT id, full_name, email, phone, password, address, created_at, role FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function where($role)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE role = :role");
        $stmt->execute(['role' => $role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $full_name, $email, $phone, $address)
    {
        global $conn;

        // Kiểm tra dữ liệu đầu vào
        if (!$id || !$full_name || !$email || !$phone || !$address) {
            return false;
        }

        $stmt = $conn->prepare("UPDATE users SET full_name = :full_name, email = :email, phone = :phone, address = :address WHERE id = :id");

        $stmt->execute([
            'id' => $id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ]);

        return true;
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }

    public static function login($email, $password)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }


    public static function register($name, $email, $password, $phone, $address)
    {
        global $conn;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, address, role) VALUES (:full_name, :email, :phone, :password, :address, :role)");
        $stmt->execute([
            'full_name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
            'address' => $address,
            'role' => 'customer'
        ]);
        return $conn->lastInsertId();
    }

    public static function findByEmail($email)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePassword($id, $hashedPassword)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }

    public static function updateByEmail($email, $hashedPassword)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        return $stmt->execute([$hashedPassword, $email]);
    }

    public static function findByPhone($phone)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE phone = :phone");
        $stmt->execute(['phone' => $phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateRole($id, $role)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET role = :role WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'role' => $role
        ]);
        return $stmt->rowCount();
    }

    public static function count()
    {
        global $conn;
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
