<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container text-dark mb-4 bg-light shadow rounded-4 p-4">
        <h2 class="mt-5 text-center">Dịch vụ ô tô</h2>

        <div class="row mt-4">
            <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary"><?= $service['ServiceName'] ?></h5>
                            <p class="card-text text-muted"><?= $service['Description'] ?></p>
                            <div class="mb-2">
                                <span class="badge bg-success">Giá: <?= number_format($service['Price'], 0, ',', '.') ?> đ</span>
                                <span class="badge bg-info text-dark">⏱ <?= $service['EstimatedTime'] ?> phút</span>
                            </div>
                            <div class="mt-auto">
                                <a href="/order_service_form?service_id=<?= $service['ServiceID'] ?>" class="btn btn-primary w-100 mt-2">
                                    Đặt lịch hẹn
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-end">
            <a href="/home" class="btn btn-danger mt-3">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
