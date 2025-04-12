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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [];

            // Xử lý ảnh
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
                $allowedExt = ['jpg', 'jpeg', 'png'];
                $fileExt = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExt)) {
                    header("Location: /add_used_car?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!"));
                    exit();
                }

                // Đổi tên ảnh dựa vào tên xe (POST['name']), loại bỏ ký tự đặc biệt
                $newName = preg_replace('/[^a-zA-Z0-9-_]/', '', $_POST['name']);
                $webpName = $newName . '.webp';

                // Đường dẫn lưu ảnh
                $uploadDir = __DIR__ . '/../../public/uploads/used_cars/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Tạo thư mục nếu chưa có
                }

                $uploadFile = $uploadDir . $webpName;

                // Convert ảnh sang webp
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


                    if ($image && imagewebp($image, $uploadFile, 80)) {
                        imagedestroy($image);
                        $data['image_url'] = '/uploads/used_cars/' . $webpName;
                    } else {
                        header("Location: /add_used_car?status=error&message=" . urlencode("Chuyển ảnh sang WebP thất bại!"));
                        exit();
                    }
                } else {
                    header("Location: /add_used_car?status=error&message=" . urlencode("Không thể xử lý ảnh!"));
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
        if (isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
        } else {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập để thêm bài đăng!"));
            exit();
        }
        $brands = Brands::all();
        $categories = Categories::all();
        require_once '../app/views/used_cars/add_used_cars.php';
    }
}
