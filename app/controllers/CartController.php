<?php
require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Accessories.php";

class CartController
{
    public function index()
    {
        $cars = Cart::all();
        require_once __DIR__ . "/../views/cars/list.php";
    }

    public function getByUserId()
    {
        $userId = $_SESSION['user']['id'];

        $carts = Cart::find($userId);
        require_once __DIR__ . "/../views/cart/cart_user.php";
    }

    public function addToCart($accessoryId)
    {
        if (!isset($_SESSION['user']['id'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $quantity = 1;

        global $conn;

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id AND accessory_id = :accessory_id");
        $stmt->execute([
            ':user_id' => $userId,
            ':accessory_id' => $accessoryId
        ]);
        $existing = $stmt->fetch();

        $success = false;

        if ($existing) {
            // Nếu đã tồn tại -> cập nhật số lượng
            $success = Cart::update($userId, $accessoryId, $existing['quantity'] + $quantity);
        } else {
            // Nếu chưa có -> thêm mới
            $success = Cart::add($userId, $accessoryId, $quantity);
        }

        if ($success) {
            header("Location: /success?status=success&message=" . urlencode("Thêm vào giỏ hàng thành công!") . "&href=cart");
        } else {
            header("Location: /error?status=error&message=" . urlencode("Thêm vào giỏ hàng thất bại!") . "&href=accessories_list");
        }

        exit();
    }

    public function deleteAll()
    {
        $userId = $_SESSION['user']['id'];
        if (Cart::deleteAll($userId)) {
            header("Location: /success?status=success&message=" . urlencode("Xoá tất cả sản phẩm trong giỏ hàng thành công!") . "&href=cart");
        } else {
            header("Location: /error?status=error&message=" . urlencode("Xoá tất cả sản phẩm trong giỏ hàng thất bại!") . "&href=cart");
        }
        exit();
    }

    public function deleteCart($id)
    {
        $userId = $_SESSION['user']['id'];
        if (Cart::delete($userId, $id)) {
            header("Location: /success?status=success&message=" . urlencode("Xoá sản phẩm trong giỏ hàng thành công!") . "&href=cart");
        } else {
            header("Location: /error?status=error&message=" . urlencode("Xoá sản phẩm trong giỏ hàng thất bại!") . "&href=cart");
        }
        exit();
    }

    public function updateCart()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['quantity'])) {
            $cartId = (int)$_POST['id'];
            $quantity = max(1, (int)$_POST['quantity']);
            $userId = $_SESSION['user']['id'];

            global $conn;
            $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id AND user_id = :user_id");
            $success = $stmt->execute([
                ':quantity' => $quantity,
                ':id' => $cartId,
                ':user_id' => $userId
            ]);

            if ($success) {
                echo json_encode(['status' => 'success']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error']);
            }
            exit;
        }

        http_response_code(400);
        echo json_encode(['status' => 'invalid request']);
        exit;
    }
}
