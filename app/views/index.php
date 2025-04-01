<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-center">
        <p class="mb-4 text-warning font-weight-bold" style="font-size: 80px;">Nitro Auto</p>

        <!-- Lịch sử xem xe -->
        <?php require_once __DIR__ . '/../views/cars/history_view_car.php'; ?>

        <!-- Bộ lọc và ô tìm kiếm -->
        <?php require_once __DIR__ . '/../views/cars/filter.php'; ?>

        <!-- Danh sách xe -->
        <?php require_once __DIR__ . '/../views/cars/car_list.php'; ?>

    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>