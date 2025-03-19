<?php
require_once '../app/models/Brands.php';

class UserController
{
    public function index()
    {
        $brands = Brands::all();
        require_once '../app/views/index.php';
    }

    public function formadd()
    {
        require_once '../app/views/brands/add_brand.php';
    }

    public function addbrand()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $logo = $_POST['logo'];

            $brands = Brands::create($name, $country, $logo);
            if ($brands) {
                header("Location: /success?status=success&message=" . urlencode("Đã thêm vào danh sách thành công!"));
                exit();
            } else {
                header("Location: /error?status=error&message=" . urlencode("Bạn đã thêm vào danh sách thất bại!"));
                exit();
                require_once '../app/views/brands/add.php';
            }
        }
    }
}
