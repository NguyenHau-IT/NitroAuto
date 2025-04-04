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
                header("Location: /login");
                exit();
            } else {
                header("Location: /error?status=error&message=" . urlencode("Đăng kí thất bại vui lòng đăng kí lại!"));
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

                header("Location: /success?status=success&message=" . urlencode("Đăng nhập thành công!"));
                exit();
            } else {
                header("Location: /error?status=error&message=" . urlencode("Đăng nhập thất bại vui lòng đăng nhập lại!"));
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
                $fakePassword = password_hash(bin2hex(random_bytes(8)), PASSWORD_BCRYPT);
                Users::register(
                    $userInfo->name,
                    $userInfo->email,
                    $fakePassword,
                    '0123456789',
                    null,
                    'customer',
                    null
                );
                $user = Users::findByEmail($userInfo->email);
                echo "DEBUG: Tạo user thành công ✔️\n";
            } else {
                echo "DEBUG: User đã tồn tại ✔️\n";
            }

            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            echo "DEBUG: Đã lưu session ✔️\n";
        } catch (Exception $e) {
            error_log("Lỗi khi xử lý user: " . $e->getMessage());
            echo "DEBUG: Exception khi xử lý user ❌\n";
            exit();
        }

        // Bước 6: Chuyển hướng
        echo "DEBUG: Hoàn tất, chuyển hướng...\n";
        header("Location: /success?status=success&message=" . urlencode("Đăng nhập Google thành công!") . "&href=/home");
        exit();
    }
}
