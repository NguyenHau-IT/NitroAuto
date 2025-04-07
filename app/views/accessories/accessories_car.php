<div class="mt-4 bg-info rounded-4 shadow p-4 border">
    <h2 class="text-center mb-4 text-primary-emphasis fw-bold">
        <i class="bi bi-tools"></i> Phụ kiện dành cho xe
    </h2>

    <?php if (empty($accessories)): ?>
        <div class="alert alert-warning text-center" role="alert">
            ⚠️ Không tìm thấy phụ kiện nào phù hợp với tiêu chí tìm kiếm của bạn.
        </div>
    <?php else: ?>
        <div class="d-flex overflow-auto gap-3 px-2 py-3" style="scroll-snap-type: x mandatory;">
            <?php foreach ($accessories as $item): ?>
                <div class="card flex-shrink-0 shadow rounded-4" style="min-width: 250px; scroll-snap-align: start;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-dark"><?= htmlspecialchars($item['name']) ?></h5>
                        <p class="card-text text-muted small">
                            <?= htmlspecialchars(mb_strimwidth($item['description'], 0, 60, '...')) ?>
                        </p>
                        <p class="fw-bold text-primary">
                            <?= number_format($item['price'], 0, ',', '.') ?> VNĐ
                        </p>
                        <div class="mt-auto">
                            <a href="/add_to_cart/<?= $item['id'] ?>" class="btn btn-success btn-sm w-100">
                                <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>