<?php
require_once '../config/database.php';

class Banner
{
    public $id;
    public $image_url;
    public $created_at;
    private $conn;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // 📌 1️⃣ Lấy danh sách tất cả banner
    public static function getAllBanners()
    {
        global $conn;
        $stmt = $conn->query("SELECT * FROM banners ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
