<?php
require_once '../app/models/Users.php';

class UserController {
    
    public function index() {
        $users = Users::all();
        require_once '../app/views/user.php';
    }
    
    public function customer() {
        $users = Users::where('customer');
        require_once '../app/views/user.php';
    }    
    
    public function userById() {
        $id = $_SESSION["user"]["id"] ?? null;
        if (!$id) {
            header("Location: /error?status=error&message=" . urlencode("Không tìm thấy tài khoản đăng nhập!"));
            exit();
        }
        $user = Users::find($id);
        require_once '../app/views/user/profile.php';
    }

    public function showUserList() {
        global $conn;

        $stmt = $conn->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/user/user.php';
    }
}
?>
