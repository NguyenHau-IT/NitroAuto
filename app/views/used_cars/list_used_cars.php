<div class="bg-light rounded-4 shadow p-4 border mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Danh sách xe đã qua sử dụng</h2>
        <a href="/add_used_car" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Thêm bài đăng
        </a>
    </div>

    <!-- Cuộn ngang -->
    <div class="overflow-auto p-3">
        <div class="d-flex flex-nowrap gap-3">
            <?php foreach ($used_cars as $car): ?>
                <div class="card car-card p-0 shadow-lg rounded-3 overflow-hidden" style="min-width: 300px; max-width: 300px;">
                    <img src="<?= htmlspecialchars(!empty($car["image_url"]) ? $car["image_url"] : '/uploads/cars/default.jpg') ?>"
                         class="card-img-top"
                         alt="<?= htmlspecialchars($car['name']) ?>"
                         style="height: 200px; object-fit: cover;" loading="lazy">
                    <div class="card-body d-flex flex-column text-light bg-dark">
                        <h5 class="card-title fw-bold mb-3" style="height: 30px;">
                            <a href="/show_used_car/<?= htmlspecialchars($car['id']) ?>" class="text-decoration-none text-light">
                                <?= htmlspecialchars($car['name']) ?>
                            </a>
                        </h5>
                        <p class="card-text mb-1">
                            <?= htmlspecialchars($car['brand']) ?> -
                            <strong><?= number_format($car['price']) ?> VNĐ</strong>
                        </p>
                        <p class="card-text text-truncate"><?= htmlspecialchars($car['description']) ?></p>
                        <p class="card-text mt-auto">
                            <small class="text-white-50">Ngày đăng: <?= date('d/m/Y', strtotime($car['created_at'])) ?></small>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
