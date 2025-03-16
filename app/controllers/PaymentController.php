<?php
require_once '../config/database.php';
require_once '../app/models/Orders.php';

class PaymentController{

    public function index(){
        $orders = Payments::all();
        require_once '../app/views/payment.php';
    }

    public function showPaymentForm() {
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }
        $orders = Payments::whereUserId($_SESSION["user"]["id"]);
        require_once '../app/views/payment/payment.php';
    }
}
?>