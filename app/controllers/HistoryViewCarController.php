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
        $histories = HistoryViewCar::getHistoryByUser($user_id);

        require_once '../app/views/cars/historyviewcar.php';
    }

    public function deleteHistory($id) {
        if ($histories = HistoryViewCar::delete($id)) {
            header("Location: /home");
            exit;
        } else {
            header("Location: /home");
            exit;
        }
    }

    public function deleteAllHistory() {
        if ($histories = HistoryViewCar::deleteAll()) {
            header("Location: /home");
            exit;
        } else {
            header("Location: /home");
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

    // Xoá lịch sử xem xe theo user_id
    public function deleteHistoryByUser($user_id) 
    {
        if ($histories = HistoryViewCar::deleteAllByUser($user_id)) {
            header("Location: /home");
            exit;
        } else {
            header("Location: /home");
            exit;
        }
    }
}
?>
