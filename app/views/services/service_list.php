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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>