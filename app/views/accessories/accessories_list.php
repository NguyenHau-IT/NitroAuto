<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<div class="overlay">
    <div class="container mt-5 mb-5 bg-light rounded-4 shadow-lg p-4">
        <h1 class="mb-4 text-center">Danh sách phụ kiện cho xe</h1>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Tên phụ kiện</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="text-white">
                <?php foreach ($accessories as $accessory): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($accessory['name']); ?></td>
                        <td><?php echo number_format($accessory['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td><?php echo htmlspecialchars($accessory['description']); ?></td>
                        <td>
                            <a href="/add_to_cart/<?php echo $accessory['id']; ?>" class="btn btn-success">Thêm vào giỏ hàng</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-end">
            <a href="/home" class="btn btn-danger   " style="align-content: center; margin-left: 10px;">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/style.css">
<script src="/script.js"></script>