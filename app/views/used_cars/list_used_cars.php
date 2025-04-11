<div class="bg-light rounded-4 shadow p-4 border mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary">
            <i class="bi bi-car-front me-2"></i>Bản tin ô tô đã qua sử dụng
        </h2>
        <a href="/add_used_car" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Thêm bài đăng
        </a>
    </div>

    <!-- Cuộn ngang dùng overflow-x + d-flex -->
    <div class="px-2 py-3 overflow-auto">
        <div class="d-flex flex-nowrap gap-3">
            <?php foreach ($used_cars as $car): ?>
                <div class="card border-0 rounded-3 shadow-sm position-relative"
                    style="min-width: 300px; max-width: 300px;">

                    <!-- Link toàn bộ card -->
                    <a href="/show_used_car/<?= htmlspecialchars($car['id']) ?>" class="stretched-link"></a>

                    <div class="ratio ratio-4x3">
                        <img src="<?= htmlspecialchars(!empty($car["image_url"]) ? $car["image_url"] : '/uploads/cars/default.jpg') ?>"
                            loading="lazy"
                            class="object-fit-cover w-100 h-100 rounded-top"
                            alt="<?= htmlspecialchars($car['name']) ?>">
                    </div>

                    <div class="card-body bg-dark text-light d-flex flex-column">
                        <h5 class="fw-bold mb-2 text-truncate"><?= htmlspecialchars($car['name']) ?></h5>
                        <div class="mb-1"><?= htmlspecialchars($car['brand']) ?> - <strong><?= number_format($car['price']) ?> VNĐ</strong></div>
                        <div class="small text-truncate"><?= htmlspecialchars($car['description']) ?></div>
                        <div class="mt-auto pt-2">
                            <small class="text-white-50">Ngày đăng: <?= date('d/m/Y', strtotime($car['created_at'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>