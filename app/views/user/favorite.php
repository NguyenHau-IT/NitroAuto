<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<link rel="stylesheet" href="/style.css">
<div class="overlay">
    <div class="container text-dark fs-5 mb-4 bg-light shadow rounded-4 p-4">
        <h1 class="mb-4 ">Danh sách yêu thích của <?= htmlspecialchars($user['full_name']) ?></h1>
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
                                <a href="/favarite_delete/<?php echo $favorite['id']; ?>" class="btn btn-danger">Xóa</a>
                                <a href="/car_detail/<?php echo $favorite['car_id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                                <form action="/showOrderForm" method="POST" style="display:inline;">
                                    <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($favorite['car_id']); ?>">
                                    <button type="submit" class="btn btn-success">Đặt mua</button>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">