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
        $this->client = new Google_Client();
        $this->client->setClientId('121408504037-qi0iunnkb6oij7g0p10q5f0k4c5e05av.apps.googleusercontent.com');
        $this->client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $this->client->setRedirectUri('http://localhost:8000/auth/google/callback');
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

                header("Location: /success?status=success&message=" . urlencode("Đăng nhập thành công!") . "&href=/home");
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
        session_start();
        session_destroy();
        header("Location: /home");
        exit();
    }

    public function redirectToGoogle()
    {
        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth2_state'] = $state;

        $this->client->setState($state);
        $authUrl = $this->client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    }

    // public function handleGoogleCallback()
    // {
    //     // Bước 1: Kiểm tra mã code từ Google
    //     if (!isset($_GET['code'])) {
    //         header("Location: /error?status=error&message=" . urlencode("Không có mã code từ Google."));
    //         exit();
    //     }

    //     // Bước 2: Kiểm tra bảo mật state
    //     if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth2_state']) {
    //         header("Location: /error?status=error&message=" . urlencode("Lỗi bảo mật: state không hợp lệ."));
    //         exit();
    //     }

    //     unset($_SESSION['oauth2_state']); // Xóa state sau khi dùng

    //     // Bước 3: Lấy access token
    //     $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);

    //     if (isset($token['error'])) {
    //         header("Location: /error?status=error&message=" . urlencode("Lỗi khi lấy access token từ Google: " . $token['error']));
    //         exit();
    //     }

    //     $this->client->setAccessToken($token);

    //     try {
    //         // Bước 4: Lấy thông tin user từ Google
    //         $oauth = new \Google\Service\Oauth2($this->client);
    //         $userInfo = $oauth->userinfo->get();

    //         // Bước 5: Tìm hoặc đăng ký user
    //         $user = Users::findByEmail($userInfo->email);

    //         if (!$user) {
    //             $fakePassword = password_hash(bin2hex(random_bytes(8)), PASSWORD_BCRYPT);

    //             Users::register(
    //                 $userInfo->name,
    //                 $userInfo->email,
    //                 $fakePassword,
    //                 '0123456789',             // phone
    //                 null,             // address
    //                 'customer',     // role mặc định
    //                 null            // created_at
    //             );

    //             $user = Users::findByEmail($userInfo->email);
    //         }

    //         // Bước 6: Lưu session
    //         $_SESSION['user'] = $user;
    //         $_SESSION['user_id'] = $user['id'];

    //         // Bước 7: Redirect
    //         header("Location: /success?status=success&message=" . urlencode("Đăng nhập Google thành công!") . "&href=/home");
    //         exit();
    //     } catch (Exception $e) {
    //         header("Location: /error?status=error&message=" . urlencode("Lỗi khi lấy thông tin người dùng từ Google: " . $e->getMessage()));
    //         exit();
    //     }
    // }

    public function handleGoogleCallback()
    {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Bước 1: Kiểm tra mã code từ Google
        if (!isset($_GET['code'])) {
            error_log("Không có mã code từ Google.");
            exit("Không có mã code");
        }

        // Bước 2: Kiểm tra state
        if (!isset($_GET['state']) || !isset($_SESSION['oauth2_state']) || $_GET['state'] !== $_SESSION['oauth2_state']) {
            error_log("Lỗi bảo mật: state không hợp lệ.");
            exit("State không hợp lệ");
        }

        unset($_SESSION['oauth2_state']);
        error_log("State hợp lệ.");

        // Bước 3: Lấy access token
        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['error']) || !isset($token['access_token'])) {
                error_log("Lỗi token: " . json_encode($token));
                exit("Lỗi khi lấy access token");
            }
            $this->client->setAccessToken($token);
            error_log("Token nhận được: " . json_encode($token));
        } catch (Exception $e) {
            error_log("Lỗi khi lấy access token: " . $e->getMessage());
            exit("Lỗi khi lấy access token");
        }

        // Bước 4: Lấy thông tin user từ Google
        try {
            $oauth = new \Google\Service\Oauth2($this->client);
            $userInfo = $oauth->userinfo->get();
            error_log("Thông tin user: " . json_encode([
                'id' => $userInfo->id,
                'name' => $userInfo->name,
                'email' => $userInfo->email,
                'picture' => $userInfo->picture
            ]));
        } catch (Exception $e) {
            error_log("Lỗi khi lấy thông tin user: " . $e->getMessage());
            exit("Lỗi khi lấy thông tin user");
        }

        // Bước 5: Kiểm tra và tạo tài khoản
        try {
            $user = Users::findByEmail($userInfo->email);
            if (!$user) {
                error_log("User chưa có, đang tạo mới...");
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
                error_log("Tạo user thành công");
            } else {
                error_log("User đã tồn tại");
            }

            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            error_log("Đã lưu session: " . json_encode($_SESSION));
        } catch (Exception $e) {
            error_log("Lỗi khi xử lý user: " . $e->getMessage());
            exit("Lỗi khi xử lý thông tin user trong cơ sở dữ liệu");
        }

        // Bước 6: Chuyển hướng
        error_log("Hoàn tất đăng nhập. Chuyển hướng...");
        header("Location: /success?status=success&message=" . urlencode("Đăng nhập Google thành công!") . "&href=/home");
        exit();
    }
}
