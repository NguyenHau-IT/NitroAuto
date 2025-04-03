<?php
require_once '../config/database.php';

class Banner
{
    public $id;
    public $image_url;
    public $created_at;
    public $type;

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
        $stmt = $conn->query("SELECT * FROM banners ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 📌 1️⃣ Lấy danh sách tất cả banner
    public static function getAllBanners()
    {
        global $conn;
        $stmt = $conn->query("SELECT * FROM banners WHERE type = 'slide' ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function banner_left()
    {
        global $conn;
        $stmt = $conn->query("SELECT TOP 1 * FROM banners WHERE type = 'left' ORDER BY created_at DESC");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function banner_right()
    {
        global $conn;
        $stmt = $conn->query("SELECT TOP 1 * FROM banners WHERE type = 'right' ORDER BY created_at DESC");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    
}
