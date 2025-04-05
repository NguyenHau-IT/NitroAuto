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
require_once '../app/controllers/HistoryViewCarController.php';
require_once '../app/controllers/CartController.php';
require_once '../app/controllers/BannerController.php';
require_once '../app/controllers/CarServicesController.php';
require_once '../app/controllers/ServiceOrderController.php';


$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

switch (true) {
    case ($uri === '' || $uri === 'home'):
        (new HomeController())->index();
        break;

    case ($uri === 'add_car'):
        (new CarController())->showAddForm();
        break;

    case ($uri === 'add'):
        (new CarController())->storeCar();
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

    case ($uri === 'place_order'):
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

    case ($uri === 'accessories'):
        (new AccessoriesController())->index();
        break;

    case ($uri === 'testdriveform'):
        (new TestDriveController())->Test_Drive();
        break;

    case ($uri === 'register_test_drive'):
        (new TestDriveController())->create();
        break;

    case ($uri === 'filter-cars'):
        (new CarController())->filterCar();
        break;

    case ($uri === 'reset-filters'):
        (new CarController())->resetFilters();
        break;

    case ($uri === 'edit_profile'):
        (new UserController())->editProfile();
        break;

    case ($uri === 'update_profile'):
        (new UserController())->updateProfile();
        break;

    case ($uri === 'cart'):
        (new CartController())->getByUserId();
        break;

    case ($uri === 'delete_all'):
        (new CartController())->deleteAll();
        break;

    case $uri === 'update_cart':
        (new CartController())->updateCart();
        break;

    case $uri === 'toggle_banner_status':
        (new BannerController())->toggleBannerStatus();
        break;

    case $uri === 'auth/google':
        (new AuthController())->redirectToGoogle();
        break;

    case $uri === 'auth/google/callback':
        (new AuthController())->handleGoogleCallback();
        break;

    case $uri === 'services':
        (new CarServicesController())->index();
        break;

    case $uri === 'order_service_form':
        (new ServiceOrderController())->addForm();
        break;

    case $uri === 'service_order_add':
        (new ServiceOrderController())->addServiceOrder();
        break;

    case $uri === 'appointments':
        (new ServiceOrderController())->getByUserId();
        break;

    case $uri ==='check_out':
        (new CartController())->checkOut();
        break;

    case $uri ==='check_out_process':
        (new CartController())->checkOutProcess();
        break;

    case preg_match('/^car_detail\/(\d+)$/', $uri, $matches):
        (new CarController())->showCarDetail($matches[1]);
        break;

    case preg_match('/^edit_car\/(\d+)$/', $uri, $matches):
        (new CarController())->edit($matches[1]);
        break;

    case preg_match('/^update_car\/(\d+)$/', $uri, $matches):
        (new CarController())->update();
        break;

    case preg_match('/^delete_car\/(\d+)$/', $uri, $matches):
        (new CarController())->delete($matches[1]);
        break;

    case (preg_match('/^car_find\/(\d+)$/', $uri, $matches)):
        (new CarController())->search($matches[1]);
        break;

    case (preg_match('/^order_detail\/(\d+)$/', $uri, $matches)):
        (new OrderController())->orderDetail($matches[1]);
        break;

    case (preg_match('/^order_edit\/(\d+)$/', $uri, $matches)):
        (new OrderController())->order_edit($matches[1]);
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

    case preg_match('/^clear_history\/(\d+)$/', $uri, $matches):
        (new HistoryViewCarController())->deleteHistoryByUser($matches[1]);
        break;

    case preg_match('/^remove_history\/(\d+)$/', $uri, $matches):
        (new HistoryViewCarController())->deleteHistory($matches[1]);
        break;

    case preg_match('/^add_to_cart\/(\d+)$/', $uri, $matches):
        (new CartController())->addToCart($matches[1]);
        break;

    case preg_match('/^delete_cart\/(\d+)$/', $uri, $matches):
        (new CartController())->deleteCart($matches[1]);
        break;

    case preg_match('/^delete_accessory\/(\d+)$/', $uri, $matches):
        (new AccessoriesController())->deleteAccessory($matches[1]);
        break;

    case ($uri === 'error'):
        (new NotificationController())->showMessage();
        break;

    case ($uri === 'success'):
        (new NotificationController())->showMessage();
        break;

    default:
        http_response_code(404);
        echo "404 - Không tìm thấy trang";
}
