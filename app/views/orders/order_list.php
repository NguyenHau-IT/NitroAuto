<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <style>
        body {
            background-image: url('/uploads/bg.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .overlay {
            border-radius: 50px;
            background: rgba(0, 0, 0, 0.7);
            padding: 50px 20px;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="container overlayss mt-5">
        <h2 class="my-4 text-center text-white">Danh sách đơn hàng</h2>
        <table class="table table-bordered table-primary">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên Xe</th>
                    <th>Số lượng</th>
                    <th>Tổng giá</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $current_order_id = null;
                foreach ($orders as $order):
                    if ($current_order_id !== $order["order_id"]):
                        $current_order_id = $order["order_id"];
                ?>
                        <tr style="background-color: #ffc107;">
                            <td colspan="6">
                                <strong>Đơn hàng #<?= $order["order_id"] ?> - Ngày đặt: <?= $order["order_date"] ?> - Trạng thái:
                                    <?php
                                    switch ($order["status"]) {
                                        case 'pending':
                                            echo 'Đang chờ xử lý';
                                            break;
                                        case 'confirmed':
                                            echo 'Hoàn thành';
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
                                        default:
                                            echo 'Không xác định';
                                    }
                                    ?>
                                </strong>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td><?= $order["car_id"] ?></td>
                        <td><?= $order["car_name"] ?></td>
                        <td><?= $order["quantity"] ?></td>
                        <td><?= number_format($order["total_price"]) ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
    <?php include '/ProjectCarSale/includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>