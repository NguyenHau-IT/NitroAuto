<?php

class PromotionsController
{
    public function apply_promotions()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents("php://input"), true);
        $code = trim($input['code'] ?? '');
        $total = floatval($input['total'] ?? 0);

        $response = ['success' => false, 'message' => '', 'discount' => 0];

        if ($code === '' || $total <= 0) {
            $response['message'] = 'Mã hoặc tổng tiền không hợp lệ';
            echo json_encode($response);
            return;
        }

        global $conn; // sử dụng kết nối PDO từ db.php

        $stmt = $conn->prepare("
                SELECT * FROM promotions 
                WHERE code = ? AND is_active = 1 
                    AND start_date <= GETDATE() 
                    AND end_date >= GETDATE()
            ");
        $stmt->execute([$code]);
        $promo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$promo) {
            $response['message'] = 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn';
        } else {
            $discount = 0;
            if ($promo['discount_percent'] > 0) {
                $discount = $total * ($promo['discount_percent'] / 100);
            } elseif ($promo['discount_amount'] > 0) {
                $discount = $promo['discount_amount'];
            }

            $response['success'] = true;
            $response['discount'] = min($discount, $total);
        }

        echo json_encode($response);
    }
}
