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

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $full_name = $_POST['full_name'];
            $email     = $_POST['email'];
            $password  = $_POST['password'];
            $phone     = $_POST['phone'];
            $address   = $_POST['address'];
            if (!$full_name || !$email || !$password || !$phone || !$address) {
                header("Location: /admin#users");
                exit();
            }
            if (Users::register($full_name, $email, $password, $phone, $address)) {
                header("Location: /admin#users?status=success&message=" . urlencode("Thêm người dùng thành công!"));
                exit();
            } else {
                header("Location: /admin#users?status=error&message=" . urlencode("Thêm người dùng thất bại!"));
                exit();
            }
        }
        require_once '../app/views/user/register.php';
    }

    public function deleteUser($id)
    {
        if (Users::delete($id)) {
            header("Location: /admin");
            exit();
        } else {
            header("Location: /admin#users?status=error&message=" . urlencode("Xoá người dùng thất bại!"));
            exit();
        }
    }
    public function editUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $id = $_POST['id'];
            $role = $_POST['role'];
            if (Users::updateRole($id, $role)) {
                header("Location: /admin#users");
                exit();
            } else {
                header("Location: /admin#users?status=error&message=" . urlencode("Cập nhật vai trò thất bại!"));
                exit();
            }
        }

        $user = Users::find($id);
        require_once '../app/views/user/edit_user.php';
    }

}
