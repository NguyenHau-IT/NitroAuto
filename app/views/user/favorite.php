<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<link rel="stylesheet" href="/style.css">
<div class="overlay">
    <div class="container text-dark mb-4 bg-light shadow rounded-4 p-4">
        <h1 class="mb-4 text-center">Danh sách yêu thích của <?= htmlspecialchars($user['full_name']) ?></h1>
        <div class="table-container">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên Xe</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($favorites as $favorite): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($favorite['id']); ?></td>
                            <td><?php echo htmlspecialchars($favorite['car_name']); ?></td>
                            <td>
                                <a href="/favarite_delete/<?php echo $favorite['id']; ?>" class="btn btn-danger btn-sm mr-2">Xóa</a>
                                <a href="/car_detail/<?php echo $favorite['car_id']; ?>" class="btn btn-primary btn-sm mr-2">Xem chi tiết</a>
                                <form action="/showOrderForm" method="POST" style="display:inline;">
                                    <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($favorite['car_id']); ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Đặt mua</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
