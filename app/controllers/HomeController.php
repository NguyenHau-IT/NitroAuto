<?php
require_once '../config/database.php';
require_once '../app/models/Brands.php';
require_once '../app/models/Cars.php';
require_once '../app/models/HistoryViewCar.php';
require_once '../app/models/Banner.php';
require_once '../app/models/Used_cars.php';

class HomeController
{
    public function index()
    {
        $user_id = $_SESSION['user_id'] ?? null;

        $cars = Cars::all();
        $brands = Brands::getByStock();
        $categories = Categories::getByCar();
        $banners = Banner::getAllBanners();
        $histories = HistoryViewCar::getHistoryByUser($user_id);
        $banner_left = Banner::banner_left();
        $banner_right = Banner::banner_right();
        $used_cars = Used_cars::getall();

        require_once '../app/views/index.php';
    }
}
