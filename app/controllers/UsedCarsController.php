<?php
require_once '../config/database.php';
require_once '../app/models/Used_cars.php';

class UsedCarsController
{
    public function showUsedCars()
    {
        $used_cars = Used_cars::all();
        require_once '../app/views/list_used_cars/index.php';
    }

    public function showUsedCar($id)
    {
        $used_cars = Used_cars::getAll($id);
        $used_car = Used_cars::find($id);
        if (!$used_car) {
            header("Location: /home?status=error&message=" . urlencode("Bài đăng không tồn tại!"));
            exit();
        }
        require_once '../app/views/used_cars/show.php';
    }

    public function addUsedCar()
    {
        $brands = Brands::all();
        $categories = Categories::all();
        require_once '../app/views/used_cars/add_used_cars.php';
    }

    public function storeCar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
                $uploadDir = 'D:NitroAuto/public/uploads/used_cars/';
                $uploadFile = $uploadDir . basename($_FILES['image_url']['name']);
                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) {
                    $data['image_url'] = '/uploads/used_cars/' . basename($_FILES['image_url']['name']);
                } else {
                    header("Location: /add_used_car?status=error&message=" . urlencode("Thêm ảnh thất bại!"));
                    exit();
                }
            }
            $data = [
                'user_id' => $_SESSION['user']['id'],
                'name' => $_POST['name'],
                'brand_id' => $_POST['brand_id'],
                'category_id' => $_POST['category_id'],
                'price' => $_POST['price'],
                'year' => $_POST['year'],
                'mileage' => $_POST['mileage'],
                'fuel_type' => $_POST['fuel_type'],
                'transmission' => $_POST['transmission'],
                'color' => $_POST['color'],
                'description' => $_POST['description'],
                'image_url' => isset($data['image_url']) ? $data['image_url'] : null
            ];

            if (Used_cars::addCar($data)) {
                header("Location: /home?status=success&message=" . urlencode("Đã thêm bài đăng thành công!, Vui lòng chờ duyệt!"));
                exit();
            } else {
                header("Location: /home?status=error&message=" . urlencode("Lỗi thêm bài đăng!"));
                exit();
            }
        }
    }
}