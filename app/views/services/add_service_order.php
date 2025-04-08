<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<div class="overlay">
    <div class="container mt-5">
        <div class="bg-white shadow-lg rounded-4 p-5">
            <h2 class="text-center mb-4 fw-bold text-primary">Đặt dịch vụ ô tô</h2>

            <form action="/service_order_add" method="POST">
                <div class="mb-4">
                    <label for="service_id" class="form-label fw-semibold">Chọn dịch vụ</label>
                    <select name="service_id" id="service_id" class="form-select form-select-lg rounded-3" required>
                        <option value="">-- Chọn dịch vụ --</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= $service['ServiceID'] ?>">
                                <?= htmlspecialchars($service['ServiceName']) ?> (<?= number_format($service['Price'], 0, ',', '.') ?> đ)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <div class="mb-4">
                    <label for="service_date" class="form-label fw-semibold">Chọn ngày</label>
                    <input type="datetime-local" name="service_date" id="service_date" class="form-control rounded-3" required>
                </div>

                <div class="mb-4">
                    <label for="note" class="form-label fw-semibold">Ghi chú (tùy chọn)</label>
                    <textarea name="note" id="note" class="form-control rounded-3" rows="4" placeholder="Thời gian mong muốn, yêu cầu thêm,..."></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/services" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                        <i class="fas fa-arrow-left me-2"></i>Huỷ
                    </a>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-3">
                        <i class="fas fa-check-circle me-2"></i>Đặt dịch vụ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>