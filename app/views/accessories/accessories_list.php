<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<link rel="stylesheet" href="/style.css">
<div class="container mt-5 overlay mb-5">
    <h1 class="mb-4 text-center text-white">Accessories List</h1>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Tên phụ kiện</th>
                <th>Giá</th>
                <th>Mô tả</th>
            </tr>
        </thead>
        <tbody class="text-white">
            <?php foreach ($accessories as $accessory): ?>
                <tr>
                    <td><?php echo htmlspecialchars($accessory['name']); ?></td>
                    <td><?php echo htmlspecialchars($accessory['price']); ?></td>
                    <td><?php echo htmlspecialchars($accessory['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/script.js"></script>
