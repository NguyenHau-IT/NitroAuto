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
        $fuel_type = isset($_POST['fuel_type']) ? $_POST['fuel_type'] : '';
        $car_type = isset($_POST['car_type']) && is_numeric($_POST['car_type']) ? $_POST['car_type'] : null;
        $year = isset($_POST['year_manufacture']) && is_numeric($_POST['year_manufacture']) ? $_POST['year_manufacture'] : null;
        $price_range = isset($_POST['price-range']) ? $_POST['price-range'] : null;

        // Điều kiện WHERE
        $whereConditions = [];
        if (!is_null($brand)) {
            $whereConditions[] = "Cars.brand_id = :brand_id";
        }
        if (!empty($search)) {
            $whereConditions[] = "Cars.name LIKE :search";
        }
        if (!empty($fuel_type)) {
            $whereConditions[] = "Cars.fuel_type = :fuel_type";
        }
        if (!is_null($car_type)) {
            $whereConditions[] = "Cars.category_id = :car_type";
        }
        if (!empty($year)) {
            $whereConditions[] = "Cars.year = :year";
        }
        if (!empty($price_range)) {
            $priceRange = explode('-', $price_range);
            if (count($priceRange) == 2) {
                $minPrice = (int)$priceRange[0];
                $maxPrice = (int)$priceRange[1];
                $whereConditions[] = "Cars.price BETWEEN :min_price AND :max_price";
            }
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
        // Gán giá trị cho fuel_type nếu có
        if (!empty($fuel_type)) {
            $stmt->bindParam(':fuel_type', $fuel_type, PDO::PARAM_STR);
        }
        // Gán giá trị cho car_type nếu có
        if (!empty($car_type)) {
            $stmt->bindParam(':car_type', $car_type, PDO::PARAM_INT);
        }
        // Gán giá trị cho year nếu có
        if (!empty($year)) {
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        }
        // Gán giá trị cho min_price và max_price nếu có
        if (!empty($price_range)) {
            $stmt->bindParam(':min_price', $minPrice, PDO::PARAM_INT);
            $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_INT);
        }

        // Thực thi truy vấn
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $brands = Brands::all();
        $categories = Categories::all();

        // Lấy lịch sử xem xe của người dùng (nếu có)
        $user_id = $_SESSION['user_id'] ?? null;
        $histories = HistoryViewCar::getHistoryByUser($user_id);

        // Gửi dữ liệu đến view
        require_once '../app/views/index.php';
    }
}
