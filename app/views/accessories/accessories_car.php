<div class="container my-5">
    <h2 class="text-center mb-4">
        <i class="bi bi-tools"></i> Phụ kiện dành cho xe
    </h2>

    <div class="d-flex overflow-auto gap-3 py-2 px-1">
        <?php foreach ($accessories as $item): ?>
            <div class="card flex-shrink-0 shadow-sm rounded-4" style="min-width: 250px; max-width: 250px;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                    <p class="card-text text-muted small">
                        <?php echo htmlspecialchars(mb_strimwidth($item['description'], 0, 60, '...')); ?>
                    </p>
                    <p class="fw-bold text-primary">
                        <?php echo number_format($item['price'], 0, ',', '.') . ' VNĐ'; ?>
                    </p>
                    <div class="mt-auto">
                        <a href="/add_to_cart/<?php echo $item['id']; ?>" class="btn btn-success btn-sm w-100">
                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>