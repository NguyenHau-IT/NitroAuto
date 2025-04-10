<div class="bg-light rounded-4 shadow p-4 border mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Danh sách xe đã qua sử dụng</h2>
        <a href="/add_used_car" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Thêm bài đăng
        </a>
    </div>

    <!-- Cuộn ngang -->
    <div class="overflow-auto p-3" style="scrollbar-width: none; -ms-overflow-style: none;">
        <div class="d-flex flex-nowrap gap-3">
            <?php foreach ($used_cars as $car): ?>
                <div class="card car-card shadow-lg rounded-3 overflow-hidden border-0 position-relative"
                    style="min-width: 300px; max-width: 300px; transition: transform 0.3s;">

                    <!-- Link bao phủ toàn bộ card -->
                    <a href="/show_used_car/<?= htmlspecialchars($car['id']) ?>" class="stretched-link"></a>

                    <div style="height: 200px; overflow: hidden;">
                        <img src="<?= htmlspecialchars(!empty($car["image_url"]) ? $car["image_url"] : '/uploads/cars/default.jpg') ?>"
                            class="w-100 h-100"
                            alt="<?= htmlspecialchars($car['name']) ?>"
                            style="object-fit: cover;" loading="lazy">
                    </div>

                    <div class="card-body d-flex flex-column text-light bg-dark">
                        <h5 class="card-title fw-bold mb-2" style="height: 2.5em; overflow: hidden;">
                            <?= htmlspecialchars($car['name']) ?>
                        </h5>
                        <p class="card-text mb-1">
                            <?= htmlspecialchars($car['brand']) ?> -
                            <strong><?= number_format($car['price']) ?> VNĐ</strong>
                        </p>
                        <p class="card-text text-truncate small"><?= htmlspecialchars($car['description']) ?></p>
                        <p class="card-text mt-auto">
                            <small class="text-white-50">Ngày đăng: <?= date('d/m/Y', strtotime($car['created_at'])) ?></small>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
