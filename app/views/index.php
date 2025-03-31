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