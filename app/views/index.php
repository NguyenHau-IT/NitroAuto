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
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<link rel="stylesheet" href="/style.css">
<!-- SweetAlert2 trước -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- script.js sau -->
<script src="/script.js"></script>
<!-- Bootstrap & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>