<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Xe Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="overlay">
        <div class="container mt-5 mb-5 bg-light p-5 rounded-4 shadow-lg">
            <h2 class="text-center text-primary mb-4">
                <i class="bi bi-car-front-fill me-2"></i>Chỉnh sửa bài đăng
            </h2>

            <form action="" method="POST" enctype="multipart/form-data" class="row g-4">
                <input type="hidden" name="id" value="<?= $car['id'] ?>">

                <!-- Tên xe -->
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Tên xe</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($car['name']) ?>" required>
                </div>

                <!-- Giá -->
                <div class="col-md-6">
                    <label for="price" class="form-label fw-semibold">Giá (VNĐ)</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $car['price'] ?>" required>
                </div>

                <!-- Hãng xe -->
                <div class="col-md-6">
                    <label for="brand_id" class="form-label fw-semibold">Hãng xe</label>
                    <select class="form-select" id="brand_id" name="brand_id" required>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand['id'] ?>" <?= ($brand['id'] == $car['brand_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($brand['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Danh mục -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-semibold">Danh mục</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= ($category['id'] == $car['category_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Năm sản xuất -->
                <div class="col-md-6">
                    <label for="year" class="form-label fw-semibold">Năm sản xuất</label>
                    <input type="number" class="form-control" id="year" name="year" value="<?= $car['year'] ?>" required>
                </div>

                <!-- Số km đã đi -->
                <div class="col-md-6">
                    <label for="mileage" class="form-label fw-semibold">Số km đã đi</label>
                    <input type="number" class="form-control" id="mileage" name="mileage" value="<?= $car['mileage'] ?>" required>
                </div>

                <!-- Nhiên liệu -->
                <div class="col-md-6">
                    <label for="fuel_type" class="form-label fw-semibold">Loại nhiên liệu</label>
                    <select class="form-select" id="fuel_type" name="fuel_type">
                        <?php $fuels = ['Gasoline' => 'Xăng', 'Diesel' => 'Dầu', 'Hybrid' => 'Hybrid', 'Electric' => 'Điện']; ?>
                        <?php foreach ($fuels as $value => $label): ?>
                            <option value="<?= $value ?>" <?= ($car['fuel_type'] == $value) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Truyền động -->
                <div class="col-md-6">
                    <label for="transmission" class="form-label fw-semibold">Hộp số</label>
                    <select class="form-select" id="transmission" name="transmission">
                        <option value="Automatic" <?= ($car['transmission'] == 'Automatic') ? 'selected' : '' ?>>Tự động</option>
                        <option value="Manual" <?= ($car['transmission'] == 'Manual') ? 'selected' : '' ?>>Số sàn</option>
                    </select>
                </div>

                <!-- Màu xe -->
                <div class="col-md-6">
                    <label for="color" class="form-label fw-semibold">Màu xe</label>
                    <input type="text" class="form-control" id="color" name="color" value="<?= htmlspecialchars($car['color']) ?>">
                </div>

                <!-- Mô tả -->
                <div class="col-md-12">
                    <label for="description" class="form-label fw-semibold">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($car['description']) ?></textarea>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái xe</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="Sold" <?= $car['status'] == 'Sold' ? 'selected' : '' ?>>Đã bán</option>
                            <option value="Pending" <?= $car['status'] == 'Pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                            <option value="Rejected" <?= $car['status'] == 'Rejected' ? 'selected' : '' ?>>Từ chối</option>
                            <option value="Approved" <?= $car['status'] == 'Approved' ? 'selected' : '' ?>>Đã duyệt</option>
                        </select>
                    </div>
                </div>

                <!-- Ảnh hiện tại -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Ảnh hiện tại:</label><br>
                    <img src="<?= $car['normal_image_url'] ?>" alt="Ảnh xe hiện tại" class="img-thumbnail mb-2" style="max-width: 200px;">
                </div>

                <!-- Upload ảnh mới -->
                <div class="col-md-12">
                    <label for="image_url" class="form-label fw-semibold">Thay ảnh mới (tùy chọn)</label>
                    <input type="file" class="form-control" id="image_url" name="image_url">
                </div>

                <!-- Nút -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save2 me-1"></i> Lưu thay đổi
                    </button>
                    <a href="/admin/used_cars" class="btn btn-secondary ms-2">
                        <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
                    </a>
                </div>
            </form>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>