<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<link rel="stylesheet" href="/style.css">
<div class="overlay">
    <div class="container text-dark mb-4 bg-light shadow rounded-4 p-4">
        <!-- Danh sách dịch vụ -->
        <h2 class="mt-5 text-center">Dịch vụ ô tô</h2>
        <div class="table-container mt-3">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên dịch vụ</th>
                        <th>Mô tả</th>
                        <th>Giá tiền</th>
                        <th>Thời gian (phút)</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?= $service['ServiceID'] ?></td>
                            <td><?= $service['ServiceName'] ?></td>
                            <td><?= $service['Description'] ?></td>
                            <td><?= number_format($service['Price'], 0, ',', '.') ?> đ</td>
                            <td><?= $service['EstimatedTime'] ?></td>
                            <td>
                                <a href="/order_service_form" class="btn btn-primary">
                                    Đặt dịch vụ
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-end">
            <a href="/home" class="btn btn-danger   " style="align-content: center; margin-left: 10px;">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>