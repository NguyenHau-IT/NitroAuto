<div class="d-flex justify-content-between align-items-center my-4 bg-light rounded-4 shadow">
    <!-- Dropdown bộ lọc -->
    <div class="dropdown">
        <button class="btn btn-outline-info ms-3" type="button" id="filter-toggle-btn">
            <i class="fas fa-filter"></i> Bộ lọc
        </button>
        <div class="dropdown-menu p-3" aria-labelledby="filter-toggle-btn" style="min-width: 600px;" id="filter-dropdown">
            <form action="" method="POST" id="filter-form">
                <div class="d-flex flex-wrap">
                    <!-- Thương hiệu -->
                    <div class="form-group flex-fill pr-2">
                        <label>Thương hiệu</label>
                        <select class="form-control" name="brand">
                            <option value="">Tất cả</option>
                            <?php if (isset($brands) && is_array($brands)): foreach ($brands as $brandItem): ?>
                                    <option value="<?= htmlspecialchars($brandItem['id']) ?>"
                                        <?= isset($_POST['brand']) && $_POST['brand'] == $brandItem['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($brandItem['name']) ?>
                                    </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <!-- Sắp xếp theo giá -->
                    <div class="form-group flex-fill pr-2">
                        <label>Sắp xếp theo giá</label>
                        <select class="form-control" name="sortCar">
                            <option value="">Chọn</option>
                            <option value="asc" <?= isset($_POST['sortCar']) && $_POST['sortCar'] == 'asc' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                            <option value="desc" <?= isset($_POST['sortCar']) && $_POST['sortCar'] == 'desc' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                        </select>
                    </div>

                    <!-- Mức giá -->
                    <div class="form-group flex-fill pr-2">
                        <label>Mức giá</label>
                        <select class="form-control" name="price_range">
                            <option value="">Chọn mức giá...</option>
                            <option value="0-500000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '0-500000000' ? 'selected' : '' ?>>Dưới 500 triệu</option>
                            <option value="500000000-1000000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '500000000-1000000000' ? 'selected' : '' ?>>Từ 500 triệu đến 1 tỷ</option>
                            <option value="1000000000-2000000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '1000000000-2000000000' ? 'selected' : '' ?>>Từ 1 tỷ đến 2 tỷ</option>
                            <option value="2000000000-3000000000" <?= isset($_POST['price_range']) && $_POST['price_range'] == '2000000000-3000000000' ? 'selected' : '' ?>>Từ 2 tỷ đến 3 tỷ</option>
                            <option value="3000000000+" <?= isset($_POST['price_range']) && $_POST['price_range'] == '3000000000+' ? 'selected' : '' ?>>Trên 3 tỷ</option>
                        </select>
                    </div>

                    <!-- Nhiên liệu -->
                    <div class="form-group flex-fill pr-2">
                        <label>Loại nhiên liệu</label>
                        <select class="form-control" name="fuel_type">
                            <option value="">Chọn loại nhiên liệu...</option>
                            <option value="Gasoline" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Gasoline' ? 'selected' : '' ?>>Xăng</option>
                            <option value="Diesel" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Diesel' ? 'selected' : '' ?>>Dầu</option>
                            <option value="Electric" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Electric' ? 'selected' : '' ?>>Điện</option>
                            <option value="Hybrid" <?= isset($_POST['fuel_type']) && $_POST['fuel_type'] == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                        </select>
                    </div>

                    <!-- Loại xe -->
                    <div class="form-group flex-fill pr-2">
                        <label>Loại xe</label>
                        <select class="form-control" name="car_type">
                            <option value="">Chọn loại xe...</option>
                            <?php if (isset($categories) && is_array($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>"
                                        <?= isset($_POST['car_type']) && $_POST['car_type'] == $category['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Năm sản xuất -->
                    <div class="form-group flex-fill">
                        <label>Năm sản xuất</label>
                        <select class="form-control" name="year_manufacture" id="year-manufacture-select">
                            <option value="">Chọn năm sản xuất...</option>
                            <?php for ($i = date('Y'); $i >= 1800; $i--): ?>
                                <option value="<?= htmlspecialchars($i) ?>"
                                    <?= isset($_POST['year_manufacture']) && $_POST['year_manufacture'] == $i ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($i) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <!-- Nút áp dụng và reset -->
                <div class="d-flex mt-3 justify-content-center">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-check-circle"></i> Áp dụng
                    </button>
                    <button type="reset" class="btn btn-secondary" id="reset-filters">
                        <i class="fas fa-redo"></i> Đặt lại
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Ô tìm kiếm -->
    <form action="" method="POST" class="ml-2 position-relative p-3" id="search-form" style="flex: 1;">
        <input type="hidden" name="brand" value="<?= isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : '' ?>">
        <input type="hidden" name="sortCar" value="<?= isset($_POST['sortCar']) ? htmlspecialchars($_POST['sortCar']) : '' ?>">
        <div class="input-group">
            <input type="text" class="form-control" id="search-input" name="search" placeholder="Tìm kiếm xe..." aria-label="Tìm kiếm xe..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap JS và các thư viện -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/script.js"></script>
<link rel="stylesheet" href="/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">