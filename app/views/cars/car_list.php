<div class="mt-4 bg-light rounded-4 shadow p-4">
    <?php if (!empty($cars)): ?>
        <div class="row g-4 justify-content-center">
            <?php foreach ($cars as $car): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card car-card p-0 h-100 shadow-lg rounded-3 overflow-hidden">
                        <!-- Hình ảnh xe -->
                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                            <img src="<?= htmlspecialchars(!empty($car["image"]) ? $car["image"] : '/uploads/cars/default.jpg') ?>"
                                 class="card-img-top car-image"
                                 alt="<?= htmlspecialchars($car['name']) ?>"
                                 style="height: 200px; object-fit: cover; transition: transform 0.3s ease-in-out;">
                        </a>

                        <div class="card-body text-center bg-dark text-light">
                            <h5 class="card-title fw-bold text-truncate mb-3">
                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-decoration-none text-light">
                                    <?= htmlspecialchars($car['name']) ?>
                                </a>
                            </h5>
                            <p class="card-text fw-bold text-warning">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                <?= number_format($car['price'], 0, ',', '.') ?> VNĐ
                            </p>
                            <p class="card-text text-light">
                                <i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?> |
                                <i class="fas fa-car"></i> <?= htmlspecialchars($car['category_name']) ?>
                            </p>

                            <!-- Phần nút hành động -->
                            <div class="mt-3 d-flex justify-content-center gap-3 flex-wrap">
                                <!-- Đặt mua button -->
                                <form action="/showOrderForm" method="POST">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']); ?>">
                                    <button type="submit" class="btn btn-lg btn-success d-flex align-items-center justify-content-center shadow-sm rounded-3 hover-scale">
                                        <i class="fas fa-shopping-cart me-1"></i> <span>Đặt mua</span>
                                    </button>
                                </form>

                                <!-- So sánh button -->
                                <form action="/compare" method="POST">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                    <button type="submit" class="btn btn-lg btn-outline-primary d-flex align-items-center justify-content-center shadow-sm rounded-3 hover-scale">
                                        So sánh
                                    </button>
                                </form>

                                <!-- Yêu thích button -->
                                <form action="/add_favorite" method="POST">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                    <button type="submit" class="btn btn-lg btn-danger d-flex align-items-center justify-content-center shadow-sm rounded-3 hover-scale">
                                        <i class="fas fa-heart me-1"></i>
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
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<link rel="stylesheet" href="/style.css">
