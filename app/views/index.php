<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-center">
        <!-- Lịch sử xem xe -->
        <?php require_once __DIR__ . '/../views/cars/history_view_car.php'; ?>

        <!--Slice Bar-->
        <?php require_once __DIR__ . '/../views/slice-bar/slider.php'; ?>

        <!-- Bộ lọc và ô tìm kiếm -->
        <?php require_once __DIR__ . '/../views/cars/filter.php'; ?>

        <!-- Danh sách xe -->
        <div id="car-list-container">
            <?php require_once __DIR__ . '/../views/cars/car_list.php'; ?>
        </div>

    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>