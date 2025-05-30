<?php

use FontLib\Table\Type\head;

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

        global $conn;
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

    public function create_promotion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $code = $_POST['code'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
            $discount_percent = $_POST['discount_percent'] ?? '';
            $discount_amount = $_POST['discount_amount'] ?? '';
            $is_active = $_POST['is_active'] ?? '';

            //kiểm tra dứ liệu đầu vào
            if (empty($name) || empty($code) || empty($start_date) || empty($end_date)) {
                header('Location: /admin#promotions?status=error');
                exit;
            }
            $data = [
                'name' => $name,
                'code' => $code,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'discount_percent' => $discount_percent,
                'discount_amount' => $discount_amount,
                'is_active' => $is_active
            ];

            if (Promotions::create($data)) {
                header('Location: /admin#promotions');
                exit;
            } else {
                header('Location: /admin#promotions?status=error');
                exit;
            }
        }

        require_once '../app/views/promotions/create_promotion.php';
    }


    public function edit_promotion($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $code = $_POST['code'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
            $discount_percent = $_POST['discount_percent'] ?? '';
            $discount_amount = $_POST['discount_amount'] ?? '';
            $is_active = $_POST['is_active'] ?? '';

            //kiểm tra dứ liệu đầu vào
            if(empty($name) || empty($code) || empty($start_date) || empty($end_date))
            {
                header('Location: /admin#promotions?status=error');
                exit;
            }
            $data = [
                'name' => $name,
                'code' => $code,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'discount_percent' => $discount_percent,
                'discount_amount' => $discount_amount,
                'is_active' => $is_active
            ];

            if (Promotions::update($id, $data)) {
                header('Location: /admin#promotions');
                exit;
            } else {
                header('Location: /admin#promotions?status=error');
                exit;
            }
        }

        $promotion = Promotions::find($id);
        require_once '../app/views/promotions/edit_promotion.php';
    }

    public function delete_promotion($id)
    {
        if (Promotions::delete($id)) {
            header('Location: /admin#promotions');
            exit;
        } else {
            header('Location: /admin#promotions?status=error');
            exit;
        }
    }

    public function updateStatus()
    {
        $promo_id = $_POST['promo_id'] ?? null;
        $isActive = $_POST['is_active'] ?? null;

        // Kiểm tra giá trị đầu vào
        if ($promo_id !== null && $isActive !== null) {
            // Ép kiểu an toàn
            $promo_id = (int)$promo_id;
            $isActive = (int)$isActive;

            // Gọi model để update
            $result = Promotions::updateStatus($promo_id, $isActive);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
