<?php
require_once __DIR__ . "/../models/Cars.php";
require_once __DIR__ . "/../models/Brands.php";
require_once __DIR__ . "/../models/Categories.php";

class CarController {
    public function index() {
        $cars = Cars::all();
        require_once __DIR__ . "/../views/cars/list.php";
    }

    public function showAddForm() {
        $brands = Brands::all();
        $categories = Categories::all();
        require_once __DIR__ . "/../views/cars/car_add.php";
    }

    public function storeCar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $car = new Cars();
                        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
                $uploadDir = 'D:NitroAuto/public/uploads/cars/';
                $uploadFile = $uploadDir . basename($_FILES['image_url']['name']);
                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) {
                    $data['image_url'] = '/uploads/cars/' . basename($_FILES['image_url']['name']);
                } else {
                    echo "Failed to upload image.";
                    exit;
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
                header("Location: /admin");
                exit;
            } else {
                echo "Thêm xe thất bại!";
            }
        }
    }

    public function edit($id) {
        $car = Cars::find($id);
        $brands = Brands::all();
        $categories = Categories::all();
        if (!$car) {
            die("Car not found");
        }
        require_once __DIR__ . "/../views/cars/car_edit.php";
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $image_url = $_POST['image_url'];
            $image_url3D = $_POST['image_url3D'];
    
            if (Cars::update($id, $name, $brand_id, $category_id, $price, $year, $mileage, $fuel_type,
            $transmission, $color, $stock, $description, $created_at, $image_url , $image_url3D)) {
                header("Location: /admin");
                exit;
            } else {
                echo "Failed to update car.";
            }
        }
    }  

    public function delete($id) {
        if (Cars::delete($id)) {
            header("Location: /admin");
            exit;
        } else {
            echo "Failed to delete car.";
        }
    }

    public function search($id) {
        $brands = Brands::all();
        if (!is_numeric($id)) {
            die("⚠️ ID hãng xe không hợp lệ!");
        }

        $cars = Cars::findByBrand($id);
        require_once '../app/views/cars/car_find.php';
    }

    public function showCarDetail($id) {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
        $stmt->execute([$id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt2 = $conn->prepare("SELECT image_url, image_type FROM car_images WHERE car_id = ? AND image_type = '3D'");
        $stmt2->execute([$id]);
        $images = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/cars/car_detail.php';
    }
}
?>
