<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-4 bg-light rounded-4 shadow p-4 border">
        <h3>So sánh xe</h3>
        <div class="row mb-3">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="col-md-4">
                    <select class="form-select compare-select" data-index="<?= $i ?>">
                        <option value="">-- Chọn xe <?= $i ?> --</option>
                        <?php foreach ($cars as $car): ?>
                            <?php
                            $selected = ($i === 1 && isset($_POST['car_id']) && $_POST['car_id'] == $car['id']) ? 'selected' : '';
                            ?>
                            <option value="<?= $car['id'] ?>" <?= $selected ?>><?= $car['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endfor; ?>
        </div>
        <div id="compare-result"></div>
        <div class="text-center mt-4">
            <a href="/home" class="btn btn-primary"><i class="fa fa-home"></i> Quay lại</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>