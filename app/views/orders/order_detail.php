<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-dark fs-5 mb-4 bg-light shadow rounded-4 p-4">
        <h2 class="text-center text-dark">Chi tiết đơn hàng #<?= $order['order_id'] ?></h2>
        <div class="row mt-5">
            <div class="col-md-6">
                <h4>Thông tin khách hàng</h4>
                <table class="table table-bordered table-hover table-striped table-dark">
                    <tbody>
                        <tr>
                            <th scope="row">Họ tên</th>
                            <td><?= htmlspecialchars($order['user_name']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><?= htmlspecialchars($order['email']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Điện thoại ng nhận</th>
                            <td><?= htmlspecialchars($order['phone']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Địa chỉ nhận xe</th>
                            <td><?= htmlspecialchars($order['address']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h4>Thông tin đơn hàng</h4>
                <table class="table table-bordered table-hover table-striped table-dark">
                    <tbody>
                        <tr>
                            <th scope="row">Tên xe</th>
                            <td><?= !empty($order['car_name']) ? htmlspecialchars($order['car_name']) : '-' ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Số lượng</th>
                            <td><?= isset($order['quantity']) ? htmlspecialchars($order['quantity']) : '-' ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Giá Xe</th>
                            <td><?= isset($order['subtotal']) ? number_format($order['subtotal'], 0, ',', '.') . ' VNĐ' : '-' ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Phụ kiện</th>
                            <td><?= !empty($order['accessory_name']) ? htmlspecialchars($order['accessory_name']) : '-' ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Số lượng phụ kiện</th>
                            <td><?= isset($order['accessory_quantity']) ? htmlspecialchars($order['accessory_quantity']) : '-' ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Giá phụ kiện</th>
                            <td><?= isset($order['accessory_price']) ? number_format($order['accessory_price'], 0, ',', '.') . ' VNĐ' : '-' ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tổng giá</th>
                            <td><?= isset($order['total_amount']) ? number_format($order['total_amount'], 0, ',', '.') . ' VNĐ' : '-' ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Ngày đặt</th>
                            <td>
                                <?= !empty($order['order_date']) ? date('d/m/Y - H:i:s', strtotime($order['order_date'])) : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Trạng thái</th>
                            <td>
                                <?php
                                if (empty($order['status'])) {
                                    echo '-';
                                } else {
                                    switch ($order['status']) {
                                        case 'pending':
                                        case 'Pending':
                                            echo 'Đang chờ xử lý';
                                            break;
                                        case 'confirmed':
                                        case 'Confirmed':
                                            echo 'Đã xác nhận';
                                            break;
                                        case 'shipped':
                                        case 'Shipped':
                                            echo 'Đang giao';
                                            break;
                                        case 'canceled':
                                        case 'Canceled':
                                            echo 'Đã hủy';
                                            break;
                                        case 'completed':
                                        case 'Completed':
                                            echo 'Đã hoàn thành';
                                            break;
                                        default:
                                            echo 'Không xác định';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/user_orders" class="btn btn-primary">Quay lại</a>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
<link rel="stylesheet" href="/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">