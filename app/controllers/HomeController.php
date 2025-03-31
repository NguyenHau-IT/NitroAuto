<?php
require_once '../config/database.php';
require_once '../app/models/Brands.php';
require_once '../app/models/Cars.php';
require_once '../app/models/HistoryViewCar.php';

class HomeController
{
    public function index()
    {
        global $conn;

        // Lấy dữ liệu từ form
        $sort = isset($_POST['sortCar']) && in_array($_POST['sortCar'], ['asc', 'desc']) ? $_POST['sortCar'] : '';
        $brand = isset($_POST['brand']) && is_numeric($_POST['brand']) ? $_POST['brand'] : null;
        $search = isset($_POST['search']) ? trim($_POST['search']) : '';

        // Điều kiện WHERE
        $whereConditions = [];
        if (!is_null($brand)) {
            $whereConditions[] = "Cars.brand_id = :brand_id";
        }
        if (!empty($search)) {
            $whereConditions[] = "Cars.name LIKE :search";
        }

        // Kết hợp các điều kiện
        $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

        // Điều kiện ORDER BY
        $sortCondition = "";
        if ($sort == 'asc') {
            $sortCondition = "ORDER BY Cars.price ASC";
        } elseif ($sort == 'desc') {
            $sortCondition = "ORDER BY Cars.price DESC";
        }

        // Câu SQL hoàn chỉnh
        $sql = "SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description,
        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS image,
        Brands.name AS brand
    FROM Cars
    JOIN Brands ON Brands.id = Cars.brand_id
    $whereClause
    $sortCondition";

        // Chuẩn bị statement
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho brand nếu có
        if (!is_null($brand)) {
            $stmt->bindParam(':brand_id', $brand, PDO::PARAM_INT);
        }
        // Gán giá trị cho search nếu có
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }

        // Thực thi truy vấn
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $brands = Brands::all();

        // Lấy lịch sử xem xe của người dùng (nếu có)
        $user_id = $_SESSION['user_id'] ?? null;
        $histories = HistoryViewCar::getHistoryByUser($user_id);

        // Gửi dữ liệu đến view
        require_once '../app/views/index.php';
    }
}
