<?php
$min_price = min(array_column($cars, 'price'));
$max_hp = max(array_column($cars, 'horsepower'));
$min_mileage = min(array_column($cars, 'mileage'));
$max_year = max(array_column($cars, 'year'));
?>

<table class="table table-bordered text-center table-compare">
    <thead class="table-dark">
        <tr>
            <th style="width: 100px;">Thông số</th>
            <?php foreach ($cars as $car): ?>
                <th style="width: 250px;"><?= $car['name'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Hình ảnh</td>
            <?php foreach ($cars as $car): ?>
                <td><img src="<?= $car['normal_image_url'] ?? '/uploads/cars/default.jpg' ?>" width="200"></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Hãng</td>
            <?php foreach ($cars as $car): ?>
                <td><?= $car['brand_name'] ?? 'Chưa có' ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Giá</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['price'] == $min_price ? 'fw-bold text-success' : '' ?>">
                    <?= number_format($car['price'], 0, ',', '.') ?> đ
                </td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Năm sản xuất</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['year'] == $max_year ? 'fw-bold text-primary' : '' ?>">
                    <?= $car['year'] ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Số km đã đi</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['mileage'] == $min_mileage ? 'fw-bold text-success' : '' ?>">
                    <?= number_format($car['mileage']) ?> km
                </td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Mã lực</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['horsepower'] == $max_hp ? 'fw-bold text-danger' : '' ?>">
                    <?= $car['horsepower'] ?> HP
                </td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Nhiên liệu</td>
            <?php foreach ($cars as $car): ?>
                <td><?= $car['fuel_type'] ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Hộp số</td>
            <?php foreach ($cars as $car): ?>
                <td><?= $car['transmission'] ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Màu sắc</td>
            <?php foreach ($cars as $car): ?>
                <td><?= $car['color'] ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Tình trạng kho</td>
            <?php foreach ($cars as $car): ?>
                <td><?= $car['stock'] > 0 ? 'Còn hàng' : 'Hết hàng' ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Mô tả</td>
            <?php foreach ($cars as $car): ?>
                <td><?= mb_strimwidth(strip_tags($car['description']), 0, 100, "...") ?></td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>
