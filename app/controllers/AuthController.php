<?php
require_once '../app/models/Users.php';

class AuthController
{
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
                echo "Đăng ký thất bại!";
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

                header("Location: home");
                exit();
            } else {
                echo "Sai thông tin đăng nhập!";
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
}
