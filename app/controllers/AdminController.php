<?php
require_once '../config/database.php';


class AdminController
{
    public function index() {
        require_once '../app/views/admin/dashboard.php';
    }
}