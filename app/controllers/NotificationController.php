<?php
class NotificationController
{
    public function showMessage()
    {
        // Không cần xử lý gì phức tạp nữa, chỉ render view
        require_once '../app/views/notifications/message.php';
    }    
}
?>
