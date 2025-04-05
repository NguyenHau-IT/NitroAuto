<div class="position-fixed top-50 start-0 translate-middle-y d-none d-lg-block z-3" style="left: 10px;">
    <a href="#">
        <img src="<?php echo htmlspecialchars($banner_left['image_url']); ?>" alt="Banner Trái"
            class="rounded-4 shadow  animate__animated animate__bounce animate__infinite"
            style="width: 12vw; height: 70vh; object-fit: cover;">
    </a>
</div>

<!-- Banner cố định bên phải -->
<div class="position-fixed top-50 end-0 translate-middle-y d-none d-lg-block z-3" style="right: 10px;">
    <a href="#">
        <img src="<?php echo htmlspecialchars($banner_right['image_url']); ?>" alt="Banner Phải"
            class="rounded-4 shadow  animate__animated animate__bounce animate__infinite"
            style="width: 12vw; height: 70vh; object-fit: cover;">
    </a>
</div>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Thêm Bootstrap JS đúng cách -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>