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
                                <p class="card-text" style="height: 70px; overflow: hidden; text-overflow: ellipsis;"><i class="fas fa-info-circle"></i> Mô tả: <?= htmlspecialchars($car['description']) ?></p>

                                <div class="favorite-btn">
                                    <form action="/add_favorite" method="POST">
                                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-heart"></i> Yêu thích</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: yellow;">⚠️ Hiện tại không có xe của hãng này.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
    body {
        background-image: url('/uploads/bg.webp');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: Arial, sans-serif;
        color: #fff;
    }

    .overlay {
        background: rgba(0, 0, 0, 0.7);
        min-height: 100vh;
        padding: 50px 20px;
    }

    .car-card {
        transition: 0.3s;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.2);
    }

    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 12px rgba(255, 255, 255, 0.3);
    }

    .car-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .car-card .card-body {
        background: #222;
        padding: 15px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .btn-warning {
        width: 100%;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-warning:hover {
        background: #ffcc00;
        color: #222;
    }
</style>
<script>
    function redirectToBrand(event) {
        event.preventDefault();
        var brandId = document.getElementById('brand-select').value;
        if (brandId) {
            window.location.href = '/car_find/' + brandId;
        }
    }
</script>