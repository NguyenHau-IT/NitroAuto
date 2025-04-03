<?php
require_once '../app/models/Accessories.php';



class AccessoriesController
{
    public function index() {
        $accessories = Accessories::all();
        require_once '../app/views/accessories/accessories_list.php';
    }

    public function getByCarId($carId) {
        $accessories = Accessories::getByCarId($carId);
        require_once '../app/views/accessories/accessories_car.php';
    }

    public function deleteAccessory($id) {
        $accessories = Accessories::delete($id);
        if (!$accessories) {
            header("Location: /error?status=error&message=" . urlencode("Xoá phụ kiện thất bại!") ."&href=/admin");
            exit;
        }
        else {
            header("Location: /admin?status=success&message=" . urlencode("Xoá phụ kiện thành công!") . "&href=/admin");
            exit;
        }
    }
}