<?php
require_once '../config/database.php';
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
}