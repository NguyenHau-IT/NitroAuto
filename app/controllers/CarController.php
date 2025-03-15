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
                'description' => $_POST['description']
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
            $image_url = $_POST['image_url']; // Lấy ảnh từ form
            $image_url3D = $_POST['image_url3D']; // Lấy ảnh 3D từ form
    
            if (Cars::update($id, $name, $brand_id, $category_id, $price, $year, $mileage, $fuel_type,
            $transmission, $color, $stock, $description, $created_at, $image_url , $image_url3D)) {
                header("Location: /admin");
                exit;
            } else {
                echo "Failed to update car.";
            }
        }
    }  
}
?>
