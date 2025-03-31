<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-center">
        <h1 class="mb-4 text-warning font-weight-bold">Nitro Auto</h1>

        <!-- Lịch sử xem xe -->
        <div class="container mb-3">
            <div class="card shadow-sm mx-auto p-3" style="max-height: 250px; overflow-y: auto;">
                <div class="card-body">
                    <h5 class="text-warning text-left mb-2">Xe đã xem</h5>
                    <div class="d-flex flex-wrap justify-content-start">
                        <?php if (!empty($histories)): ?>
                            <?php foreach ($histories as $history): ?>
                                <div class="p-2 border border-light rounded shadow-sm bg-light m-1 d-flex align-items-center" style="width: 220px;">
                                    <img src="<?= htmlspecialchars($history['image_url'] ?? '/uploads/cars/default.jpg') ?>"
                                        alt="<?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>"
                                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                    <h6 class="mb-0 flex-grow-1">
                                        <a href="car_detail/<?= htmlspecialchars($history['car_id'] ?? '') ?>"
                                            class="text-left text-dark font-weight-bold">
                                            <?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>
                                        </a>
                                    </h6>
                                </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center text-muted">🚗 Bạn chưa xem xe nào.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>



        <!-- Bộ lọc theo hãng xe -->
        <form action="" method="GET" class="mb-4" onsubmit="redirectToBrand(event)">
            <div class="input-group">
                <select class="form-control custom-select" id="brand-select">
                    <option value="">Chọn hãng xe...</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= htmlspecialchars($brand['id']) ?>"><?= htmlspecialchars($brand['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-warning font-weight-bold" type="submit">Tìm kiếm</button>
                </div>
            </div>
        </form>

        <!-- Danh sách xe -->
        <div class="row" id="car-list">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card car-card">
                            <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                                <img src="<?= htmlspecialchars(!empty($car["image"]) ? $car["image"] : '/uploads/cars/default.jpg') ?>"
                                    class="card-img-top car-image"
                                    alt="<?= htmlspecialchars($car['name']) ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-white">
                                        <?= htmlspecialchars($car['name']) ?>
                                    </a>
                                </h5>
                                <p class="card-text"><i class="fas fa-money-bill-wave"></i> Giá:
                                    <strong><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</strong>
                                </p>
                                <p class="card-text"><i class="fas fa-gas-pump"></i> Nhiên liệu: <?= htmlspecialchars($car['fuel_type']) ?></p>
                                <div class="favorite-btn mt-3">
                                    <form action="/add_favorite" method="POST">
                                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-heart"></i> Yêu thích</button>
                                    </form>
                                    <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="btn btn-outline-light btn-block mt-2">
                                        <i class="fas fa-info-circle"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-warning">⚠️ Hiện tại không có xe nào để bán.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<!-- Bootstrap & FontAwesome -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>