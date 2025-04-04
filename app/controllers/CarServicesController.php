<?php
require_once '../app/models/CarServices.php';

class CarServicesController
{
    public function index()
    {
        $services = CarServices::all();
        require_once '../app/views/services/service_list.php';
    }
}