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
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy tài khoản đăng nhập!"));
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
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy tài khoản đăng nhập!"));
            exit();
        }
        $user = Users::find($id);
        require_once '../app/views/user/edit_profile.php';
    }

    public function updateProfile()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy tài khoản đăng nhập!"));
            exit();
        }
    
        // Kiểm tra dữ liệu được gửi
        $data = [
            'id' => $id,
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address']
        ];
    
        // Kiểm tra xem tất cả các trường có bị bỏ trống không
        if (empty($data['full_name']) || empty($data['email']) || empty($data['phone']) || empty($data['address'])) {
            header("Location: /error?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!") . "&href=edit_profile");
            exit();
        }
        
        // Gọi phương thức update và kiểm tra kết quả
        if (Users::update($data)) {
            header("Location: /success?status=success&message=" . urlencode("Cập nhật thông tin thành công!") . "&href=profile");
            exit();
        } else {
            header("Location: /error?status=error&message=" . urlencode("Cập nhật thông tin thất bại!") . "&href=profile");
            exit();
        }
    }    
}
