<?php
require_once '../app/models/Favorites.php';

class FavoriteController
{
    public function addFavorite()
    {
        if (!isset($_SESSION["user"])) {
            header("Location: /error?status=error&message=" . urlencode("Bạn cần đăng nhập trước khi thêm vào danh sách!"));
            exit();
        }

        if (!isset($_POST["car_id"])) {
            header("Location: /error?status=error&message=" . urlencode("Lỗi khi thêm vào danh sách!"));
            exit();
        }

        $user_id = $_SESSION["user"]["id"] ?? null;
        $car_id = $_POST["car_id"] ?? null;

        if (!$user_id || !$car_id) {
            header("Location: /error?status=error&message=" . urlencode("Lỗi khi thêm vào danh sách!"));
            exit();
        }

        if ($favorites = Favorites::create($user_id, $car_id)) {
            header("Location: /success?status=success&message=" . urlencode("Đã thêm vào danh sách yêu thích!"));
            exit();
        } else {
            header("Location: /error?status=error&message=" . urlencode("Bạn đã thêm xe vào danh sách!"));
            exit();
        }
    }

    public function favoriteById()
    {
        $user_id = $_SESSION["user_id"] ?? null;

        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }

        $favorites = Favorites::where($user_id);
        require_once '../app/views/user/favorite.php';
    }

    public function deleteFavorite($id)
    {
        if ($favorites = Favorites::delete($id)) {
            header("Location: /success?status=success&message=" . urlencode("Đã xoá xe khỏi danh sách yêu thích!"));
            exit();
        } else {
            header("Location: /error?status=error&message=" . urlencode("Lỗi khi xoá xe khỏi danh sách yêu thích!"));
            exit();
        }
    }
}
