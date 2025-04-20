<?php
require_once '../app/models/Favorites.php';

class FavoriteController
{
    public function addFavorite()
    {
        $user_id = $_SESSION["user"]["id"] ?? null;
        $car_id = $_POST["car_id"] ?? null;
        if (!isset($_SESSION["user"])) {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Bạn cần đăng nhập trước khi thêm vào danh sách!"));
            exit();
        }

        if (!isset($_POST["car_id"])) {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Lỗi khi thêm vào danh sách!"));
            exit();
        }

        if (!$user_id || !$car_id) {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Lỗi khi thêm vào danh sách!"));
            exit();
        }

        if ($favorites = Favorites::create($user_id, $car_id)) {
            header("Location: /car_detail/$car_id?status=success&message=" . urlencode("Đã thêm vào danh sách yêu thích!"));
            exit();
        } else {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Xe đã có trong danh sách yêu thích!"));
            exit();
        }
    }

    public function favoriteById()
    {
        $user_id = $_SESSION["user"]['id'] ?? null;

        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /home?status=error&message=" . urlencode("Bạn cần đăng nhập trước khi xem danh sách yêu thích!"));
            exit;
        }

        $favorites = Favorites::where($user_id);
        require_once '../app/views/user/favorite.php';
    }

    public function deleteFavorite()
    {
        if (!isset($_POST["car_id"])) {
            $car_id = $_POST["car_id"] ?? '';
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Lỗi khi xoá yêu thích!"));
            exit();
        }

        $user_id = $_SESSION["user"]["id"] ?? null;
        $car_id = $_POST["car_id"] ?? null;

        if (!$user_id || !$car_id) {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Lỗi khi xoá yêu thích!"));
            exit();
        }

        if ($favorites = Favorites::delete($user_id, $car_id)) {
            header("Location: /car_detail/$car_id?status=success&message=" . urlencode("Đã xoá yêu thích!"));
            exit();
        } else {
            header("Location: /car_detail/$car_id?status=error&message=" . urlencode("Xe không còn danh sách yêu thích!"));
            exit();
        }
    }

    public function deleteFavoriteById($id)
    {
        if (Favorites::deleteById($id)) {
            header("Location: /favorites?status=success&message=" . urlencode("Xoá yêu thích thành công!"));
            exit();
        } else {
            header("Location: /favorites?status=success&message=" . urlencode("Xoá yêu thích thành công!"));
            exit();
        }
    }
}
