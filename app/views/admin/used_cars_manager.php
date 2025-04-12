<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">Quản lý Xe Đã Qua Sử Dụng</h3>
        <a href="/admin/used_cars/add" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Thêm Xe Mới
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Người Đăng</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Tên xe</th>
                    <th scope="col">Hãng</th>
                    <th scope="col">Danh mục</th>
                    <th scope="col">Năm</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Nhiên liệu</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
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
                        <td class="text-end"><?= number_format($car['price'], 0, ',', '.') ?> đ</td>
                        <td><?= $car['fuel_type'] ?></td>
                        <td><?= date('d/m/Y', strtotime($car['created_at'])) ?></td>
                        <td>
                            <?php
                            $status = strtolower($car['status']);
                            $badgeClass = 'light';
                            $statusLabel = 'Không xác định';

                            switch ($status) {
                                case 'approved':
                                    $badgeClass = 'success';      // Xanh lá
                                    $statusLabel = 'Đã duyệt';
                                    break;
                                case 'pending':
                                    $badgeClass = 'warning';      // Vàng
                                    $statusLabel = 'Đang xử lý';
                                    break;
                                case 'rejected':
                                    $badgeClass = 'danger';       // Đỏ
                                    $statusLabel = 'Đã từ chối';
                                    break;
                                case 'sold':
                                    $badgeClass = 'secondary';    // Xám
                                    $statusLabel = 'Đã bán';
                                    break;
                            }
                            ?>
                            <span class="badge bg-<?= $badgeClass ?> text-white"><?= $statusLabel ?></span>
                        </td>
                        <td>
                            <div class="d-grid gap-2 d-md-block">
                                <a href="/admin/used_cars/edit/<?= $car['id'] ?>" class="btn btn-warning btn-sm mb-1">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="/admin/used_cars/delete/<?= $car['id'] ?>"
                                    onclick="return confirm('Xác nhận xoá bài đăng này?');"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Xoá
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (empty($usedCars)): ?>
            <div class="alert alert-warning text-center mt-4">
                Không có xe nào được tìm thấy.
            </div>
        <?php endif; ?>
    </div>
</div>