<?php
require_once '../app/models/Favorites.php';

class FavoriteController
{
    public function addFavorite()
    {
        if (!isset($_SESSION["user"])) {
            die("Bạn cần đăng nhập để thêm vào yêu thích.");
        }

        if (!isset($_POST["car_id"])) {
            die("Lỗi: Không có car_id.");
        }

        $user_id = $_SESSION["user"]["id"] ?? null;
        $car_id = $_POST["car_id"] ?? null;

        if (!$user_id || !$car_id) {
            die("Lỗi: user_id hoặc car_id không hợp lệ.");
        }

        if ($favorites = Favorites::create($user_id, $car_id)) {
            header("Location: home");
            exit();
        } else {
            header("Location: home");
            exit();
        }
    }

    public function favoriteById() {
        $user_id = $_SESSION["user_id"]?? null;

        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }

        $favorites = Favorites::where($user_id);
        require_once '../app/views/user/favorite.php';
    }
}
