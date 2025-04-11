<?php
require_once '../app/models/Users.php';

class UserController
{

    public function index()
    {
        $users = Users::all();
        require_once '../app/views/user.php';
    }

    public function userById()
    {
        $id = $_SESSION["user"]["id"] ?? null;
        if (!$id) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập để xem thông tin tài khoản!"));
            exit();
        }
        $user = Users::find($id);
        require_once '../app/views/user/profile.php';
    }

    public function editProfile()
    {
        $id = $_SESSION["user"]["id"] ?? null;
        if (!$id) {
            header("Location: /home?status=error&message=" . urlencode("Đăng nhập để cập nhật thông tin tài khoản!"));
            exit();
        }
        $user = Users::find($id);
        require_once '../app/views/user/edit_profile.php';
    }

    public function updateProfile()
    {
        $id = $_SESSION["user"]["id"];
        $full_name = $_POST['full_name'] ?? '';
        $email     = $_POST['email'] ?? '';
        $phone     = $_POST['phone'] ?? '';
        $address   = $_POST['address'] ?? '';

        // Kiểm tra xem tất cả các trường có bị bỏ trống không
        if (empty($full_name) || empty($email) || empty($phone) || empty($address)) {
            header("Location: /edit_profile?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!"));
            exit();
        }
        
        // Gọi phương thức update
        if (Users::update($id, $full_name, $email, $phone, $address)) {
            $updatedUser = Users::find($id);
        
            $_SESSION['user'] = $updatedUser;
        
            header("Location: /profile?status=success&message=" . urlencode("Cập nhật thông tin thành công!"));
            exit();        
        } else {
            header("Location: /profile?status=error&message=" . urlencode("Cập nhật thông tin thất bại!"));
            exit();
        }
    }
}
