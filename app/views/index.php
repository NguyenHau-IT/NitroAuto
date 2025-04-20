<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<!-- Banner cố định 2 bên -->
    <?php require_once __DIR__ . '/../views/slice-bar/left_right.php'; ?>

<div class="overlay">
    <div class="container">
        <div class="text-center">
            <!-- Lịch sử xem xe -->
            <?php require_once __DIR__ . '/../views/cars/history_view_car.php'; ?>

            <!-- Slice Bar -->
            <?php require_once __DIR__ . '/../views/slice-bar/slider.php'; ?>

            <!-- Bộ lọc và ô tìm kiếm -->
            <?php require_once __DIR__ . '/../views/cars/filter.php'; ?>

            <!-- Danh sách xe -->
            <div id="car-list-container">
                <?php require_once __DIR__ . '/../views/cars/car_list.php'; ?>
            </div>

            <?php require_once __DIR__ . '/../views/used_cars/list_used_cars.php'; ?>

            <?php require_once __DIR__ . '/../views/news/news.php'?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>