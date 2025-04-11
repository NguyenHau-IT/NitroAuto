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

    public function countCart()
    {
        if (isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
            $cartCount = Cart::getCartCount($userId);
            echo json_encode(['count' => $cartCount]);
        } else {
            echo json_encode(['count' => 0]);
        }
        exit();
    }

    public function getByUserId()
    {
        $userId = $_SESSION['user']['id'];
        if (!$userId) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập để xem giỏ hàng!"));
            exit();
        }

        $carts = Cart::find($userId);
        require_once __DIR__ . "/../views/cart/cart_user.php";
    }

    public function addToCart($accessoryId)
    {
        if (!isset($_SESSION['user']['id'])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập để thêm vào giỏ hàng!"));
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $quantity = 1;

        global $conn;

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
            header("Location: /accessories?status=success&message=" . urlencode("Thêm vào giỏ hàng thành công!"));
        } else {
            header("Location: /accessories?status=error&message=" . urlencode("Thêm vào giỏ hàng thất bại!"));
        }

        exit();
    }

    public function deleteAll()
    {
        $userId = $_SESSION['user']['id'];
        if (Cart::deleteAll($userId)) {
            header("Location: /cart?status=success&message=" . urlencode("Xoá tất cả sản phẩm trong giỏ hàng thành công!"));
        } else {
            header("Location: /cart?status=error&message=" . urlencode("Xoá tất cả sản phẩm trong giỏ hàng thất bại!"));
        }
        exit();
    }

    public function deleteCart($id)
    {
        $userId = $_SESSION['user']['id'];
        if (Cart::delete($userId, $id)) {
            header("Location: /cart?status=success&message=" . urlencode("Xoá sản phẩm trong giỏ hàng thành công!"));
        } else {
            header("Location: /cart?status=error&message=" . urlencode("Xoá sản phẩm trong giỏ hàng thất bại!"));
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

    public function checkOutProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'] ?? null;

            if (!$user_id) {
                header("Location: /cart?status=error&message=" . urlencode("Vui lòng đăng nhập để mua hàng!"));
                exit();
            }

            $carts = Cart::find($user_id); // Lấy giỏ hàng
            if (empty($carts)) {
                header("Location: /cart?status=error&message=" . urlencode("Giỏ hàng trống!"));
                exit();
            }

            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';

            if (empty($address) || empty($phone)) {
                header("Location: /checkout?status=error&message=" . urlencode("Vui lòng nhập đầy đủ thông tin!"));
                exit();
            }

            // Tính tổng phụ kiện
            $total_price = 0;
            foreach ($carts as $item) {
                $total_price += $item['accessory_price'] * $item['quantity'];
            }

            // Tạo đơn hàng
            $order_id = Orders::createMainOrder($user_id, $address, $phone, $total_price);
            if (!$order_id) {
                header("Location: /checkout?status=error&message=" . urlencode("Không thể tạo đơn hàng!"));
                exit();
            }

            // Lưu từng phụ kiện vào bảng order_details
            foreach ($carts as $item) {
                $accessory_id = $item['accessory_id'];
                $quantity = $item['quantity'];
                $price = $item['accessory_price'];

                Orders::addOrderItem(
                    $order_id,
                    $accessory_id,
                    $quantity,
                    $price
                );
            }

            // Xoá giỏ hàng
            Cart::deleteAll($user_id);

            header("Location: /home?status=success&message=" . urlencode("Đặt hàng thành công!"));
            exit();
        }
    }

    public function checkOutSelected()
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header("Location: /cart?status=error&message=" . urlencode("Vui lòng đăng nhập để đặt hàng!"));
            exit();
        }

        $selectedIds = $_POST['selected_items'] ?? [];

        if (empty($selectedIds)) {
            header("Location: /cart?status=error&message=" . urlencode("Vui lòng chọn ít nhất một sản phẩm để đặt hàng!"));
            exit();
        }

        $allCart = Cart::find($userId);
        $selectedItems = array_filter($allCart, function ($item) use ($selectedIds) {
            return in_array($item['id'], $selectedIds);
        });

        // Gửi sang view để xác nhận đơn hàng
        require_once '../app/views/orders/order_selected.php';
    }

    public function updateQuantity()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $quantity = $input['quantity'] ?? null;
        $user_id = $_SESSION['user']['id'] ?? null;

        if (!$id || !$quantity || !$user_id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
            return;
        }

        // Gọi đến model để cập nhật
        $result = Cart::updateQuantity($user_id, $id, $quantity);

        echo json_encode(['success' => $result]);
    }
}
