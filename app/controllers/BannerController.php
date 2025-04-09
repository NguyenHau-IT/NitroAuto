<?php

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

}
