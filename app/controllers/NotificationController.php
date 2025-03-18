<?php
class NotificationController
{
    public function showMessage()
    {
        $status = isset($_GET['status']) ? $_GET['status'] : "error";
        require_once '../app/views/notifications/message.php';
    }
}
?>
