<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<div class="overlay">
    <div class="container mt-5">
        <h2 class="text-center text-white">Chi tiết đơn hàng #<?= $order['order_id'] ?></h2>
        <div class="row mt-5">
            <div class="col-md-6">
                <h4 class="text-white">Thông tin khách hàng</h4>
                <table class="table table-bordered table-hover table-striped table-dark">
                    <tbody>
                        <tr>
                            <th scope="row">Họ tên</th>
                            <td><?= htmlspecialchars($order['full_name']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><?= htmlspecialchars($order['email']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Điện thoại</th>
                            <td><?= htmlspecialchars($order['phone']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Địa chỉ</th>
                            <td><?= htmlspecialchars($order['address']) ?></td>
                        </tr>
                    </tbody>
                </table>    
            </div>
            <div class="col-md-6">
                <h4 class="text-white">Thông tin đơn hàng</h4>   
                <table class="table table-bordered table-hover table-striped table-dark">
                    <tbody>
                        <tr>
                            <th scope="row">Tên xe</th>
                            <td><?= htmlspecialchars($order['car_name']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Số lượng</th>
                            <td><?= htmlspecialchars($order['quantity']) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tổng giá</th>
                            <td><?= number_format($order['subtotal'], 0, ',', '.') ?> VNĐ</td>
                        </tr>
                        <tr>
                            <th scope="row">Ngày đặt</th>
                            <td><?= $order['order_date'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Trạng thái</th>
                            <td>
                                <?php
                                switch ($order['status']) {
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
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
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            max-width: 1200px;
            margin: 20px auto;
        }

        .table {
            margin-top: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>