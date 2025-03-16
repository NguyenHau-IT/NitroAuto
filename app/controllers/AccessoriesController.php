<?php
require_once '../config/database.php';
require_once '../app/models/Accessories.php';



class AccessoriesController
{
    public function index() {
        $accessories = Accessories::all();
        require_once '../app/views/accessories/accessories_list.php';
    }
}