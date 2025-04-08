<?php
require_once '../config/database.php';
require_once '../app/models/Used_cars.php';

class UsedCarsController
{
    public function showUsedCars()
    {
        $used_cars = Used_cars::all();
        require_once '../app/views/list_used_cars/index.php';
    }

    public function showUsedCar($id)
    {
        $used_car = Used_cars::find($id);
        if (!$used_car) {
            header("Location: /home?status=error&message=" . urlencode("Bài đăng không tồn tại!"));
            exit();
        }
        require_once '../app/views/used_cars/show.php';
    }
}