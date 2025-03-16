<?php
require '/ProjectCarSale/config/database.php';
if (!isset($_SESSION['user'])) {
    header("Location: login");
    exit();
}

try {
    $stmt = $conn->query("
    SELECT cars.*, 
           brands.name AS brand_name, 
           categories.name AS category_name,
           (SELECT image_url FROM car_images WHERE car_images.car_id = cars.id AND image_type = 'normal') AS image_url
    FROM cars
    LEFT JOIN brands ON cars.brand_id = brands.id
    LEFT JOIN categories ON cars.category_id = categories.id
");
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt_users = $conn->query("SELECT * FROM users");
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

    $stmt_favorites = $conn->query("
        SELECT favorites.id, users.full_name AS user_name, cars.name AS car_name, favorites.created_at
        FROM favorites
        JOIN users ON favorites.user_id = users.id
        JOIN cars ON favorites.car_id = cars.id
    ");
    $favorites = $stmt_favorites->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        main {
            padding: 20px;
        }

        section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="#cars">Manage Cars</a></li>
                <li><a href="#users">Manage Users</a></li>
                <li><a href="#favorites">Manage Favorites</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
            <?php echo "Xin chào, " . $_SESSION['user']['full_name']; ?>
        </nav>
    </header>
    <main>
        <section id="dashboard">
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Here you can manage cars, users, and settings.</p>
        </section>

        <section id="cars">
            <h2>Manage Cars</h2>
            <a href="/add_car" class="btn btn-primary">Add New Car</a>
            <table>
                <thead>
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
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td><?= htmlspecialchars($car['id'] ?? 0) ?></td>
                            <td><?= htmlspecialchars($car['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($car['brand_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($car['category_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($car['year'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($car['color'] ?? 'N/A') ?></td>
                            <td><?= number_format($car['price'] ?? 0) ?> VND</td>
                            <td><?= htmlspecialchars($car['transmission'] ?? 'N/A') ?></td>
                            <td><?= number_format($car['mileage'] ?? 0) ?> km</td>
                            <td><?= htmlspecialchars($car['fuel_type'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($car['stock'] ?? 'N/A') ?></td>
                            <td>
                                <?php if (!empty($car['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($car['image_url']) ?>" alt="<?= htmlspecialchars($car['name'] ?? 'Car Image') ?>" width="100">
                                <?php else: ?>
                                    <span>No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= nl2br(htmlspecialchars($car['description'] ?? '')) ?></td>
                            <td>
                                <a href="/edit/<?= htmlspecialchars($car['id'] ?? 0) ?>" class="btn btn-primary">Edit</a>
                                <a href="/delete_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" onclick="return confirm('Are you sure you want to delete this car?');" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section id="users">
            <h2>Manage Users</h2>
            <table>
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['full_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td><?php echo $user['address']; ?></td>
                            <td>
                                <?php
                                if ($user['role'] == 'admin') {
                                    echo 'Quản trị viên';
                                } elseif ($user['role'] == 'customer') {
                                    echo 'Người dùng';
                                } else {
                                    echo 'Khác';
                                }
                                ?>
                            </td>
                            <td><?php echo $user['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section id="favorites">
            <h2>Manage Favorites</h2>
            <table>
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Xe</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($favorites as $favorite): ?>
                        <tr>
                            <td><?php echo $favorite['id']; ?></td>
                            <td><?php echo $favorite['user_name']; ?></td>
                            <td><?php echo $favorite['car_name']; ?></td>
                            <td><?php echo $favorite['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <?php include '/ProjectCarSale/includes/footer.php'; ?>
</body>

</html>