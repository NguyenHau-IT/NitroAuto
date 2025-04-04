<?php
require_once '../config/database.php'; // Kết nối cơ sở dữ liệu

class ServiceOrder
{
    public $ServiceOrderID;
    public $UserID;
    public $ServiceID;
    public $OrderDate;
    public $Note;
    public $Status;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Lấy tất cả đơn đặt dịch vụ
    public static function all()
    {
        global $conn;
        $stmt = $conn->query("SELECT * FROM ServiceOrders ORDER BY OrderDate DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm đơn đặt dịch vụ
    public static function create($serviceId, $userId, $status = 'Pending', $note = null)
{
    global $conn;

    $query = "INSERT INTO ServiceOrders (UserID, ServiceID, Note, Status)
              VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    return $stmt->execute([
        $userId,
        $serviceId,
        $note,
        $status ?: 'Pending' // nếu status rỗng, fallback là 'Pending'
    ]);
}

    // Lấy tất cả đơn đặt dịch vụ của 1 người dùng
    public static function getByUser($userID)
    {
        global $conn;
        $query = "SELECT 
                    so.ServiceOrderID AS order_id,
                    so.OrderDate AS order_date,
                    so.Note AS note,
                    so.Status AS status,
                    cs.ServiceName AS car_name,
                    cs.Price AS total_price
                  FROM ServiceOrders so
                  JOIN CarServices cs ON so.ServiceID = cs.ServiceID
                  WHERE so.UserID = ?
                  ORDER BY so.OrderDate DESC";
    
        $stmt = $conn->prepare($query);
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Lấy toàn bộ đơn đặt dịch vụ (cho admin)
    public function getAll()
    {
        global $conn;
        $query = "SELECT so.*, u.full_name, cs.ServiceName
                  FROM ServiceOrders so
                  JOIN Users u ON so.UserID = u.ID
                  JOIN CarServices cs ON so.ServiceID = cs.ServiceID
                  ORDER BY so.OrderDate DESC";

        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn
    public function updateStatus($orderID, $status)
    {
        global $conn;
        $query = "UPDATE ServiceOrders SET Status = ? WHERE ServiceOrderID = ?";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$status, $orderID]);
    }

    // Xoá đơn
    public function delete($orderID)
    {
        global $conn;
        $query = "DELETE FROM ServiceOrders WHERE ServiceOrderID = ?";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$orderID]);
    }
}
