<?php

use FontLib\Table\Type\head;

require_once '../config/database.php';
require_once '../app/models/Used_cars.php';

class UsedCarsController
{
    public function showUsedCars()
    {
        $used_cars = Used_cars::getall();
        require_once '../app/views/list_used_cars/index.php';
    }

    public function showUsedCar($id)
    {
        $used_cars = Used_cars::getByid($id);
        $used_car = Used_cars::find($id);
        $images = Used_cars::getImages($id);
        if (!$used_car) {
            header("Location: /home?status=error&message=" . urlencode("Bài đăng không tồn tại!"));
            exit();
        }
        require_once '../app/views/used_cars/show.php';
    }

    public function addUsedCar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $imagePaths = [];

            if (!empty($_FILES['image_urls']['name'][0])) {
                $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
                $uploadDir = __DIR__ . '/../../public/uploads/used_cars/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $rawName = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['name']);
                $totalFiles = count($_FILES['image_urls']['name']);
                $id_user = $_SESSION['user']['id'];

                for ($i = 0; $i < $totalFiles; $i++) {
                    $image = false;
                    $name = $_FILES['image_urls']['name'][$i];
                    $tmpName = $_FILES['image_urls']['tmp_name'][$i];
                    $error = $_FILES['image_urls']['error'][$i];
                    $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    if ($error == 0 && in_array($fileExt, $allowedExt)) {
                        $newName = $rawName . '_' . ($i + 1) . '_' . $id_user . '.webp';
                        $uploadFile = $uploadDir . $newName;

                        // Tạo ảnh gốc từ đúng tmp file
                        if ($fileExt === 'jpg' || $fileExt === 'jpeg') {
                            $image = imagecreatefromjpeg($tmpName);
                        } elseif ($fileExt === 'png') {
                            $image = imagecreatefrompng($tmpName);
                            imagepalettetotruecolor($image);
                            imagealphablending($image, true);
                            imagesavealpha($image, true);
                        } elseif ($fileExt === 'webp') {
                            $image = imagecreatefromwebp($tmpName);
                        }

                        if ($image) {
                            $origWidth = imagesx($image);
                            $origHeight = imagesy($image);
                            $newWidth = 300;
                            $newHeight = intval($origHeight * ($newWidth / $origWidth));

                            $resized = imagecreatetruecolor($newWidth, $newHeight);
                            imagealphablending($resized, false);
                            imagesavealpha($resized, true);
                            imagecopyresampled(
                                $resized,
                                $image,
                                0,
                                0,
                                0,
                                0,
                                $newWidth,
                                $newHeight,
                                $origWidth,
                                $origHeight
                            );
                            imagedestroy($image);

                            if (imagewebp($resized, $uploadFile, 80)) {
                                imagedestroy($resized);
                                $imagePaths[] = '/uploads/used_cars/' . $newName;
                            }
                        }
                    }
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
                'image_urls' => $imagePaths
            ];

            if (Used_cars::addCar($data)) {
                if ($_SESSION['user']['role'] != 'admin') {
                    header("Location: /home?status=success&message=" . urlencode("Đã thêm bài đăng thành công!, Vui lòng chờ duyệt!"));
                    exit();
                } else {
                    header("Location: /admin");
                    exit();
                }
            } else {
                header("Location: /home?status=error&message=" . urlencode("Lỗi thêm bài đăng!"));
                exit();
            }
        }

        if (!isset($_SESSION['user']['id'])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập để thêm bài đăng!"));
            exit();
        }

        $brands = Brands::all();
        $categories = Categories::all();
        require_once '../app/views/used_cars/add_used_cars.php';
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = __DIR__ . '/../../public/uploads/used_cars/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Xử lý ảnh nếu có upload mới
            if (!empty($_FILES['image_url']['name']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
                $fileExt = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExt)) {
                    header("Location: /admin/used_cars?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!"));
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
                    case 'webp':
                        $image = imagecreatefromwebp($_FILES['image_url']['tmp_name']);
                        break;
                    default:
                        $image = false;
                }

                if ($image) {
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
                        $image_url = '/uploads/used_cars/' . $webpName;
                    } else {
                        imagedestroy($resized);
                        header("Location: /admin/used_cars?status=error&message=" . urlencode("Lưu ảnh WebP thất bại!"));
                        exit();
                    }
                } else {
                    header("Location: /admin/used_cars?status=error&message=" . urlencode("Không thể xử lý ảnh!"));
                    exit();
                }
            } else {
                // Không upload ảnh mới, giữ ảnh cũ
                $stmt = Used_cars::find($_POST['id']);
                $image_url = $stmt['normal_image_url'];
            }

            // Lấy dữ liệu khác
            $data = [
                'id' => $_POST['id'],
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
                'status' => $_POST['status'],
                'image_url' => $image_url,
            ];

            // Gọi model cập nhật
            if (Used_cars::edit($data)) {
                header("Location: /admin#used_cars?status=success&message=" . urlencode("Cập nhật xe đã qua sử dụng thành công!"));
                exit;
            } else {
                header("Location: /admin#used_cars?status=error&message=" . urlencode("Cập nhật thất bại!"));
                exit();
            }
        }

        // Hiển thị form edit
        $car = Used_cars::find($id);
        $brands = Brands::all();
        $categories = Categories::all();
        if (!$car) {
            header("Location: /admin#used_cars?status=error&message=" . urlencode("Không tìm thấy xe!"));
            exit();
        }
        require_once __DIR__ . "/../views/used_cars/edit_used_cars.php";
    }

    public function delete($id)
    {
        if (Used_cars::delete($id)) {
            header("Location: /admin#used_cars");
            exit();
        } else {
            header("Location: /admin#used_cars");
            exit();
        }
    }

    public function updateUsedCarStatus()
    {
        $used_carId = $_POST['used_car_id'] ?? null;
        $isActive = $_POST['status'] ?? null;

        // Kiểm tra giá trị đầu vào
        if ($used_carId !== null && $isActive !== null) {

            if (Used_cars::updateStatus($used_carId, $isActive)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
