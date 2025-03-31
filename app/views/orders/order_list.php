    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="/style.css">

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>
    <div class="container overlay mt-5">
        <h2 class="my-4 text-center text-white">Danh sách đơn hàng</h2>
        <table class="table table-bordered table-hover table-striped table-dark">
            <thead class="thead-light">
                <tr>
                    <th>Tên Xe</th>
                    <th>Số lượng</th>
                    <th>Tổng giá</th>
                    <th>Thanh toán</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $current_order_id = null;
                foreach ($orders as $order):
                    if ($current_order_id !== $order["order_id"]):
                        $current_order_id = $order["order_id"];
                ?>
                        <tr class="<?php
                            switch (strtolower($order['status'])) {
                                case 'pending':
                                    echo 'bg-warning';
                                    break;
                                case 'confirmed':
                                    echo 'bg-info';
                                    break;
                                case 'shipped':
                                    echo 'bg-primary';
                                    break;
                                case 'canceled':
                                    echo 'bg-danger';
                                    break;
                                case 'completed':
                                    echo 'bg-success';
                                    break;
                            }
                        ?>">
                            <td colspan="4">
                                <strong>Đơn hàng #<?= $order["order_id"] ?> - Ngày đặt: <?= $order["order_date"] ?> - Trạng thái:
                                    <?php
                                    switch (strtolower($order['status'])) {
                                        case 'pending':
                                            echo 'Đang chờ xử lý......';
                                            break;
                                        case 'confirmed':
                                            echo 'Đã xác nhận';
                                            break;
                                        case 'shipped':
                                            echo 'Đang giao';
                                            break;
                                        case 'canceled':
                                            echo 'Đã hủy';
                                            break;
                                        case 'completed':
                                            echo 'Đã hoàn thành';
                                            break;
                                    }
                                    ?>
                                </strong>
                            </td>
                        </tr>    <?php endif; ?>

                    <tr>
                        <td><?= $order["car_name"] ?></td>
                        <td><?= $order["quantity"] ?></td>
                        <td><?= number_format($order["total_price"]) ?> VNĐ</td>
                        <td>
                            <a href="/order_detail/<?= $order["order_id"] ?>" class="btn btn-success btn-sm">Xem chi tiết</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>