<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<div class="overlay">
    <h2>So sánh xe</h2>

    <div class="row" id="car-slots">
        <?php for ($i = 0; $i < 3; $i++): ?>
            <div class="col-md-4 mb-3">
                <select class="form-select car-select" data-slot="<?= $i ?>">
                    <option value="">-- Chọn xe <?= $i + 1 ?> --</option>
                    <?php foreach ($allCars as $car): ?>
                        <option value="<?= $car['id'] ?>"><?= $car['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endfor; ?>
    </div>

    <div id="compare-result" class="mt-4"></div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>