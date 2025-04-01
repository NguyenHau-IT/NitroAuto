<div class="mt-3 bg-light rounded-4 shadow p-3">
    <?php if (!empty($cars)): ?>
        <div class="row g-3 justify-content-center">
            <?php foreach ($cars as $car): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card car-card p-0 h-100 shadow-sm rounded-3 overflow-hidden">
                        <!-- Hình ảnh xe -->
                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                            <img src="<?= htmlspecialchars(!empty($car["image"]) ? $car["image"] : '/uploads/cars/default.jpg') ?>"
                                class="card-img-top car-image"
                                alt="<?= htmlspecialchars($car['name']) ?>"
                                style="height: 200px; object-fit: cover;">
                        </a>

                        <div class="card-body text-center text-light">
                            <h5 class="card-title fw-bold h-25">
                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($car['name']) ?>
                                </a>
                            </h5>
                            <p class="card-text fw-bold">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                <?= number_format($car['price'], 0, ',', '.') ?> VNĐ
                            </p>
                            <p class="card-text">
                                <i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?> |
                                <i class="fas fa-car"></i> <?= htmlspecialchars($car['category_name']) ?>
                            </p>

                            <!-- Phần nút hành động -->
                            <div class="mt-2 d-flex justify-content-center">
                                <form action="/showOrderForm" method="POST" class="me-2 d-flex flex-column justify-content-between">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']); ?>">
                                    <button type="submit" class="btn btn-success d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-shopping-cart me-1"></i> <span>Đặt mua</span>
                                    </button>
                                </form>
                                <form action="/add_favorite" method="POST" class="me-2 d-flex flex-column justify-content-between">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                    <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-heart me-1"></i>
                                    </button>
                                </form>
                                <form action="/compare" method="POST" class="d-flex flex-column justify-content-between">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center h-100">
                                        So sánh
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            ⚠️ Không tìm thấy xe nào phù hợp với tiêu chí tìm kiếm của bạn.
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">