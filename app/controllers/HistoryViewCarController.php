<?php
require_once '../config/database.php';
require_once '../app/models/HistoryViewCar.php';

class HistoryViewCarController {
    public function getHistory() {
        
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }

        $user_id = $_SESSION["user"]["id"];
        $historys = HistoryViewCar::getHistoryByUser($user_id);

        require_once '../app/views/cars/historyviewcar.php';
    }

    public function deleteHistory($id) {
        if (HistoryViewCar::delete($id)) {
            header("Location: /admin?status=success&message=" . urlencode("Xoá lịch sử xem xe thành công!") . "&href=/admin");
            exit;
        } else {
            header("Location: /error?status=error&message=" . urlencode("Xoá lịch sử xem xe thất bại!") . "&href=/admin");
            exit;
        }
    }

    public function deleteAllHistory() {
        if (HistoryViewCar::deleteAll()) {
            header("Location: /admin?status=success&message=" . urlencode("Xoá tất cả lịch sử xem xe thành công!") . "&href=/admin");
            exit;
        } else {
            header("Location: /error?status=error&message=" . urlencode("Xoá tất cả lịch sử xem xe thất bại!") . "&href=/admin");
            exit;
        }
    }

    public function addHistory($data) {
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }
        $data["user_id"] = $_SESSION["user"]["id"];
        $data["ip_address"] = $_SERVER['REMOTE_ADDR'];
        $data["user_agent"] = $_SERVER['HTTP_USER_AGENT'];
        if (HistoryViewCar::create($data)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
