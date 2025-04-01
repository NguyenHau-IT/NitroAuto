    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/script.js"></script>

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>
    <div class="overlay">
        <div class="container">
            <h1 class="text-center text-primary-emphasis fs-1"><?= htmlspecialchars($car['name']) ?></h1>

            <div class="car-container d-flex flex-wrap justify-content-center">
                <div class="car-info col-md-5 me-md-3" style="font-size: 1.1rem;">
                    <h3 class="text-success">Thông tin xe</h3>
                    <table class="table table-bordered">
                        <tr>
                            <th>Hãng xe</th>
                            <td class="fs-2"><strong><?= htmlspecialchars($car['brand_name']) ?></strong></td>
                        </tr>
                        <tr>
                            <th>Giá</th>
                            <td class="text-danger"><strong><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</strong></td>
                        </tr>
                        <tr>
                            <th>Năm sản xuất</th>
                            <td><?= htmlspecialchars($car['year']) ?></td>
                        </tr>
                        <tr>
                            <th>Loại nhiên liệu</th>
                            <td><?= htmlspecialchars($car['fuel_type']) ?></td>
                        </tr>
                        <tr>
                            <th>Hộp số</th>
                            <td><?= htmlspecialchars($car['transmission']) ?></td>
                        </tr>
                        <tr>
                            <th>Màu sắc</th>
                            <td><?= htmlspecialchars($car['color']) ?></td>
                        </tr>
                        <tr>
                            <th>Quãng đường</th>
                            <td><?= number_format($car['mileage'], 0, ',', '.') ?> km</td>
                        </tr>
                        <tr>
                            <th>Mô tả</th>
                            <td class="text-start" style="max-width: 600px; overflow: hidden; word-wrap: break-word; white-space: normal;">
                                <div style="max-height: 100px; overflow-y: auto;">
                                    <?= nl2br(htmlspecialchars($car['description'] ?? '')) ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Loại xe</th>
                            <td><?= htmlspecialchars($car['category_name']) ?></td>
                        </tr>
                    </table>
                </div>

                <div class="car-3d col-md-6">
                    <?php if (!empty($images) && $images[0]['image_type'] == '3D'): ?>
                        <div class="sketchfab-embed-wrapper" style="width: 100%; height: 600px; margin-top: 20px;">
                            <iframe src="<?= htmlspecialchars($images[0]['image_url']) ?>" allow="autoplay; fullscreen; xr-spatial-tracking" allowfullscreen onload="this.style.visibility = 'visible';" style="visibility: hidden;"></iframe>
                        </div>
                    <?php else: ?>
                        <img style="height: 80%;" src="/uploads/cars/default.jpg" alt="Ảnh mẫu" class="img-fluid">
                    <?php endif; ?>
                    <div class="text-center mt-4 d-flex justify-content-center gap-3">
                        <a href="../home" class="btn btn-primary d-flex flex-column align-items-center" style="height: 55px;">
                            <i class="fas fa-arrow-left"></i>
                            <span>Quay lại danh sách</span>
                        </a>
                        <form action="/showOrderForm" method="POST" style="display:inline;" class="d-flex flex-column align-items-center">
                            <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['id']); ?>">
                            <button type="submit" class="btn btn-success d-flex flex-column align-items-center">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Đặt mua</span>
                            </button>
                        </form>
                        <form action="/add_favorite" method="POST" class="d-inline d-flex flex-column align-items-center">
                            <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                            <button type="submit" class="btn btn-danger d-flex flex-column align-items-center">
                                <i class="fas fa-heart"></i>
                                <span>Yêu thích</span>
                            </button>
                        </form>
                        <form action="/testdriveform" method="POST" style="display:inline;" class="d-flex flex-column align-items-center">
                            <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['id']); ?>">
                            <button type="submit" class="btn btn-success d-flex flex-column align-items-center">
                                <i class="fas fa-car"></i>
                                <span>Đăng ký lái thử</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-info rounded-4">
                <h2 class="text-center text-white m-3">Các mẫu xe khác</h2>
                <?php require_once __DIR__ . '/car_list.php'; ?>
            </div>
        </div>
    </div>
    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>