<?php
require_once '../config/database.php';
require_once '../app/models/Brands.php';
require_once '../app/models/Cars.php';
require_once '../app/models/HistoryViewCar.php';
require_once '../app/models/Banner.php';

class HomeController
{
    public function index()
    {
        global $conn;

        $sql = "SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description, Categories.name AS category_name,
        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS image,
        Brands.name AS brand
        FROM Cars
        JOIN Brands ON Brands.id = Cars.brand_id
        JOIN Categories ON Categories.id = Cars.category_id";

        // Chuẩn bị statement
        $stmt = $conn->prepare($sql);

        // Thực thi truy vấn
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $brands = Brands::getByStock();
        $categories = Categories::getByCar();
        $banners = Banner::getAllBanners();

        // Lấy lịch sử xem xe của người dùng (nếu có)
        $user_id = $_SESSION['user_id'] ?? null;
        $histories = HistoryViewCar::getHistoryByUser($user_id);

        // Gửi dữ liệu đến view
        require_once '../app/views/index.php';
    }
}
