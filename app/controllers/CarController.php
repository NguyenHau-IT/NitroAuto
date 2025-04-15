<?php
require_once __DIR__ . "/../models/Cars.php";
require_once __DIR__ . "/../models/Brands.php";
require_once __DIR__ . "/../models/Categories.php";
require_once __DIR__ . "/../models/HistoryViewCar.php";
require_once __DIR__ . "/../models/Accessories.php";

class CarController
{
    public function index()
    {
        $cars = Cars::all();
        require_once __DIR__ . "/../views/cars/list.php";
    }

    public function addCar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [];

            // Xử lý ảnh
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
                $allowedExt = ['jpg', 'jpeg', 'png'];
                $fileExt = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExt)) {
                    header("Location: /admin?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!"));
                    exit();
                }

                // Đổi tên ảnh dựa vào tên xe (POST['name']), loại bỏ ký tự đặc biệt
                $newName = preg_replace('/[^a-zA-Z0-9-_]/', '', $_POST['name']);
                $webpName = $newName . '.webp';

                // Đường dẫn lưu ảnh
                $uploadDir = __DIR__ . '/../../public/uploads/cars/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Tạo thư mục nếu chưa có
                }

                $uploadFile = $uploadDir . $webpName;

                // Convert ảnh sang WebP với resize về thumbnail ~300px
                switch ($fileExt) {
                    case 'jpg':
                    case 'jpeg':
                        $image = imagecreatefromjpeg($_FILES['image_url']['tmp_name']);
                        break;
                    case 'png':
                        $image = imagecreatefrompng($_FILES['image_url']['tmp_name']);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                    default:
                        $image = false;
                }

                if ($image) {
                    $origWidth = imagesx($image);
                    $origHeight = imagesy($image);
                    $newWidth = 300; // Thumbnail chiều rộng
                    $newHeight = intval($origHeight * ($newWidth / $origWidth));

                    $resized = imagecreatetruecolor($newWidth, $newHeight);
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                    imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                    imagedestroy($image); // free original

                    if (imagewebp($resized, $uploadFile, 80)) {
                        imagedestroy($resized);
                        $data['image_url'] = '/uploads/cars/' . $webpName;
                    } else {
                        header("Location: /admin?status=error&message=" . urlencode("Lưu ảnh WebP thất bại!"));
                        exit();
                    }
                } else {
                    header("Location: /admin?status=error&message=" . urlencode("Không thể xử lý ảnh!"));
                    exit();
                }
            }

            $name = $_POST['name'];
            $brand_id = $_POST['brand_id'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];
            $fuel_type = $_POST['fuel_type'];
            $transmission = $_POST['transmission'];
            $color = $_POST['color'];
            $stock = $_POST['stock'];
            $horsepower = $_POST['horsepower'];
            $description = $_POST['description'];
            $created_at = $_POST['created_at'];
            $image_url3D = $_POST['image_3d_url'];

            // Danh sách các trường cần kiểm tra và thông báo lỗi tương ứng
            $fields = [
                'name' => 'Tên xe không được để trống!',
                'brand_id' => 'Hãng xe không được để trống!',
                'category_id' => 'Loại xe không được để trống!',
                'description' => 'Mô tả xe không được để trống!',
                'price' => 'Giá xe không được để trống!',
                'year' => 'Năm sản xuất không được để trống!',
                'mileage' => 'Số km đã đi không được để trống!',
                'fuel_type' => 'Loại nhiên liệu không được để trống!',
                'transmission' => 'Số sàn không được để trống!',
                'color' => 'Màu xe không được để trống!',
                'stock' => 'Số lượng xe không được để trống!',
                'horsepower' => 'Công suất xe không được để trống!'
            ];

            foreach ($fields as $field => $message) {
                if (empty($$field)) {
                    header("Location: /admin?status=error&message=" . urlencode($message));
                    exit();
                }
            }
            // Gán các dữ liệu còn lại
            $data += [
                'name' => $name,
                'brand_id' => $brand_id,
                'category_id' => $category_id,
                'price' => $price,
                'year' => $year,
                'mileage' => $mileage,
                'fuel_type' => $fuel_type,
                'transmission' => $transmission,
                'color' => $color,
                'stock' => $stock,
                'horsepower' => $horsepower,
                'description' => $description,
                'image_url' => isset($data['image_url']) ? $data['image_url'] : null,
                'image_url3D' => $image_url3D
            ];

            // Lưu vào DB
            if (Cars::addCar($data)) {
                header("Location: /admin?status=success&message=" . urlencode("Thêm xe thành công!"));
                exit();
            } else {
                header("Location: /admin?status=error&message=" . urlencode("Thêm xe thất bại!"));
                exit();
            }
        }
        $brands = Brands::all();
        $categories = Categories::all();
        require_once __DIR__ . "/../views/cars/car_add.php";
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = __DIR__ . '/../../public/uploads/cars/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Xử lý ảnh nếu có upload mới
            if (!empty($_FILES['image_url']['name']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $allowedExt = ['jpg', 'jpeg', 'png'];
                $fileExt = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExt)) {
                    header("Location: /admin?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!"));
                    exit();
                }

                // Đổi tên ảnh theo tên xe
                $newName = preg_replace('/[^a-zA-Z0-9-_]/', '', $_POST['name']);
                $webpName = $newName . '.webp';
                $uploadFile = $uploadDir . $webpName;

                // Tạo ảnh từ file upload
                switch ($fileExt) {
                    case 'jpg':
                    case 'jpeg':
                        $image = imagecreatefromjpeg($_FILES['image_url']['tmp_name']);
                        break;
                    case 'png':
                        $image = imagecreatefrompng($_FILES['image_url']['tmp_name']);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                    default:
                        $image = false;
                }

                if ($image) {
                    // Resize về thumbnail 300px chiều rộng
                    $origWidth = imagesx($image);
                    $origHeight = imagesy($image);
                    $newWidth = 300;
                    $newHeight = intval($origHeight * ($newWidth / $origWidth));

                    $resized = imagecreatetruecolor($newWidth, $newHeight);
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                    imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                    imagedestroy($image);

                    if (imagewebp($resized, $uploadFile, 80)) {
                        imagedestroy($resized);
                        $image_url = '/uploads/cars/' . $webpName;
                    } else {
                        header("Location: /admin?status=error&message=" . urlencode("Lưu ảnh WebP thất bại!"));
                        exit();
                    }
                } else {
                    header("Location: /admin?status=error&message=" . urlencode("Không thể xử lý ảnh!"));
                    exit();
                }
            } else {
                // Không upload ảnh mới, giữ ảnh cũ
                $stmt = Cars::find($_POST['id']);
                $image_url = $stmt['normal_image_url'];
            }

            // Lấy dữ liệu khác
            $id = $_POST['id'];
            $name = $_POST['name'];
            $brand_id = $_POST['brand_id'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];
            $fuel_type = $_POST['fuel_type'];
            $transmission = $_POST['transmission'];
            $color = $_POST['color'];
            $stock = $_POST['stock'];
            $horsepower = $_POST['horsepower'];
            $description = $_POST['description'];
            $created_at = $_POST['created_at'];
            $image_url3D = $_POST['image_url3D'];

            // Danh sách các trường cần kiểm tra và thông báo lỗi tương ứng
            $fields = [
                'name' => 'Tên xe không được để trống!',
                'brand_id' => 'Hãng xe không được để trống!',
                'category_id' => 'Loại xe không được để trống!',
                'description' => 'Mô tả xe không được để trống!',
                'price' => 'Giá xe không được để trống!',
                'year' => 'Năm sản xuất không được để trống!',
                'mileage' => 'Số km đã đi không được để trống!',
                'fuel_type' => 'Loại nhiên liệu không được để trống!',
                'transmission' => 'Số sàn không được để trống!',
                'color' => 'Màu xe không được để trống!',
                'stock' => 'Số lượng xe không được để trống!',
                'horsepower' => 'Công suất xe không được để trống!'
            ];

            // Kiểm tra từng trường
            foreach ($fields as $field => $message) {
                if (empty($$field)) {
                    header("Location: /admin?status=error&message=" . urlencode($message));
                    exit();
                }
            }

            // Cập nhật DB
            if (Cars::update(
                $id,
                $name,
                $brand_id,
                $category_id,
                $price,
                $year,
                $mileage,
                $fuel_type,
                $transmission,
                $color,
                $stock,
                $horsepower,
                $description,
                $created_at,
                $image_url,
                $image_url3D
            )) {
                header("Location: /admin?status=success&message=" . urlencode("Cập nhật xe thành công!"));
                exit;
            } else {
                header("Location: /admin?status=error&message=" . urlencode("Cập nhật xe thất bại!"));
                exit();
            }
        }

        // Hiển thị form edit
        $car = Cars::find($id);
        $brands = Brands::all();
        $categories = Categories::all();
        if (!$car) {
            header("Location: /admin?status=error&message=" . urlencode("Không tìm thấy xe!"));
            exit();
        }
        require_once __DIR__ . "/../views/cars/car_edit.php";
    }

    public function delete($id)
    {
        if (Cars::delete($id)) {
            header("Location: /admin");
            exit;
        } else {
            header("Location: /admin?status=error&message=" . urlencode("Xoá xe thất bại!"));
            exit();
        }
    }

    public function showCarDetail($id)
    {
        global $conn;

        $car = Cars::find($id);

        $stmt2 = $conn->prepare("SELECT image_url, image_type FROM car_images WHERE car_id = :id AND image_type = '3D'");
        $stmt2->execute([':id' => $id]);
        $images = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $carByBrand = Cars::findByBrand($car['brand_id']);
        $cars = Cars::findByCategory($car['category_id'], $id);
        $accessories = Accessories::all();

        if (!isset($_SESSION["user_id"])) {
            require_once '../app/views/cars/car_detail.php';
        } else {
            $data = [
                "user_id" => $_SESSION["user_id"],
                "car_id" => $id,
                "ip_address" => $_SERVER['REMOTE_ADDR'],
                "user_agent" => $_SERVER['HTTP_USER_AGENT']
            ];
            HistoryViewCar::create($data);
        }
        require_once '../app/views/cars/car_detail.php';
    }

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
                        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS normal_image_url,
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
                        (SELECT image_url FROM Car_images WHERE Car_images.car_id = Cars.id AND image_type = 'normal') AS normal_image_url,
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

    public function compare()
    {
        $cars = Cars::all();
        require_once '../app/views/cars/compare.php';
    }

    public function compareCars()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $car_ids = $data['car_ids'] ?? [];

        if (count($car_ids) >= 2 && count($car_ids) <= 3) {
            $cars = [];

            foreach ($car_ids as $id) {
                $cars[] = Cars::find($id);
            }

            require_once '../app/views/cars/compare_result.php';
        }
    }
}
