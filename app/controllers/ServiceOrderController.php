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

    public function ServicesOrderForm()
    {
        $services = CarServices::all();
        require_once '../app/views/services/add_service_order.php';
    }

    public function ServicesOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $serviceId = $_POST['service_id'];
            $userId = $_POST['user_id'];
            $status = 'Pending';
            $note = $_POST['note'];
            $date = $_POST['service_date'];

            if (!$serviceId || !$userId || !$date) {
                header("Location: /services?status=error&message=" . urlencode("Lỗi khi đặt lịch!"));
                exit();
            }

            if (ServiceOrder::create($serviceId, $userId, $date, $status, $note)) {
                header("Location: /services?status=success&message=" . urlencode("Đặt lịch thành công!"));
                exit();
            } else {
                header("Location: /services?status=error&message=" . urlencode("Lỗi khi đặt lịch!"));
                exit();
            }
        }
    }

    public function getByUserId()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập để xem lịch sử đặt dịch vụ!"));
            exit();
        }

        $userId = $_SESSION['user']['id'];

        $orders = ServiceOrder::getByUser($userId);
        require_once '../app/views/services/services_user.php';
    }

    public function updateStatus($orderID)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $orderID = $_POST['ServiceOrderID'];
            $status = $_POST['status'];
            if (ServiceOrder::updateStatus($orderID, $status)) {
                header("Location: /admin");
                exit();
            } else {
                header("Location: /admin#service_orders?status=error&message=" . urlencode("Cập nhật trạng thái thất bại!"));
                exit();
            }
        }

        $serviceOrder = ServiceOrder::find($orderID);
        require_once '../app/views/services/edit_service_order.php';
    }

    public function delete($orderID)
    {
        if (ServiceOrder::delete($orderID)) {
            header("Location: /admin");
            exit();
        }
        else
        {
            header("Location: /admin#service_orders?status=error&message=" . urlencode("Xoá thất bại!"));
            exit();
        }
    }

    public function updateServiceStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $orderID = $_POST['service_order_id'];
            $status = $_POST['status'];
            if (ServiceOrder::updateServiceStatus($orderID, $status)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }
}