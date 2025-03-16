<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

    <style>
        body {
            background-image: url('/uploads/bg.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            font-size: 18px;
        }

        .overlay {
            border-radius: 50px;
            background: rgba(0, 0, 0, 0.7);
            padding: 50px 20px;
            margin-top: 50px;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>

    <div class="container mt-5">
        <div class="overlay">
            <h1 class="mb-4 text-white">Danh sách yêu thích của <?= htmlspecialchars($user['full_name']) ?></h1>
            <div class="table-container">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên Xe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($favorites as $favorite): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($favorite['id']); ?></td>
                                <td><?php echo htmlspecialchars($favorite['car_name']); ?></td>
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