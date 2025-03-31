<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<div class="overlay">
    <div class="container text-center">
        <h1 class="mb-5" style="color: #ffcc00;">Nitro Auto</h1>

        <form action="" method="GET" class="mb-4" onsubmit="redirectToBrand(event)">
            <div class="input-group">
                <select class="form-control" id="brand-select">
                    <option value="">Chọn hãng xe...</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= htmlspecialchars($brand['id']) ?>"><?= htmlspecialchars($brand['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-warning" type="submit">Tìm kiếm</button>
                </div>
            </div>
        </form>

        <div class="row" id="car-list">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card car-card">
                            <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" style="height: 200px;">
                                <img src="<?= htmlspecialchars(!empty($car["normal_image_url"]) ? $car["normal_image_url"] : '/uploads/cars/default.jpg') ?>"
                                    class="card-img-top car-image"
                                    alt="<?= htmlspecialchars($car['name']) ?>">
                            </a>
                            <div class="card-body text-white">
                                <h5 class="card-title"><a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" style="color: #fff;"><?= htmlspecialchars($car['name']) ?></a></h5>
                                <p class="card-text"><i class="fas fa-money-bill-wave"></i> Giá: <strong><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</strong></p>
                                <p class="card-text"><i class="fas fa-gas-pump"></i> Nhiên liệu: <?= htmlspecialchars($car['fuel_type']) ?></p>
                                <div class="favorite-btn mt-3">
                                    <form action="/add_favorite" method="POST">
                                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-heart"></i> Yêu thích</button>
                                    </form>
                                    <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="btn btn-outline-light btn-block mt-2"><i class="fas fa-info-circle"></i> Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Hiện tại không có xe của hãng này.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="/style.css">
<script>
    function redirectToBrand(event) {
        event.preventDefault();
        var brandId = document.getElementById('brand-select').value;
        if (brandId) {
            window.location.href = '/car_find/' + brandId;
        }
    }
</script>