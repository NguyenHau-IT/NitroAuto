<?php if (!empty($histories)): ?>
    <div class="container mb-3">
        <div class="card shadow-sm" style="max-height: 250px; overflow-y: auto;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center w-100 mt-1">
                    <h5 class="text-warning mb-0">Xe đã xem</h5>
                    <form action="/clear_history/<?php echo $_SESSION["user"]["id"]; ?>" method="POST">
                        <button type="submit" class="btn btn-sm btn-danger">Xoá tất cả</button>
                    </form>
                </div>
                <div class="d-flex flex-row flex-nowrap overflow-auto py-1">
                    <?php foreach ($histories as $history): ?>
                        <div class="p-1 rounded shadow-sm d-flex align-items-center position-relative mx-2"
                            style="width: 250px; flex-shrink: 0; border: 0.5px solid rgba(0, 0, 0, 0.1);">
                            <img src="<?= htmlspecialchars($history['image_url'] ?? '/uploads/cars/default.jpg') ?>"
                                alt="<?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>"
                                style="width: 75px; height: 75px; object-fit: cover; border-radius: 5px; margin-right: 5px;">
                            <h6 class="mb-0 flex-grow-1">
                                <a href="car_detail/<?= htmlspecialchars($history['car_id'] ?? '') ?>"
                                    class="text-left text-dark font-weight-bold">
                                    <?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>
                                </a>
                            </h6>
                            <a href="/remove_history/<?= htmlspecialchars($history['hvc_id'] ?? '') ?>"
                                class="close position-absolute" style="top: 3px; right: 3px; background: none;" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>