<?php
require_once '../app/models/ServiceOrder.php';
require_once '../app/models/CarServices.php';

class ServiceOrderController
{
    public function index()
    {
        $serviceOrders = ServiceOrder::all();
        require_once '../app/views/service_orders/service_order_list.php';
    }

    public function addForm()
    {
        $services = CarServices::all();
        require_once '../app/views/services/add_service_order.php';
    }

    public function addServiceOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceId = $_POST['service_id'];
            $userId = $_POST['user_id'];
            $status = 'Pending';
            $note = $_POST['note'];
            $date = $_POST['service_date'];

            ServiceOrder::create($serviceId, $userId, $date, $status, $note);

            header("Location: /services?status=success&message=" . urlencode("Đặt lịch thành công!"));
            exit();
        }

        require_once '../app/views/services/add_service_order.php';
    }

    public function getByUserId()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];
    
        $orders = ServiceOrder::getByUser($userId);
        require_once '../app/views/services/services_user.php';
    }
}