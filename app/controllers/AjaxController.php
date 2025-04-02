<?php
require_once '../config/database.php';
require_once '../app/models/Brands.php';
require_once '../app/models/Cars.php';
require_once '../app/models/HistoryViewCar.php';

class AjaxController
{
    public static function filterCar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            global $conn;

            $sort = $_POST['sortCar'] ?? '';
            $brand = isset($_POST['brand']) && is_numeric($_POST['brand']) ? $_POST['brand'] : null;
            $search = $_POST['search'] ?? '';
            $fuel_type = $_POST['fuel_type'] ?? '';
            $car_type = isset($_POST['car_type']) && is_numeric($_POST['car_type']) ? $_POST['car_type'] : null;
            $year = isset($_POST['year_manufacture']) && is_numeric($_POST['year_manufacture']) ? $_POST['year_manufacture'] : null;
            $price = $_POST['price_range'] ?? null;

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
            if (!empty($price)) {
                $priceRange = explode('-', $price);
                $minPrice = isset($priceRange[0]) ? (int)$priceRange[0] : 0;
                $maxPrice = isset($priceRange[1]) ? (int)$priceRange[1] : PHP_INT_MAX;
                $whereConditions[] = "Cars.price BETWEEN :min_price AND :max_price";
            }

            $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

            $sortCondition = $sort === 'asc' ? "ORDER BY Cars.price ASC" : ($sort === 'desc' ? "ORDER BY Cars.price DESC" : "");

            $sql = "SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description, Categories.name AS category_name,
                        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS image,
                        Brands.name AS brand
                        FROM Cars
                        JOIN Brands ON Brands.id = Cars.brand_id
                        JOIN Categories ON Categories.id = Cars.category_id
                        $whereClause
                        $sortCondition";

            $stmt = $conn->prepare($sql);

            if (!is_null($brand)) {
                $stmt->bindParam(':brand_id', $brand, PDO::PARAM_INT);
            }
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }
            if (!empty($fuel_type)) {
                $stmt->bindParam(':fuel_type', $fuel_type, PDO::PARAM_STR);
            }
            if (!empty($car_type)) {
                $stmt->bindParam(':car_type', $car_type, PDO::PARAM_INT);
            }
            if (!empty($year)) {
                $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            }
            if (!empty($price)) {
                $stmt->bindParam(':min_price', $minPrice, PDO::PARAM_INT);
                $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_INT);
            }

            $stmt->execute();
            $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once '../app/views/cars/car_list.php';
        }
    }

    public static function resetFilters()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            global $conn;

            $sql = "SELECT Cars.id, Cars.name, Cars.brand_id, Cars.year, Cars.stock, Cars.price, Cars.fuel_type, Cars.description, Categories.name AS category_name,
                        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS image,
                        Brands.name AS brand
                        FROM Cars
                        JOIN Brands ON Brands.id = Cars.brand_id
                        JOIN Categories ON Categories.id = Cars.category_id";

            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once '../app/views/cars/car_list.php';
        }
        require_once '../app/views/cars/filter.php';
    }
}
