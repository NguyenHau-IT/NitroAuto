<?php
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/FavoriteController.php';
require_once '../app/controllers/OrderController.php';
require_once '../app/controllers/CarController.php';
require_once '../app/controllers/AccessoriesController.php';
require_once '../app/controllers/NotificationController.php';
require_once '../app/controllers/TestDriveController.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');

switch (true) {
    case ($uri === '' || $uri === 'home'):
        (new HomeController())->index();
        break;

    case preg_match('/^car_detail\/(\d+)$/', $uri, $matches):
        (new CarController())->showCarDetail($matches[1]);
        break;

    case ($uri === 'user'):
        (new UserController())->customer();
        break;

    case ($uri === 'admin'):
        (new AdminController())->index();
        break;

    case ($uri === 'login'):
        (new AuthController())->login();
        break;

    case ($uri === 'register'):
        (new AuthController())->register();
        break;

    case ($uri === 'logout'):
        (new AuthController())->logout();
        break;

    case ($uri === 'add_favorite'):
        (new FavoriteController())->addFavorite();
        break;

    case ($uri === 'placeOrder'):
        (new OrderController())->placeOrder();
        break;

    case ($uri === 'showOrderForm'):
        (new OrderController())->showOrderForm();
        break;

    case ($uri === 'user_orders'):
        (new OrderController())->getUserOrders();
        break;

    case ($uri === 'profile'):
        (new UserController())->userById();
        break;

    case ($uri === 'favorites'):
        (new FavoriteController())->favoriteById();
        break;

    case preg_match('/^edit_car\/(\d+)$/', $uri, $matches):
        (new CarController())->edit($matches[1]);
        break;

    case preg_match('/^update_car\/(\d+)$/', $uri, $matches):
        (new CarController())->update();
        break;

    case ($uri === 'add_car'):
        (new CarController())->showAddForm();
        break;

    case ($uri === 'add'):
        (new CarController())->storeCar();
        break;

    case preg_match('/^delete_car\/(\d+)$/', $uri, $matches):
        (new CarController())->delete($matches[1]);
        break;

    case ($uri === 'accessories'):
        (new AccessoriesController())->index();
        break;

    case (preg_match('/^car_find\/(\d+)$/', $uri, $matches)):
        $brandId = $matches[1];
        (new CarController())->search($brandId);
        break;

    case (preg_match('/^order_detail\/(\d+)$/', $uri, $matches)):
        $orderId = $matches[1];
        (new OrderController())->orderDetail($orderId);
        break;

    case (preg_match('/^order_edit\/(\d+)$/', $uri, $matches)):
        $orderId = $matches[1];
        (new OrderController())->order_edit($orderId);
        break;

    case preg_match('/^orderupdate\/(\d+)$/', $uri, $matches):
        (new OrderController())->updateOrder();
        break;

    case preg_match('/^order_delete\/(\d+)$/', $uri, $matches):
        (new OrderController())->deleteOrder($matches[1]);
        break;

    case preg_match('/^favarite_delete\/(\d+)$/', $uri, $matches):
        (new FavoriteController())->deleteFavorite($matches[1]);
        break;


    case ($uri === 'testdriveform'):
        (new TestDriveController())->Test_Drive();
        break;

    case ($uri === 'register_test_drive'):
        (new TestDriveController())->create();
        break;
        
    case 'error':
        (new NotificationController())->showMessage();
        break;

    case 'success':
        (new NotificationController())->showMessage();
        break;

    default:
        http_response_code(404);
        echo "404 - Không tìm thấy trang";
}
