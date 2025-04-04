<?php

class BannerController
{
    public function index()
    {
        $banners = Banner::getAllBanners();
        require_once '../app/views/banners/banner_list.php';
    }

    public function toggleBannerStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['banner_id'] ?? 0);
            $current_status = (int)($_POST['current_status'] ?? 1);
            $new_status = $current_status ? 0 : 1;

            $success = Banner::updateBannerStatus($id, $new_status);

            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
            exit();
        }
    }
}
