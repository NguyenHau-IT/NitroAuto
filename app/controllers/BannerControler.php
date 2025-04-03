<?php

class BannerController
{
    public function index()
    {
        $banners = Banner::getAllBanners();
        require_once '../app/views/banners/banner_list.php';
    }
}