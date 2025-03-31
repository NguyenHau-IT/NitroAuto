<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-center">
        <h1 class="mb-4 text-warning font-weight-bold">Nitro Auto</h1>

        <!-- Lịch sử xem xe -->
        <?php require_once __DIR__ . '/../views/cars/history_view_car.php'; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <button class="btn btn-primary" type="button" id="filter-toggle-btn">Bộ lọc</button>
            <form action="" method="POST" class="ml-2 position-relative" id="search-form" style="flex: 1;">
                <input type="hidden" name="brand" id="hidden-brand" value="<?= isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '' ?>">
                <input type="hidden" name="sortCar" id="hidden-sort" value="<?= isset($_POST['sortCar']) ? htmlspecialchars($_POST['sortCar']) : '' ?>">

                <div class="input-group">
                    <input type="text" class="form-control" id="search-input" name="search" placeholder="Tìm kiếm xe..." aria-label="Tìm kiếm xe..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div id="filter-section" class="d-none">
            <div class="d-flex justify-content-between mb-4">
                <form action="" method="POST" id="brand-form" class="mr-2" style="flex: 1;">
                    <input type="hidden" name="sortCar" value="<?= isset($_POST['sortCar']) ? htmlspecialchars($_POST['sortCar']) : '' ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">

                    <div class="input-group">
                        <select class="form-control custom-select" id="brand-select" name="brand">
                            <option value="">Chọn hãng xe...</option>
                            <?php foreach ($brands as $brandItem): ?>
                                <option value="<?= htmlspecialchars($brandItem['id']) ?>"
                                    <?= isset($_POST['brand']) && $_POST['brand'] == $brandItem['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($brandItem['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>

                <form action="" method="POST" id="sort-form" style="flex: 1;">
                    <input type="hidden" name="brand" value="<?= isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '' ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">

                    <div class="input-group">
                        <select class="form-control custom-select" id="sortCar" name="sortCar">
                            <option value="">Sắp xếp theo giá</option>
                            <option value="asc" <?= isset($_POST['sortCar']) && $_POST['sortCar'] == 'asc' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                            <option value="desc" <?= isset($_POST['sortCar']) && $_POST['sortCar'] == 'desc' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                        </select>
                    </div>
                </form>

                <form action="" method="POST" id="price-range-form" style="flex: 1;">
                    <input type="hidden" name="sortCar" value="<?= isset($_POST['sortCar']) ? htmlspecialchars($_POST['sortCar']) : '' ?>">
                    <input type="hidden" name="brand" value="<?= isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '' ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                    <div class="input-group" style="flex: 1;">
                        <select class="form-control custom-select" id="price-range" name="price_range">
                            <option value="">Chọn mức giá...</option>
                            <option value="0-500000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '0-500000000' ? 'selected' : '' ?>>Dưới 500 triệu</option>
                            <option value="500000000-1000000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '500000000-1000000000' ? 'selected' : '' ?>>Từ 500 triệu đến 1 tỷ</option>
                            <option value="1000000000-2000000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '1000000000-2000000000' ? 'selected' : '' ?>>Từ 1 tỷ đến 2 tỷ</option>
                            <option value="2000000000-3000000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '2000000000-3000000000' ? 'selected' : '' ?>>Từ 2 tỷ đến 3 tỷ</option>
                            <option value="3000000000+" <?= isset($_POST['price_range']) && $_POST['price_range'] == '3000000000+' ? 'selected' : '' ?>>Trên 3 tỷ</option>
                        </select>
                    </div>
                </form>

                <form action="" method="POST" id="fuel-type-form" style="flex: 1;">
                    <input type="hidden" name="sortCar" value="<?= isset($_POST['sortCar']) ? htmlspecialchars($_POST['sortCar']) : '' ?>">
                    <input type="hidden" name="brand" value="<?= isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '' ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                    <div class="input-group">
                        <select class="form-control custom-select" id="fuel-type" name="fuel_type">
                            <option value="">Chọn loại nhiên liệu...</option>
                            <option value="Gasoline" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Gasoline' ? 'selected' : '' ?>>Xăng</option>
                            <option value="Diesel" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Diesel' ? 'selected' : '' ?>>Dầu</option>
                            <option value="Electric" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Electric' ? 'selected' : '' ?>>Điện</option>
                            <option value="Hybrid" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                        </select>
                    </div>
                </form>

                <form action="" method="POST" id="car-type-form" style="flex: 1;">
                    <input type="hidden" name="sortCar" value="<?= isset($_POST['sortCar']) ? htmlspecialchars($_POST['sortCar']) : '' ?>">
                    <input type="hidden" name="brand" value="<?= isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '' ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                    <div class="input-group">
                        <select class="form-control custom-select" id="car-type" name="car_type">
                            <option value="">Chọn loại xe...</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>"
                                    <?= isset($_POST['car_type']) && $_POST['car_type'] == $category['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>

                <form action="" method="POST" id="year-manufacture-form" style="flex: 1">
                    <input type="hidden" name="sortCar" value="<?= isset($_POST['sortCar']) ? htmlspecialchars($_POST['sortCar']) : '' ?>">
                    <input type="hidden" name="brand" value="<?= isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '' ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                    <div class="input-group">
                        <select class="form-control custom-select" id="year-manufacture" name="year_manufacture">
                            <option value="">Chọn năm sản xuất...</option>
                            <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                <option value="<?= htmlspecialchars($i) ?>"
                                    <?= isset($_POST['year_manufacture']) && $_POST['year_manufacture'] == $i ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($i) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danh sách xe -->
        <div class="row d-flex flex-wrap justify-content-center" id="car-list">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="card car-card m-2" style="width: 23%;">
                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                            <img src="<?= htmlspecialchars(!empty($car["image"]) ? $car["image"] : '/uploads/cars/default.jpg') ?>"
                                class="card-img-top car-image"
                                alt="<?= htmlspecialchars($car['name']) ?>">
                        </a>
                        <div class="card-body text-center">
                            <h6 class="card-title">
                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-white">
                                    <?= htmlspecialchars($car['name']) ?>
                                </a>
                            </h6>
                            <p class="card-text small"><i class="fas fa-money-bill-wave me-1"></i> Giá:
                                <span class="fw-bold"><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</span>
                            </p>
                            <p class="card-text small"><i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?></p>
                            <div class="favorite-btn mt-2">
                                <form action="/add_favorite" method="POST">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-heart"></i> Yêu thích</button>
                                </form>
                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="btn btn-outline-light btn-sm mt-1">
                                    <i class="fas fa-info-circle"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-warning text-center">⚠️ Hiện tại không có xe nào để bán.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>