<?php
require_once '../app/models/CarServices.php';

class CarServicesController
{
    public function index()
    {
        $services = CarServices::all();
        require_once '../app/views/services/service_list.php';
    }

    public function addServiceForm()
    {
        require_once '../app/views/services/add_service.php';
    }

    public function addService()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $ServiceName = $_POST['service_name'];
            $Description = $_POST['description'];
            $Price = $_POST['price'];
            $EstimatedTime = $_POST['estimated_time'];
            $Status = $_POST['status'];
            if (!$ServiceName || !$Description || !$Price || !$EstimatedTime || !$Status) {
                header("Location: /services?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!"));
                exit();
            }
            if (CarServices::create($ServiceName, $Description, $Price, $EstimatedTime, $Status)) {
                header("Location: /admin#car_services?status=success&message=" . urlencode("Thêm dịch vụ thành công!"));
                exit();
            } else {
                header("Location: /admin#car_services?status=error&message=" . urlencode("Thêm dịch vụ thất bại!"));
                exit();
            }
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $ServiceID = $_POST['service_id'];
            $ServiceName = $_POST['service_name'];
            $Description = $_POST['description'];
            $Price = $_POST['price'];
            $EstimatedTime = $_POST['estimated_time'];
            $Status = $_POST['status'];
            if (!$ServiceName || !$Description || !$Price || !$EstimatedTime || !$Status) {
                header("Location: /admin#car_services?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!"));
                exit();
            }
            if(CarServices::update($ServiceID, $ServiceName, $Description, $Price, $EstimatedTime, $Status))
            {
                header("Location: /admin#car_services?status=success&message=" . urlencode("Cập nhật dịch vụ thành công!"));
                exit();
            }
            else
            {
                header("Location: /admin#car_services?status=error&message=" . urlencode("Cập nhật dịch vụ thất bại!"));
                exit();
            }
        }
        $service = CarServices::find($id);
        require_once '../app/views/services/edit_service.php';
    }

    public function delete($id)
    {
        if (CarServices::delete($id)) {
            header("Location: /admin");
            exit();
        } else {
            header("Location: /admin#car_services?status=error&message=" . urlencode("Thêm dịch vụ thất bại!"));
            exit();
        }
    }
}
