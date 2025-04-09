<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center text-primary-emphasis fs-1 fw-bold"><?= htmlspecialchars($car['name']) ?></h1>
    <div class="row g-4">
        <!-- Thông tin xe -->
        <div class="col-lg-6">
            <div class="car-info rounded-4 shadow-lg p-4 bg-light">
                <h3 class="text-success fs-4 mb-3">Thông tin xe</h3>
                <div class="d-flex flex-column gap-3">
                    <div class='d-flex justify-content-between border-bottom pb-2'>
                        <div class='w-100'>
                            <span class='fw-bold'>Hãng xe:</span>
                            <span class='fs-5'><?= htmlspecialchars($car['brand_name']) ?></span>
                        </div>
                    </div>
                    <div class='d-flex justify-content-between border-bottom pb-2'>
                        <div class='w-50'>
                            <span class='fw-bold'>Giá:</span>
                            <span class='fs-5 text-danger fw-bold'><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</span>
                        </div>
                        <div class='w-50 text-end'>
                            <span class='fw-bold'>Mã lực:</span>
                            <span class='fs-5'><?= htmlspecialchars($car['horsepower']) ?> HP</span>
                        </div>
                    </div>
                    <?php
                    $carInfoPairs = [
                        ['Năm sản xuất', $car['year'], 'Loại nhiên liệu', $car['fuel_type']],
                        ['Hộp số', $car['transmission'], 'Màu sắc', $car['color']],
                        ['Quãng đường', number_format($car['mileage'], 0, ',', '.') . ' km', 'Loại xe', $car['category_name']]
                    ];

                    foreach ($carInfoPairs as $pair) {
                        echo "<div class='d-flex justify-content-between border-bottom pb-2'>
                        <div class='w-50'><span class='fw-bold'>{$pair[0]}:</span> <span class='fs-5'>" . htmlspecialchars($pair[1]) . "</span></div>
                        <div class='w-50 text-end'><span class='fw-bold'>{$pair[2]}:</span> <span class='fs-5'>" . htmlspecialchars($pair[3]) . "</span></div>
                      </div>";
                    }
                    ?>
                    <div class='d-flex flex-column border-bottom pb-2'>
                        <span class='fw-bold'>Mô tả:</span>
                        <div class="fs-5" style="height: 150px; overflow-y: auto;">
                            <?= nl2br(htmlspecialchars($car['description'] ?? '')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hình ảnh 3D hoặc ảnh mặc định -->
        <div class="col-lg-6">
            <div class="car-3d rounded-4 shadow-lg p-4 bg-light text-center">
                <?php if (!empty($images) && $images[0]['image_type'] == '3D'): ?>
                    <iframe src="<?= htmlspecialchars($images[0]['image_url']) ?>" allow="autoplay; fullscreen; xr-spatial-tracking" allowfullscreen style="height: 500px; width: 100%; border-radius: 15px;"></iframe>
                <?php else: ?>
                    <img src="/uploads/cars/default.jpg" loading="lazy" alt="Ảnh mẫu" class="img-fluid rounded-4" style="height: 600px; width: 100%; object-fit: cover;">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Các nút hành động -->
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="../home" class="btn btn-primary btn-lg"><i class="bi bi-arrow-left"></i> Quay lại</a>
        <form action="/showOrderForm" method="POST">
            <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-cart"></i> Đặt mua</button>
        </form>
        <form action="/add_favorite" method="POST">
            <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
            <button type="submit" class="btn btn-danger btn-lg"><i class="bi bi-heart-fill"></i> Yêu thích</button>
        </form>
        <form action="/testdriveform" method="POST">
            <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
            <button type="submit" class="btn btn-warning btn-lg"><i class="bi bi-car-front-fill"></i> Đăng kí lái thử</button>
        </form>
    </div>

    <!-- Danh sách xe khác -->
    <div class="bg-info rounded-4 mt-4">
        <h2 class="text-center text-white"><i class="bi bi-car-front"></i> Các mẫu xe khác</h2>
        <?php require_once __DIR__ . '/car_list.php'; ?>
    </div>
    <div class="bg-info rounded-4 mt-4">
        <?php require_once __DIR__ . '/../accessories/accessories_car.php'; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>