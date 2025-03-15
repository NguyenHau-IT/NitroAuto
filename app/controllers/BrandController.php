<?php
require_once '../app/models/Brands.php';

class UserController
{
    public function index()
    {
        $brands = Brands::all();
        require_once '../app/views/index.php';
    }
}
