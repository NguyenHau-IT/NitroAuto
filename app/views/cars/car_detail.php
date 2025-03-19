<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết xe - <?= htmlspecialchars($car['name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
    <style>
        body {
            background-image: url('/uploads/bg.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .overlay {
            border-radius: 50px;
            background: rgba(0, 0, 0, 0.7);
            padding-bottom: 20px;
        }

        .car-info,
        .car-3d {
            background: #fff;
            padding: 5px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sketchfab-embed-wrapper iframe {
            width: 100%;
            height: 500px;
            border: none;
        }

        @media (max-width: 768px) {
            .car-container {
                display: flex;
                flex-direction: column;
            }

            .car-info,
            .car-3d {
                width: 100%;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="container overlay" style="max-width: 1200px;">
        <h1 class="text-center" style="color: white; font-size: 2.5rem;"><?= htmlspecialchars($car['name']) ?></h1>

        <div class="car-container d-flex flex-wrap justify-content-center">
            <div class="car-info col-md-5 me-md-3" style="font-size: 1.1rem;">
                <h3 class="text-success">Thông tin xe</h3>
                <table class="table table-bordered">
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
                        <td><?= $car['mileage'] ?> km</td>
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
                        <th>Số xe còn lại</th>
                        <td><?= $car['stock'] ?></td>
                </table>
            </div>

            <div class="car-3d col-md-6">
                <?php if (!empty($images) && $images[0]['image_type'] == '3D'): ?>
                    <div class="sketchfab-embed-wrapper">
                        <iframe src="<?= htmlspecialchars($images[0]['image_url']) ?>" allow="autoplay; fullscreen; xr-spatial-tracking" allowfullscreen onload="this.style.visibility = 'visible';" style="visibility: hidden;"></iframe>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Không có mô hình 3D</p>
                <?php endif; ?>
                <div class="text-center mt-4 d-flex justify-content-center gap-3">
                    <a href="../home" class="btn btn-primary d-flex flex-column align-items-center">
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
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>