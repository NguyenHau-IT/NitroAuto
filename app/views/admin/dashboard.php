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
               (SELECT image_url FROM car_images WHERE car_images.car_id = cars.id AND image_type = 'normal') AS image_url,
               (SELECT image_url FROM car_images WHERE car_images.car_id = cars.id AND image_type = '3d') AS image_3d_url
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

    $stmt_orders = $conn->query("
        SELECT orders.*, users.full_name AS user_name, cars.name AS car_name, order_details.quantity, order_details.price
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN order_details ON orders.id = order_details.order_id
        JOIN cars ON order_details.car_id = cars.id
    ");
    $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

    $stmt_brands = $conn->query("SELECT * FROM brands");
    $brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);

    $stmt_categories = $conn->query("SELECT * FROM categories");
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    $stmt_payments = $conn->query("SELECT * FROM payments");
    $payments = $stmt_payments->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <header class="bg-dark text-white text-center py-3">
        <h1>Admin Dashboard</h1>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="/home"><i class="fas fa-home d-block"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin"><i class="fas fa-tachometer-alt d-block"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cars"><i class="fas fa-car d-block"></i> Manage Cars</a></li>
                    <li class="nav-item"><a class="nav-link" href="#users"><i class="fas fa-users d-block"></i> Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="#favorites"><i class="fas fa-heart d-block"></i> Manage Favorites</a></li>
                    <li class="nav-item"><a class="nav-link" href="#orders"><i class="fas fa-shopping-cart d-block"></i> Manage Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-cog d-block"></i> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt d-block"></i> Logout</a></li>
                </ul>
                <span class="navbar-text">
                    <?php echo "Xin chào, " . $_SESSION['user']['full_name']; ?>
                </span>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
        <section id="dashboard">
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Here you can manage cars, users, and settings.</p>
        </section>

        <section id="cars" class="mt-5">
            <h2>Manage Cars</h2>
            <a href="/add_car" class="btn btn-primary mb-3">Add New Car</a>
            <div style="max-height: 600px; overflow-y: auto;">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark" style="position: sticky; top: 0; z-index: 1;">
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
                            <th>Hình ảnh 3D</th>
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
                                        <img src="<?= htmlspecialchars($car['image_url']) ?>" alt="<?= htmlspecialchars($car['name'] ?? 'Car Image') ?>" class="img-fluid" width="100">
                                    <?php else: ?>
                                        <span>No image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($car['image_3d_url'])): ?>
                                        <iframe src="<?= htmlspecialchars($car['image_3d_url']) ?>" alt="<?= htmlspecialchars($car['name'] ?? 'Car 3D Image') ?>" class="img-fluid" width="100"></iframe>
                                    <?php else: ?>
                                        <span>No 3D image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= nl2br(htmlspecialchars($car['description'] ?? '')) ?></td>
                                <td>
                                    <a href="/edit_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" class="btn btn-primary btn-sm mb-5">Edit</a>
                                    <a href="/delete_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" onclick="return confirm('Are you sure you want to delete this car?');" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="brands" class="mt-5">
            <h2>Manage Brands</h2>
            <a href="/add_brand" class="btn btn-primary mb-3">Add New Brand</a>
            <div style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark text-center" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($brands as $brand): ?>
                            <tr>
                                <td><?= htmlspecialchars($brand['id'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($brand['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($brand['country'] ?? '') ?></td>
                                <td>
                                    <?php if (!empty($brand['logo'])): ?>
                                        <img src="<?= htmlspecialchars($brand['logo']) ?>" alt="<?= htmlspecialchars($brand['name'] ?? 'Brand Logo') ?>" class="img-fluid" width="100">
                                    <?php else: ?>
                                        <span>No logo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/edit_brand/<?= htmlspecialchars($brand['id'] ?? 0) ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="/delete_brand/<?= htmlspecialchars($brand['id'] ?? 0) ?>" onclick="return confirm('Are you sure you want to delete this brand?');" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="users" class="mt-5">
            <h2>Manage Users</h2>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
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

        <section id="favorites" class="mt-5">
            <h2>Manage Favorites</h2>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
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

        <section id="orders" class="mt-5">
            <h2>Manage Orders</h2>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Xe</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['user_name']; ?></td>
                            <td><?php echo $order['car_name']; ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo number_format($order['price']); ?> VND</td>
                            <td><?php echo $order['order_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        
        <section id="payments" class="mt-5">
            <h2>Manage Payments</h2>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Đơn hàng</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo $payment['id']; ?></td>
                            <td><?php echo $payment['order_id']; ?></td>
                            <td><?php echo number_format($payment['amount']); ?> VND</td>
                            <td><?php echo $payment['method']; ?></td>
                            <td><?php echo $payment['status']; ?></td>
                            <td><?php echo $payment['payment_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <?php include '/ProjectCarSale/includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>