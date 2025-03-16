<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<style>
    body {
        background-image: url('uploads/bg.webp');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: Arial, sans-serif;
        color: #fff;
    }

    .overlay {
        border-radius: 50px;
        background: rgba(0, 0, 0, 0.7);
        padding: 50px 20px;
    }
</style>
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