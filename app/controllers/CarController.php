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

    public function showAddForm()
    {
        $brands = Brands::all();
        $categories = Categories::all();
        require_once __DIR__ . "/../views/cars/car_add.php";
    }

    public function storeCar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $car = new Cars();
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
                $uploadDir = 'D:NitroAuto/public/uploads/cars/';
                $uploadFile = $uploadDir . basename($_FILES['image_url']['name']);
                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) {
                    $data['image_url'] = '/uploads/cars/' . basename($_FILES['image_url']['name']);
                } else {
                    header("Location: /admin?status=error&message=" . urlencode("Thêm ảnh thất bại!"));
                    exit();
                }
            }
            $data = [
                'name' => $_POST['name'],
                'brand_id' => $_POST['brand_id'],
                'category_id' => $_POST['category_id'],
                'price' => $_POST['price'],
                'year' => $_POST['year'],
                'mileage' => $_POST['mileage'],
                'fuel_type' => $_POST['fuel_type'],
                'transmission' => $_POST['transmission'],
                'color' => $_POST['color'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description'],
                'image_url' => isset($data['image_url']) ? $data['image_url'] : null,
                'image_url3D' => $_POST['image_3d_url']
            ];

            if ($car->addCar($data)) {
                header("Location: /admin?status=success&message=" . urlencode("Thêm xe thành công!"));
                exit();
            } else {
                header("Location: /admin?status=error&message=" . urlencode("Thêm xe thất bại!"));
                exit();
            }
        }
    }

    public function edit($id)
    {
        $car = Cars::find($id);
        $brands = Brands::all();
        $categories = Categories::all();
        if (!$car) {
            header("Location: /admin?status=error&message=" . urlencode("Không tìm thấy xe!"));
            exit();
        }
        require_once __DIR__ . "/../views/cars/car_edit.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $car = new Cars();
            $uploadDir = 'D:NitroAuto/public/uploads/cars/';

            if (!empty($_FILES['image_url']['name']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['image_url']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) {
                    $image_url = '/uploads/cars/' . $fileName;
                } else {
                    header("Location: /admin?status=error&message=" . urlencode("Upload ảnh thất bại!"));
                    exit();
                }
            } else {
                // Nếu không có ảnh mới, giữ nguyên ảnh cũ
                $stmt = $car->find($_POST['id']);
                $image_url = $stmt['normal_image_url'];
            }

            // Lấy dữ liệu từ form
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
            $description = $_POST['description'];
            $created_at = $_POST['created_at'];
            $image_url = $image_url;
            $image_url3D = $_POST['image_url3D'];

            // Cập nhật vào database
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
                $description,
                $created_at,
                $image_url,
                $image_url3D
            )) {
                header("Location: /admin");
                exit;
            } else {
                header("Location: /admin?status=error&message=" . urlencode("Cập nhật xe thất bại!"));
                exit();
            }
        }
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

    public function search($id)
    {
        $brands = Brands::all();
        if (!is_numeric($id)) {
            header("Location: /error?status=error&message=" . urlencode("⚠️ ID hãng xe không hợp lệ!"));
            exit();
        }

        $cars = Cars::findByBrand($id);
        require_once '../app/views/cars/car_find.php';
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
        $accessories = Accessories::getByCarId($id);

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


    public function compareCar()
    {
        $allCars = Cars::all();
        require_once '../app/views/cars/compare.php';
    }

    public function compareCars()
    {
        $ids = $_POST['ids'] ?? [];

        // Validate dữ liệu đầu vào
        if (!is_array($ids) || count($ids) < 2) {
            echo '<div class="alert alert-warning">Cần chọn ít nhất 2 xe để so sánh.</div>';
            return;
        }

        // Kiểm tra tất cả id đều là số
        foreach ($ids as $id) {
            if (!is_numeric($id)) {
                echo '<div class="alert alert-danger">ID xe không hợp lệ.</div>';
                return;
            }
        }

        // Ép về số nguyên an toàn
        $ids = array_map('intval', $ids);

        // Tìm xe từ model (Cars có thể là model ORM hoặc class tĩnh tùy bạn)
        $cars = Cars::findList($ids);

        if (!$cars || count($cars) < 2) {
            echo '<div class="alert alert-warning">Không tìm thấy đủ thông tin xe để so sánh.</div>';
            return;
        }

        echo $this->renderComparisonTable($cars);
    }

    private function renderComparisonTable($cars)
    {
        // Tìm giá trị tốt nhất
        function getBest($cars, $key, $higher = true)
        {
            $values = array_column($cars, $key);

            if (empty($values)) {
                return null; // hoặc return 0, hoặc throw lỗi nhẹ
            }

            return $higher ? max($values) : min($values);
        }

        $bestPrice = getBest($cars, 'price', false);      // Giá thấp nhất
        $bestHp = getBest($cars, 'horsepower', true);     // Mã lực cao nhất

        ob_start();
?>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <tr>
                    <th>Thông tin</th>
                    <?php foreach ($cars as $car): ?>
                        <td>
                            <img src="<?= htmlspecialchars($car['normal_image_url']) ?>" width="150" alt="Ảnh xe"><br>
                            <strong><?= htmlspecialchars($car['name']) ?></strong>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Giá</th>
                    <?php foreach ($cars as $car): ?>
                        <td class="<?= ($bestPrice !== null && $car['price'] == $bestPrice) ? 'fw-bold text-success' : '' ?>">
                            <?= number_format($car['price']) ?> VND
                        </td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Mã lực</th>
                    <?php foreach ($cars as $car): ?>
                        <td class="<?= ($bestHp !== null && $car['horsepower'] == $bestHp) ? 'fw-bold text-success' : '' ?>">
                            <?= $car['horsepower'] ?> HP
                        </td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Năm sản xuất</th>
                    <?php foreach ($cars as $car): ?>
                        <td><?= htmlspecialchars($car['year']) ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Quãng đường đã đi</th>
                    <?php foreach ($cars as $car): ?>
                        <td><?= number_format($car['mileage']) ?> km</td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Nhiên liệu</th>
                    <?php foreach ($cars as $car): ?>
                        <td><?= htmlspecialchars($car['fuel_type']) ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Hộp số</th>
                    <?php foreach ($cars as $car): ?>
                        <td><?= htmlspecialchars($car['transmission']) ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Màu xe</th>
                    <?php foreach ($cars as $car): ?>
                        <td><?= htmlspecialchars($car['color']) ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Hãng</th>
                    <?php foreach ($cars as $car): ?>
                        <td><?= htmlspecialchars($car['brand_name']) ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Danh mục</th>
                    <?php foreach ($cars as $car): ?>
                        <td><?= htmlspecialchars($car['category_name']) ?></td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>

<?php
        return ob_get_clean();
    }
}
