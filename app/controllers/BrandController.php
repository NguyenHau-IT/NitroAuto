<?php
require_once '../app/models/Brands.php';

class BrandController
{
    public function index()
    {
        $brands = Brands::all();
        require_once '../app/views/index.php';
    }

    public function formadd()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $logoPath = $_POST['logo'] ?? null;

            if (empty($name) || empty($country)) {
                $errorMessage = empty($name) ? "Tên hãng không được để trống!" : "Quốc gia không được để trống!";
                header("Location: /admin#brand/add?status=error&message=" . urlencode($errorMessage));
                exit();
            }

            // Xử lý upload logo
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $allowedExt = ['jpg', 'jpeg', 'png'];
                $fileExt = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExt)) {
                    header("Location: /admin#brand/add?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!"));
                    exit();
                }

                // Đổi tên file dựa vào tên hãng
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', $name);
                $webpName = strtolower($safeName) . '-logo.webp';

                $uploadDir = __DIR__ . '/../../public/uploads/brands/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadFile = $uploadDir . $webpName;

                // Tạo ảnh từ nguồn upload
                switch ($fileExt) {
                    case 'jpg':
                    case 'jpeg':
                        $image = imagecreatefromjpeg($_FILES['logo']['tmp_name']);
                        break;
                    case 'png':
                        $image = imagecreatefrompng($_FILES['logo']['tmp_name']);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                    default:
                        $image = false;
                }

                if ($image) {
                    // Resize nhẹ logo (nếu muốn), ở đây giữ nguyên kích thước gốc
                    if (imagewebp($image, $uploadFile, 80)) {
                        imagedestroy($image);
                        $logoPath = '/uploads/brands/' . $webpName;
                    } else {
                        header("Location: /admin/brand/add?status=error&message=" . urlencode("Chuyển ảnh sang WebP thất bại!"));
                        exit();
                    }
                } else {
                    header("Location: /admin/brand/add?status=error&message=" . urlencode("Không thể xử lý ảnh!"));
                    exit();
                }
            } else {
                header("Location: /admin/brand/add?status=error&message=" . urlencode("Vui lòng chọn logo!"));
                exit();
            }

            // Gọi Model để thêm
            $success = Brands::create($name, $country, $logoPath);

            if ($success) {
                header("Location: /admin#brands?status=success&message=" . urlencode("Thêm hãng thành công!"));
                exit();
            } else {
                header("Location: /admin#brand/add?status=error&message=" . urlencode("Thêm hãng thất bại!"));
                exit();
            }
        }
        require_once '../app/views/brands/add_brand.php';
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $logoPath = $_POST['logo'] ?? null;

            if (empty($name) || empty($country)){
                $errorMessage = empty($name) ? "Tên hãng không được để trống!" : "Quốc gia không được để trống!";
                $stmt = Brands::find($id);
                $name = $stmt['name'];
                $country = $stmt['country'];
            }

            // Tạo thư mục upload nếu chưa có
            $uploadDir = __DIR__ . '/../../public/uploads/brands/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Kiểm tra có upload logo mới không
            if (!empty($_FILES['logo']['name']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
                $allowedExt = ['jpg', 'jpeg', 'png'];
                $fileExt = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExt)) {
                    header("Location: /admin/brand/edit/$id?status=error&message=" . urlencode("Định dạng ảnh không hợp lệ!"));
                    exit();
                }

                // Đổi tên logo theo tên hãng
                $safeName = preg_replace('/[^a-zA-Z0-9-_]/', '', $name);
                $webpName = strtolower($safeName) . '-logo.webp';
                $uploadFile = $uploadDir . $webpName;

                // Convert sang webp
                switch ($fileExt) {
                    case 'jpg':
                    case 'jpeg':
                        $image = imagecreatefromjpeg($_FILES['logo']['tmp_name']);
                        break;
                    case 'png':
                        $image = imagecreatefrompng($_FILES['logo']['tmp_name']);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                    default:
                        $image = false;
                }

                if ($image) {
                    if (imagewebp($image, $uploadFile, 80)) {
                        imagedestroy($image);
                        $logoPath = '/uploads/brands/' . $webpName;
                    } else {
                        header("Location: /admin/brand/edit/$id?status=error&message=" . urlencode("Chuyển ảnh sang WebP thất bại!"));
                        exit();
                    }
                } else {
                    header("Location: /admin/brand/edit/$id?status=error&message=" . urlencode("Không thể xử lý ảnh!"));
                    exit();
                }
            } else {
                // Không upload logo mới → dùng logo cũ từ DB
                $old = Brands::find($id);
                $logoPath = $old['logo'];
            }

            // Gọi model để cập nhật
            $success = Brands::update($id, $name, $country, $logoPath);

            if ($success) {
                header("Location: /admin#brands?status=success&message=" . urlencode("Cập nhật hãng thành công!"));
            } else {
                header("Location: /edit_brand/$id?status=error&message=" . urlencode("Cập nhật hãng thất bại!"));
            }
            exit();
        }

        // Nếu GET request → hiển thị form
        $brand = Brands::find($id);
        require_once __DIR__ . '/../views/brands/edit_brand.php';
    }


    public function delete($id)
    {
        if (Brands::delete($id)) {
            header("Location: /admin#brands");
            exit;
        } else {
            header("Location: /admin?status=error&message=" . urlencode("Xoá hãng thất bại!"));
            exit();
        }
    }
}
