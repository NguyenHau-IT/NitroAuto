<?php

use FontLib\Table\Type\head;

class BannerController
{
    public function index()
    {
        $banners = Banner::getAllBanners();
        require_once '../app/views/banners/banner_list.php';
    }

    public function updateBannerStatus()
    {
        // Lấy dữ liệu từ POST
        $bannerId = $_POST['banner_id'] ?? null;
        $isActive = $_POST['is_active'] ?? null;

        // Kiểm tra giá trị đầu vào
        if ($bannerId !== null && $isActive !== null) {
            // Ép kiểu an toàn
            $bannerId = (int)$bannerId;
            $isActive = (int)$isActive;

            // Gọi model để update
            $result = Banner::updateBannerStatus($bannerId, $isActive);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Cập nhật thất bại']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
        }
    }

    public function addBanner()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type = $_POST['type'] ?? '';
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            $image_url = '';
            $created_at = $_POST['created_at'] ?? date('Y-m-d H:i:s');

            // Chuyển định dạng nếu là dạng HTML datetime-local
            if (str_contains($created_at, 'T')) {
                $created_at = str_replace('T', ' ', $created_at) . ':00';
            }

            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $baseUploadPath = __DIR__ . '/../../public/uploads/Image_Banner/';
                $typeFolder = strtolower($type);
                $uploadDir = $baseUploadPath . $typeFolder . '/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $originalName = pathinfo($_FILES['image_file']['name'], PATHINFO_FILENAME);
                $newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName) . '.webp';
                $targetPath = $uploadDir . $newFileName;

                // Resize + convert ảnh sang WebP
                $sourceImage = null;
                $sourcePath = $_FILES['image_file']['tmp_name'];
                $mime = mime_content_type($sourcePath);

                switch ($mime) {
                    case 'image/jpeg':
                        $sourceImage = imagecreatefromjpeg($sourcePath);
                        break;
                    case 'image/png':
                        $sourceImage = imagecreatefrompng($sourcePath);
                        break;
                    case 'image/webp':
                        $sourceImage = imagecreatefromwebp($sourcePath);
                        break;
                    default:
                        die("Unsupported image type: $mime");
                }

                if ($sourceImage) {
                    // Resize ảnh nếu > 1200px (giữ tỉ lệ)
                    $maxWidth = 1200;
                    $origWidth = imagesx($sourceImage);
                    $origHeight = imagesy($sourceImage);

                    if ($origWidth > $maxWidth) {
                        $ratio = $maxWidth / $origWidth;
                        $newWidth = $maxWidth;
                        $newHeight = round($origHeight * $ratio);

                        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                        imagedestroy($sourceImage); // Giải phóng ảnh cũ
                        $sourceImage = $resizedImage;
                    }

                    // Lưu dưới dạng .webp
                    imagewebp($sourceImage, $targetPath, 80); // 80 = chất lượng
                    imagedestroy($sourceImage);

                    // Đường dẫn lưu DB
                    $image_url = "/uploads/Image_Banner/{$typeFolder}/{$newFileName}";
                }
            }

            $data = [
                'image_url' => $image_url,
                'type' => $type,
                'created_at' => $created_at,
                'is_active' => $is_active
            ];

            if (Banner::createBanner($data)) {
                header('Location: /admin#banners');
                exit;
            } else {
                header('Location: /admin#banners?status=error');
                exit;
            }
        }
        require_once '../app/views/slice-bar/add_banner.php';
    }

    public function BannerEdit($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admin#banners?status=error');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? '';
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            $image_url = $_POST['image_url'] ?? '';
            if ($image_url == '') {
                $stmt = Banner::find($id);
                $image_url = $stmt['image_url'];
            }

            $data = [
                'image_url' => $image_url,
                'type' => $type,
                'is_active' => $is_active
            ];

            if (Banner::updateBanner($id, $data)) {
                header('Location: /admin#banners');
                exit;
            } else {
                header('Location: /admin#banners?status=error');
                exit;
            }
        }
        $banner = Banner::find($id);
        require_once '../app/views/slice-bar/edit_banner.php';
    }

    public function deleteBanner($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admin#banners?status=error');
            exit;
        }

        if (Banner::deleteBanner($id)) {
            header('Location: /admin#banners');
            exit;
        } else {
            header('Location: /admin#banners?status=error');
            exit;
        }
    }
}
