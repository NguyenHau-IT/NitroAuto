<?php if ($banner_left != null || $banner_right != null): ?>

    <?php if ($banner_left != null): ?>
        <div class="position-fixed top-50 start-0 translate-middle-y d-none d-lg-block z-3" style="left: 10px;">
            <a href="#">
                <img src="<?php echo htmlspecialchars($banner_left['image_url']); ?>" alt="Banner Trái"
                    class="rounded-4 shadow"
                    style="width: 12vw; height: 60vh; object-fit: cover;">
            </a>
        </div>
    <?php endif; ?>

    <?php if ($banner_right != null): ?>
        <div class="position-fixed top-50 end-0 translate-middle-y d-none d-lg-block z-3" style="right: 10px;">
            <a href="#">
                <img src="<?php echo htmlspecialchars($banner_right['image_url']); ?>" alt="Banner Phải"
                    class="rounded-4 shadow"
                    style="width: 12vw; height: 60vh; object-fit: cover;">
            </a>
        </div>
    <?php endif; ?>

<?php endif; ?>