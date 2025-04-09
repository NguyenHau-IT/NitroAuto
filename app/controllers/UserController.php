<?php
require_once '../app/models/Users.php';

class UserController
{

    public function index()
    {
        $users = Users::all();
        require_once '../app/views/user.php';
    }

    public function customer()
    {
        $users = Users::where('customer');
        require_once '../app/views/user.php';
    }

    public function userById()
    {
        $id = $_SESSION["user"]["id"] ?? null;
        if (!$id) {
            header("Location: /home?status=error&message=" . urlencode("Không tìm thấy tài khoản đăng nhập!"));
            exit();
        }
        $user = Users::find($id);
        require_once '../app/views/user/profile.php';
    }

    public function showUserList()
    {
        global $conn;

        $stmt = $conn->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/user/user.php';
    }

    public function editProfile()
    {
        $id = $_SESSION["user"]["id"] ?? null;
        if (!$id) {
            header("Location: /home?status=error&message=" . urlencode("Không tìm thấy tài khoản đăng nhập!"));
            exit();
        }
        $user = Users::find($id);
        require_once '../app/views/user/edit_profile.php';
    }

    public function updateProfile()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /home?status=error&message=" . urlencode("Không tìm thấy tài khoản đăng nhập!"));
            exit();
        }

        $full_name = $_POST['full_name'] ?? '';
        $email     = $_POST['email'] ?? '';
        $phone     = $_POST['phone'] ?? '';
        $address   = $_POST['address'] ?? '';

        // Kiểm tra xem tất cả các trường có bị bỏ trống không
        if (empty($full_name) || empty($email) || empty($phone) || empty($address)) {
            header("Location: /error?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!") . "&href=edit_profile");
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

    public function showChangePasswordForm()
    {
        require_once '../app/views/user/change_password.php';
    }

    public function changePassword()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $user = Users::find($userId);

        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!password_verify($oldPassword, $user['password'])) {
            header("Location: /reset_password?status=erros&message=" . urlencode("Sai mật khẩu củ!"));
            exit(); 
        }

        if ($newPassword !== $confirmPassword) {
            header("Location: /reset_password?status=error&message=" . urlencode("Mật khẩu mới không khớp!"));
            exit(); 
        }

        if (strlen($newPassword) < 6) {
            header("Location: /reset_password?status=error&message=" . urlencode("Mật khẩu mới phải có ít nhất 6 ký tự!"));
            exit();
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        if(Users::updatePassword($userId, $hashedPassword))
        {
            header("Location: /home?status=success&message=" . urlencode("Đổi mật khẩu thành công!"));
            exit();
        }
        else
        {
            header("Location: /home?status=error&message=" . urlencode("Đổi mật khẩu thất bại!"));
            exit();
        }
    }
}
