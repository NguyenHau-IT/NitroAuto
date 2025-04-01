<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-center">
        <h1 class="mb-4 text-warning font-weight-bold">Nitro Auto</h1>

        <!-- Lịch sử xem xe -->
        <?php require_once __DIR__ . '/../views/cars/history_view_car.php'; ?>

        <?php require_once __DIR__ . '/../views/cars/filter.php'; ?>

        <!-- Danh sách xe -->
        <div class="row d-flex flex-wrap justify-content-center" id="car-list">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="card car-card m-2" style="width: 23%;">
                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                            <img src="<?= htmlspecialchars(!empty($car["image"]) ? $car["image"] : '/uploads/cars/default.jpg') ?>"
                                class="card-img-top car-image"
                                alt="<?= htmlspecialchars($car['name']) ?>">
                        </a>
                        <div class="card-body text-center">
                            <h6 class="card-title">
                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-white">
                                    <?= htmlspecialchars($car['name']) ?>
                                </a>
                            </h6>
                            <p class="card-text small"><i class="fas fa-money-bill-wave me-1"></i> Giá:
                                <span class="fw-bold"><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</span>
                            </p>
                            <p class="card-text small"><i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?></p>
                            <div class="favorite-btn mt-2">
                                <form action="/add_favorite" method="POST">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-heart"></i> Yêu thích</button>
                                </form>
                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="btn btn-outline-light btn-sm mt-1">
                                    <i class="fas fa-info-circle"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning text-center" role="alert">
                    ⚠️ Không tìm thấy xe nào phù hợp với tiêu chí tìm kiếm của bạn.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>