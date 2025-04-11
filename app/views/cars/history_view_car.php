<?php if (!empty($histories)): ?>
    <div class="mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-warning mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        <?= htmlspecialchars($_SESSION["user"]["full_name"] ?? 'Không xác định') ?> đã xem
                    </h5>
                    <form action="/clear_history/<?= $_SESSION["user"]["id"] ?>" method="POST" class="m-0">
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash3-fill me-1"></i> Xoá tất cả
                        </button>
                    </form>
                </div>

                <!-- Danh sách cuộn ngang -->
                <div class="d-flex flex-nowrap overflow-auto gap-3 pb-2">
                    <?php foreach ($histories as $history): ?>
                        <div class="card flex-shrink-0 border-0 shadow-sm" style="width: 260px; min-width: 260px;">
                            <div class="position-relative">
                                <a href="/car_detail/<?= htmlspecialchars($history['car_id']) ?>">
                                    <img src="<?= htmlspecialchars($history['image_url'] ?? '/uploads/cars/default.jpg') ?>"
                                         alt="<?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>"
                                         class="card-img-top rounded-top" style="height: 140px; object-fit: cover;" loading="lazy">
                                </a>

                                <!-- Nút xoá -->
                                <a href="/remove_history/<?= htmlspecialchars($history['hvc_id'] ?? '') ?>"
                                   class="btn-close position-absolute top-0 end-0 m-2"
                                   aria-label="Xoá"
                                   style="background-color: rgba(255,255,255,0.7);">
                                </a>
                            </div>

                            <div class="card-body p-3">
                                <h6 class="card-title text-truncate mb-1">
                                    <a href="/car_detail/<?= htmlspecialchars($history['car_id']) ?>"
                                       class="text-decoration-none text-dark fw-semibold">
                                        <?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>
                                    </a>
                                </h6>
                                <p class="mb-0">
                                    <span class="badge <?= ($history['stock'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= ($history['stock'] ?? 0) > 0 ? 'Còn hàng' : 'Hết hàng' ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>