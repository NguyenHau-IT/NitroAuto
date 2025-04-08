<?php if (!empty($histories)): ?>
    <div class="mb-4">
        <div class="card shadow rounded-4 p-0" style="max-height: 200px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="text-warning mb-0"><?= htmlspecialchars($_SESSION["user"]["full_name"] ?? 'Không xác định')?> đã xem</h5>
                    <form action="/clear_history/<?php echo $_SESSION["user"]["id"]; ?>" method="POST">
                        <button type="submit" class="btn btn-sm btn-danger">Xoá tất cả</button>
                    </form>
                </div>
                <div class="d-flex flex-row flex-nowrap overflow-auto py-1">
                    <?php foreach ($histories as $history): ?>
                        <div class="p-2 rounded-3 shadow-sm d-flex align-items-center position-relative mx-2 bg-white"
                            style="width: 280px; flex-shrink: 0; border: 1px solid rgba(0, 0, 0, 0.1);">

                            <a href="/car_detail/<?= htmlspecialchars($history['car_id']) ?>">
                                <img src="<?= htmlspecialchars($history['image_url'] ?? '/uploads/cars/default.jpg') ?>"
                                    alt="<?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>"
                                    class="rounded-2 me-2" style="width: 90px; height: 80px; object-fit: cover;">
                            </a>

                            <div class="flex-grow-1 d-flex flex-column justify-content-between" style="padding-right: 30px; min-height: 80px;">
                                <a href="car_detail/<?= htmlspecialchars($history['car_id'] ?? '') ?>"
                                    class="text-dark fw-bold text-decoration-none d-block">
                                    <?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>
                                </a>
                                <strong class="fw-semibold <?= ($history['stock'] ?? 0) > 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= ($history['stock'] ?? 0) > 0 ? 'Còn hàng' : 'Hết hàng' ?>
                                </strong>
                            </div>

                            <a href="/remove_history/<?= htmlspecialchars($history['hvc_id'] ?? '') ?>"
                                class="position-absolute d-flex align-items-center justify-content-center"
                                style="top: 15px; right: 15px; width: 24px; height: 24px; border-radius: 50%; 
                                    background: rgba(0,0,0,0.1); color: black; text-decoration: none;
                                    transform: translate(50%, -50%);"
                                onmouseover="this.style.background='rgba(0,0,0,0.2)'"
                                onmouseout="this.style.background='rgba(0,0,0,0.1)'">
                                &times;
                            </a>

                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>