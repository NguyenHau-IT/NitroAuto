<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-car-side me-2 text-primary"></i> Manage Cars
    </h2>
    <a href="/add_car" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus-circle me-1"></i> Add New Car
    </a>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Thương hiệu</th>
                <th>Danh mục</th>
                <th>Năm</th>
                <th>Màu sắc</th>
                <th>Giá</th>
                <th>Hộp số</th>
                <th>Số km</th>
                <th>Loại nhiên liệu</th>
                <th>Tồn kho</th>
                <th>Hình ảnh</th>
                <th>Hình ảnh 3D</th>
                <th style="width: 400px;">Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= htmlspecialchars($car['id'] ?? 0) ?></td>
                    <td class="text-start"><?= htmlspecialchars($car['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($car['brand_name'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($car['category_name'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($car['year'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($car['color'] ?? 'N/A') ?></td>
                    <td class="text-end"><?= number_format($car['price'] ?? 0) ?> VND</td>
                    <td><?= htmlspecialchars($car['transmission'] ?? 'N/A') ?></td>
                    <td class="text-end"><?= number_format($car['mileage'] ?? 0) ?> km</td>
                    <td><?= htmlspecialchars($car['fuel_type'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($car['stock'] ?? 'N/A') ?></td>

                    <td>
                        <?php if (!empty($car['image_url'])): ?>
                            <img src="<?= htmlspecialchars($car['image_url']) ?>"
                                alt="Car image"
                                class="img-thumbnail"
                                style="max-width: 150px; max-height: 100px;">
                        <?php else: ?>
                            <span class="text-muted">No image</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if (!empty($car['image_3d_url'])): ?>
                            <iframe src="<?= htmlspecialchars($car['image_3d_url']) ?>" title="3D View"
                                width="400" height="300"
                                style="border: none; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);"></iframe>
                        <?php else: ?>
                            <span class="text-muted">No 3D</span>
                        <?php endif; ?>
                    </td>

                    <td class="text-start" style="min-width: 600px;">
                        <div class="bg-light rounded p-2" style="max-height: 200px; overflow-y: auto; white-space: pre-wrap;">
                            <?= nl2br(htmlspecialchars($car['description'] ?? '')) ?>
                        </div>
                    </td>

                    <td>
                        <a href="/edit_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="/delete_car/<?= htmlspecialchars($car['id'] ?? 0) ?>"
                            onclick="return confirm('Are you sure you want to delete this car?');"
                            class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>