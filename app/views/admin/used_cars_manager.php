<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary m-0"><i class="bi bi-car-front-fill"></i> Quản lý Xe Đã Qua Sử Dụng</h3>
        <a href="/add_used_car" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Thêm Xe Mới
        </a>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Người đăng</th>
                    <th>Ảnh</th>
                    <th>Tên xe</th>
                    <th>Hãng</th>
                    <th>Danh mục</th>
                    <th>Năm</th>
                    <th>Km đã đi</th>
                    <th>Màu</th>
                    <th>Hộp số</th>
                    <th>Giá</th>
                    <th>Nhiên liệu</th>
                    <th>Ngày tạo</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usedCars as $car): ?>
                    <tr>
                        <td><?= htmlspecialchars($car['user_name']) ?></td>
                        <td>
                            <img src="<?= !empty($car['image_url']) ? $car['image_url'] : '/assets/images/no-image.png' ?>"
                                alt="Ảnh xe" width="100" height="60" class="img-thumbnail">
                        </td>
                        <td><?= htmlspecialchars($car['name']) ?></td>
                        <td><?= htmlspecialchars($car['brand']) ?></td>
                        <td><?= htmlspecialchars($car['category_name']) ?></td>
                        <td><?= $car['year'] ?></td>
                        <td><?= $car['mileage'] ?> km</td>
                        <td><?= htmlspecialchars($car['color']) ?></td>
                        <td><?= htmlspecialchars($car['transmission']) ?></td>
                        <td class="text-end"><?= number_format($car['price'], 0, ',', '.') ?> đ</td>
                        <td><?= htmlspecialchars($car['fuel_type']) ?></td>
                        <td><?= date('d/m/Y', strtotime($car['created_at'])) ?></td>
                        <td class="text-start align-top">
                            <div class="overflow-auto bg-light p-2 rounded" style="max-height: 100px; min-width: 200px; white-space: pre-wrap;">
                                <?= nl2br(htmlspecialchars($car['description'])) ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $status = strtolower($car['status']);
                            $badgeClass = 'light';
                            $statusLabel = 'Không xác định';

                            switch ($status) {
                                case 'approved':
                                    $badgeClass = 'success';
                                    $statusLabel = 'Đã duyệt';
                                    break;
                                case 'pending':
                                    $badgeClass = 'warning';
                                    $statusLabel = 'Đang xử lý';
                                    break;
                                case 'rejected':
                                    $badgeClass = 'danger';
                                    $statusLabel = 'Đã từ chối';
                                    break;
                                case 'sold':
                                    $badgeClass = 'secondary';
                                    $statusLabel = 'Đã bán';
                                    break;
                            }
                            ?>
                            <span class="badge bg-<?= $badgeClass ?>"><?= $statusLabel ?></span>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <a href="/edit_used_car/<?= $car['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="/admin/used_cars/delete/<?= $car['id'] ?>"
                                    onclick="return confirm('Xác nhận xoá bài đăng này?');"
                                    class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Xoá
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Empty table notice -->
        <?php if (empty($usedCars)): ?>
            <div class="alert alert-warning text-center mt-4">
                Không có xe nào được tìm thấy.
            </div>
        <?php endif; ?>
    </div>
</div>