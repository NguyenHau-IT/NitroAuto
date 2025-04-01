    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="/style.css">

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>
    <div class="container overlay text-dark fs-5 mb-4">
        <div class="overlay mt-2 bg-light rounded-4 shadow p-4">
            <h2 class="my-4 text-center text-dark fs-1">Danh sách đơn hàng</h2>
            <table class="table table-bordered table-hover table-striped ">
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
                                    <strong>Đơn hàng #<?= $order["order_id"] ?> - Ngày đặt: <?= date('d/m/Y - H:i:s', strtotime($order['order_date'])) ?> - Trạng thái:
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
                            </tr> <?php endif; ?>

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
    </div>
    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/script.js"></script>