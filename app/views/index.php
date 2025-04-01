<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-center">
        <h1 class="mb-4 text-warning font-weight-bold">Nitro Auto</h1>

        <!-- Lịch sử xem xe -->
        <?php require_once __DIR__ . '/../views/cars/history_view_car.php'; ?>

        <!-- Bộ lọc và ô tìm kiếm -->
        <?php require_once __DIR__ . '/../views/cars/filter.php'; ?>

        <!-- Danh sách xe -->
        <div id="carListContainer">
            <?php require_once __DIR__ . '/../views/cars/car_list.php'; ?>
        </div>

    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>