<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="/style.css">
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="mt-4 bg-light rounded-4 shadow-lg p-4 border">
    <div class="container mt-2">
        <h2 class="mb-4">Danh sách xe đã qua sử dụng</h2>
        <div class="row">
            <?php foreach ($used_cars as $car): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars(!empty($car["image_url"]) ? $car["image_url"] : '/uploads/cars/default.jpg') ?>"
                            class="card-img-top car-image"
                            alt="<?= htmlspecialchars($car['name']) ?>"
                            style="height: 200px; object-fit: cover; transition: transform 0.3s ease-in-out;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($car['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($car['brand']) ?> - <?= number_format($car['price']) ?> VNĐ</p>
                            <p class="card-text"><?= htmlspecialchars($car['description']) ?></p>
                            <p class="card-text"><small class="text-muted">Ngày đăng: <?= date('d/m/Y', strtotime($car['created_at'])) ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>