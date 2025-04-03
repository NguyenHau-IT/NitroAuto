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
                    header("Location: /error?status=error&message=" . urlencode("Thêm ảnh thất bại!"));
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
                header("Location: /success?status=success&message=" . urlencode("Thêm xe thành công!") . "&href=/admin");
                exit();
            } else {
                header("Location: /error?status=error&message=" . urlencode("Thêm xe thất bại!") . "&href=/admin");
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
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy xe!"));
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
                    header("Location: /error?status=error&message=" . urlencode("Upload ảnh thất bại!"));
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
                header("Location: /admin?status=success&message=" . urlencode("Cập nhật xe thành công!") . "&href=/admin");
                exit;
            } else {
                header("Location: /error?status=error&message=" . urlencode("Cập nhật xe thất bại!") . "&href=/admin");
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
            header("Location: /error?status=error&message=" . urlencode("Xoá xe thất bại!"));
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
            exit();
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
}
