<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

    .container {
        max-width: 600px;
        margin: auto;
    }

    .form-group label {
        font-weight: bold;
        font-size: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 25px;
        padding: 10px 20px;
        font-size: 18px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>

<div class="container mt-5 overlay text-white fs-5 mb-4">
    <h2 class="mb-4 text-center">Đăng ký lái thử</h2>

    <div class="mb-3 fs-3">
        <h4>Thông tin người đăng ký</h4>
        <p><strong>Tên:</strong> <?= isset($user['full_name']) ? htmlspecialchars($user['full_name']) : 'N/A' ?></p>
        <p><strong>Email:</strong> <?= isset($user['email']) ? htmlspecialchars($user['email']) : 'N/A' ?></p>
        <p><strong>Số điện thoại:</strong> <?= isset($user['phone']) ? htmlspecialchars($user['phone']) : 'N/A' ?></p>
        <p><strong>Địa chỉ:</strong> <?= isset($user['address']) ? htmlspecialchars($user['address']) : 'N/A' ?></p>
    </div>

    <form action="/register_test_drive" method="POST">
        <input type="hidden" name="user_id" value="<?= isset($user['id']) ? htmlspecialchars($user['id']) : '' ?>">

        <div class="form-group">
            <label for="car_id">Chọn xe:</label>
            <select class="form-control" id="car_id" name="car_id" onchange="updatePrice()">
                <option value="">Chọn xe</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= htmlspecialchars($car['id']) ?>" data-price="<?= htmlspecialchars($car['price']) ?>" data-name="<?= htmlspecialchars($car['name']) ?>"
                        <?= isset($_POST['car_id']) && $_POST['car_id'] == $car['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($car['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="preferred_date">Ngày lái thử:</label>
            <input type="date" class="form-control" id="preferred_date" name="preferred_date" required>
        </div>

        <div class="form-group">
            <label for="preferred_time">Giờ lái thử:</label>
            <input type="time" class="form-control" id="preferred_time" name="preferred_time" required>
        </div>

        <div class="form-group">
            <label for="location">Địa điểm lái thử:</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <button type="submit" class="btn btn-primary">Đăng ký lái thử</button>
        <a href="/home" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
