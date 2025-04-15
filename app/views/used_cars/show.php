<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center text-primary-emphasis fs-1 fw-bold">
        <?= htmlspecialchars($used_car['name']) ?>
    </h1>

    <div class="row g-4">
        <!-- Cột thông tin -->
        <div class="col-lg-6">
            <div class="rounded-4 shadow-lg p-4 bg-light">
                <h3 class="text-success fs-4 mb-3">Thông tin xe</h3>
                <div class="d-flex flex-column gap-3">

                    <!-- Hãng & Giá -->
                    <div class="d-flex justify-content-between border-bottom pb-2">
                        <div class="w-50">
                            <span class="fw-bold">Hãng xe:</span>
                            <span class="fs-5"><?= htmlspecialchars($used_car['brand_name']) ?></span>
                        </div>
                        <div class="w-50 text-end">
                            <span class="fw-bold">Giá:</span>
                            <span class="fs-5 text-danger fw-bold"><?= number_format($used_car['price'], 0, ',', '.') ?> VNĐ</span>
                        </div>
                    </div>

                    <!-- Các cặp thông tin -->
                    <?php
                    $carInfoPairs = [
                        ['Năm sản xuất', $used_car['year'], 'Loại nhiên liệu', $used_car['fuel_type']],
                        ['Hộp số', $used_car['transmission'], 'Màu sắc', $used_car['color']],
                        ['Quãng đường', number_format($used_car['mileage'], 0, ',', '.') . ' km', 'Loại xe', $used_car['category_name']]
                    ];
                    foreach ($carInfoPairs as $pair) {
                        echo "<div class='d-flex justify-content-between border-bottom pb-2'>
                                <div class='w-50'><span class='fw-bold'>{$pair[0]}:</span> <span class='fs-5'>" . htmlspecialchars($pair[1]) . "</span></div>
                                <div class='w-50 text-end'><span class='fw-bold'>{$pair[2]}:</span> <span class='fs-5'>" . htmlspecialchars($pair[3]) . "</span></div>
                              </div>";
                    }
                    ?>

                    <!-- Mô tả -->
                    <div class="d-flex flex-column border-bottom pb-2">
                        <span class="fw-bold">Mô tả:</span>
                        <div class="fs-5 overflow-auto" style="max-height: 150px;">
                            <?= nl2br(htmlspecialchars($used_car['description'] ?? '')) ?>
                        </div>
                    </div>

                    <!-- Ngày đăng & trạng thái -->
                    <div class="d-flex justify-content-between border-bottom pb-2">
                        <div class="w-50">
                            <span class="fw-bold">Thời gian đăng tin:</span>
                            <span class="fs-5"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($used_car['created_at']))) ?></span>
                        </div>
                        <div class="w-50 text-end">
                            <span class="fw-bold">Trạng thái:</span>
                            <span class="badge fs-6 <?= $used_car['status'] === 'Sold' ? 'bg-danger' : 'bg-success' ?>">
                                <?= $used_car['status'] === 'Sold' ? 'Đã bán' : 'Còn' ?>
                            </span>
                        </div>
                    </div>

                    <!-- Người đăng -->
                    <div class="d-flex justify-content-between border-bottom pb-2">
                        <div class="w-50">
                            <span class="fw-bold">Người đăng:</span>
                            <span class="fs-5"><?= htmlspecialchars($used_car['user_name']) ?></span>
                        </div>
                        <div class="w-50 text-end">
                            <span class="fw-bold">Số điện thoại:</span>
                            <span class="fs-5"><?= htmlspecialchars($used_car['user_phone']) ?></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start border-bottom pb-2">
                        <div class="w-100">
                            <span class="fw-bold">Email:</span>
                            <span class="fs-5"><?= htmlspecialchars($used_car['user_email']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột ảnh -->
        <div class="col-lg-6">
            <div class="rounded-4 shadow-lg p-4 bg-light text-center">
                <img src="<?= htmlspecialchars($used_car['normal_image_url']) ?>"
                     onerror="this.src='/uploads/cars/default.jpg';"
                     alt="Hình ảnh xe"
                     class="img-fluid rounded-4"
                     style="max-height: 620px; object-fit: cover;" loading="lazy">
            </div>
        </div>
    </div>

    <!-- Nút hành động -->
    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
        <a href="/home" class="btn btn-primary btn-lg">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Gợi ý các xe khác -->
    <div class="mt-5">
        <?php require_once __DIR__ . '/list_used_cars.php'; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
