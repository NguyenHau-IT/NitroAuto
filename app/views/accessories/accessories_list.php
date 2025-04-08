<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<div class="overlay">
    <div class="container mt-5 mb-5 bg-light rounded-4 shadow-lg p-4">
        <h1 class="mb-4 text-center">Danh sách phụ kiện cho xe</h1>

        <div class="row">
            <?php foreach ($accessories as $accessory): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm rounded-4 border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($accessory['name']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($accessory['description']) ?></p>
                            <p class="mt-auto fw-bold text-success"><?= number_format($accessory['price'], 0, ',', '.') ?> VNĐ</p>
                            <a href="/add_to_cart/<?= $accessory['id'] ?>" class="btn btn-success w-100 mt-2">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                            </a>
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
