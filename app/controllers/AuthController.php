<?php
require_once '../app/models/Users.php';
require_once '../vendor/autoload.php';

use Twilio\Rest\Client;
use Google\Client as Google_Client;
use Google\Service\Oauth2;

class AuthController
{
    private $client;

    public function __construct()
    {
        $config = require dirname(__DIR__, 2) . '/config/config.php';

        $this->client = new Google_Client();
        $this->client->setClientId($config['GOOGLE_CLIENT_ID']);
        $this->client->setClientSecret($config['GOOGLE_CLIENT_SECRET']);
        $this->client->setRedirectUri($config['GOOGLE_REDIRECT_URI']);
        $this->client->addScope("email");
        $this->client->addScope("profile");
        
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["full_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];

            if (Users::register($name, $email, $password, $phone, $address)) {
                header("Location: /login?status=success&message=" . urlencode("Đăng kí thành công vui lòng đăng nhập!"));
                exit();
            } else {
                header("Location: /register?status=error&message=" . urlencode("Đăng kí thất bại vui lòng đăng kí lại!"));
                exit();
            }
        }
        require_once '../app/views/user/register.php';
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = Users::login($email, $password);
            if ($user) {
                session_start();
                $_SESSION["user"] = $user;
                $_SESSION["user_id"] = $user["id"];

                header("Location: /home?status=success&message=" . urlencode("Đăng nhập thành công"));
                exit();
            } else {
                header("Location: /login?status=error&message=" . urlencode("Đăng nhập thất bại vui lòng đăng nhập lại!"));
                exit();
            }
        }
        require_once '../app/views/user/login.php';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header("Location: /home");
        exit();
    }


    public function redirectToGoogle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth2_state'] = $state;

        $this->client->setState($state);
        $authUrl = $this->client->createAuthUrl();

        error_log("Chuyển hướng đến Google: " . $authUrl);
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit(); // Rất quan trọng để dừng sau redirect
    }

    public function handleGoogleCallback()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: text/plain'); // Để hiện rõ lỗi nếu có

        // Bước 1: Check code
        if (!isset($_GET['code'])) {
            error_log("Không có mã code từ Google.");
            echo "DEBUG: Không có mã code";
            exit();
        }
        echo "DEBUG: Có mã code ✔️\n";

        // Bước 2: Check state
        if (!isset($_GET['state']) || !isset($_SESSION['oauth2_state']) || $_GET['state'] !== $_SESSION['oauth2_state']) {
            error_log("Lỗi bảo mật: state không hợp lệ.");
            echo "DEBUG: State không hợp lệ ❌";
            exit();
        }

        echo "DEBUG: State hợp lệ ✔️\n";
        unset($_SESSION['oauth2_state']);

        // Bước 3: Lấy token
        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['error']) || !isset($token['access_token'])) {
                error_log("Lỗi token: " . json_encode($token));
                echo "DEBUG: Lỗi khi lấy token ❌\n";
                exit();
            }
            $this->client->setAccessToken($token);
            echo "DEBUG: Lấy token thành công ✔️\n";
        } catch (Exception $e) {
            error_log("Lỗi khi lấy access token: " . $e->getMessage());
            echo "DEBUG: Exception khi lấy token ❌\n";
            echo "Chi tiết lỗi: " . $e->getMessage(); // 👈 Thêm dòng này để thấy lỗi
            exit();
        }

        // Bước 4: Lấy user info
        try {
            $oauth = new \Google\Service\Oauth2($this->client);
            $userInfo = $oauth->userinfo->get();
            echo "DEBUG: Lấy user info thành công ✔️\n";
        } catch (Exception $e) {
            error_log("Lỗi khi lấy thông tin user: " . $e->getMessage());
            echo "DEBUG: Exception khi lấy user info ❌\n";
            exit();
        }

        // Bước 5: Kiểm tra & tạo user
        try {
            $user = Users::findByEmail($userInfo->email);
        
            if (!$user) {
                echo "DEBUG: User chưa tồn tại. Tạo mới...\n";
        
                $password = '123456'; // Mật khẩu mặc định
                $phone = '0' . str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);
                $address = 'Địa chỉ mặc định';
        
                $newUserId = Users::register(
                    $userInfo->name,
                    $userInfo->email,
                    $password,
                    $phone,
                    $address
                );
        
                if (!$newUserId) {
                    throw new Exception("Không thể tạo user mới.");
                }
        
                echo "DEBUG: Tạo user thành công ✔️\n";
        
                // Lấy lại user sau khi tạo
                $user = Users::findByEmail($userInfo->email);
                if (!$user) {
                    throw new Exception("Không tìm thấy user sau khi tạo.");
                }
            } else {
                echo "DEBUG: User đã tồn tại ✔️\n";
            }
        
            // Lưu session
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            echo "DEBUG: Đã lưu session ✔️\n";
        
        } catch (Exception $e) {
            echo "DEBUG: Exception khi xử lý user ❌\n";
            echo "DEBUG: " . $e->getMessage() . "\n";
            error_log("Lỗi khi xử lý user: " . $e->getMessage());
            exit();
        }        

        // Bước 6: Chuyển hướng
        echo "DEBUG: Hoàn tất, chuyển hướng...\n";
        header("Location: /home?status=success&message=" . urlencode("Đăng nhập thành công"));
        exit;        
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
