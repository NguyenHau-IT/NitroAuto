<?php
require '../config/database.php';
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

    $stmt_test_drives = $conn->query("
        SELECT TestDriveRegistration.*, users.full_name AS user_name, cars.name AS car_name
        FROM TestDriveRegistration
        JOIN users ON TestDriveRegistration.user_id = users.id
        JOIN cars ON TestDriveRegistration.car_id = cars.id
    ");
    $test_drives = $stmt_test_drives->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background-image: url('uploads/logo.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.7);
            min-height: 100vh;

        }
    </style>
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Admin Dashboard</h1>
            <div>
                <a class="nav-link d-inline text-white ml-3" href="/home"><i class="fas fa-home"></i> Home</a>
                <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['full_name']); ?></span>
            </div>
        </div>
    </header>
    <div class="d-flex overlay text-light">
        <nav class="bg-dark text-white p-3" style="min-width:100px; position: sticky; top: 0; height: 100%;">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#cars"><i class="fas fa-car"></i> Manage Cars</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#brands"><i class="fas fa-building"></i> Manage Brands</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#categories"><i class="fas fa-list"></i> Manage Categories</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#users"><i class="fas fa-users"></i> Manage Users</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#favorites"><i class="fas fa-heart"></i> Manage Favorites</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#orders"><i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#test_drives"><i class="fas fa-car"></i> Manage Test Drives</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
        <main class="container mt-4 flex-grow-1">

            <section id="dashboard" class="text-white">
                <h2>Welcome to the Admin Dashboard</h2>
                <p>Here you can manage cars, users, and settings.</p>
            </section>

            <section id="cars" style="display: none;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Cars</h2>
                    <a href="/add_car" class="btn btn-primary">Add New Car</a>
                </div>
                <div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
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
                                <th style="width: 400px;">Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($car['id'] ?? 0) ?></td>
                                    <td class="text-truncate" style="max-width: 300px;">
                                        <?= htmlspecialchars($car['name'] ?? '') ?>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($car['brand_name'] ?? 'N/A') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($car['category_name'] ?? 'N/A') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($car['year'] ?? 'N/A') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($car['color'] ?? 'N/A') ?></td>
                                    <td class="text-end"><?= number_format($car['price'] ?? 0) ?> VND</td>
                                    <td class="text-center"><?= htmlspecialchars($car['transmission'] ?? 'N/A') ?></td>
                                    <td class="text-end"><?= number_format($car['mileage'] ?? 0) ?> km</td>
                                    <td class="text-center"><?= htmlspecialchars($car['fuel_type'] ?? 'N/A') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($car['stock'] ?? 'N/A') ?></td>

                                    <td class="text-center">
                                        <?php if (!empty($car['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($car['image_url']) ?>" width="150" height="100">
                                        <?php else: ?>
                                            <span>No image</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if (!empty($car['image_3d_url'])): ?>
                                            <iframe src="<?= htmlspecialchars($car['image_3d_url']) ?>" width="200" height="150" style="border: none;"></iframe>
                                        <?php else: ?>
                                            <span>No 3D image</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-start" style="max-width: 400px; overflow: hidden; word-wrap: break-word; white-space: normal;">
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            <?= nl2br(htmlspecialchars($car['description'] ?? '')) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <a href="/edit_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/delete_car/<?= htmlspecialchars($car['id'] ?? 0) ?>" onclick="return confirm('Are you sure you want to delete this car?');" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="brands" style="display: none;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Brands</h2>
                    <a href="/add_brand" class="btn btn-primary mb-3">Add New Brand</a>
                </div>
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
                        <tbody class="text-light">
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

            <section id="categories" style="display: none;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Categories</h2>
                    <a href="/add_category" class="btn btn-primary mb-3">Add New Category</a>
                </div>
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark text-center" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['id'] ?? 0) ?></td>
                                    <td><?= htmlspecialchars($category['name'] ?? '') ?></td>
                                    <td>
                                        <a href="/edit_category/<?= htmlspecialchars($category['id'] ?? 0) ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/delete_category/<?= htmlspecialchars($category['id'] ?? 0) ?>" onclick="return confirm('Are you sure you want to delete this category?');" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="users" style="display: none;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Users</h2>
                    <a href="/add_user" class="btn btn-primary mb-3">Add New User</a>
                </div>
                <div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
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
                        <tbody class="text-light">
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
                </div>
            </section>

            <section id="favorites" style="display: none;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Favorites</h2>
                </div>
                <div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Xe</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
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
                </div>
            </section>

            <section id="orders" style="display: none;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Orders</h2>
                </div>
                <div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Xe</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['user_name']; ?></td>
                                    <td><?php echo $order['car_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo number_format($order['price']); ?> VND</td>
                                    <td><?php
                                        switch ($order['status']) {
                                            case 'Pending':
                                            case 'pending':
                                                echo 'Đang chờ xử lý';
                                                break;
                                            case 'Confirmed':
                                            case 'confirmed':
                                                echo 'Đã xác nhận';
                                                break;
                                            case 'Shipped':
                                            case 'shipped':
                                                echo 'Đang giao';
                                                break;
                                            case 'Canceled':
                                            case 'canceled':
                                                echo 'Đã hủy';
                                                break;
                                            case 'Completed':
                                            case 'completed':
                                                echo 'Đã hoàn thành';
                                                break;
                                        }
                                        ?></td>
                                    <td><?php echo $order['order_date']; ?></td>
                                    <td class="text-center">
                                        <a href="/order_edit/<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/order_delete/<?= htmlspecialchars($order['id']) ?? 0 ?>" onclick="return confirm('Are you sure you want to delete this order?');" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="test_drives" style="display: none;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Test Drives</h2>
                </div>
                <div class="table-responsive mb-5" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
                            <tr>

                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Xe</th>
                                <th>Ngày</th>
                                <th>Giờ</th>
                                <th>Địa điểm</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
                            <?php foreach ($test_drives as $test_drive): ?>
                                <tr>
                                    <td><?php echo $test_drive['id']; ?></td>
                                    <td><?php echo $test_drive['user_name']; ?></td>
                                    <td><?php echo $test_drive['car_name']; ?></td>
                                    <td><?php echo $test_drive['preferred_date']; ?></td>
                                    <td><?php echo date('H:i:s', strtotime($test_drive['preferred_time'])); ?></td>
                                    <td><?php echo $test_drive['location']; ?></td>
                                    <td><?php
                                        switch ($test_drive['status']) {
                                            case 'Pending':
                                            case 'pending':
                                                echo 'Đang chờ xử lý';
                                                break;
                                            case 'Confirmed':
                                            case 'confirmed':
                                                echo 'Đã xác nhận';
                                                break;
                                            case 'Canceled':
                                            case 'canceled':
                                                echo 'Đã hủy';
                                                break;
                                            case 'Completed':
                                            case 'completed':
                                                echo 'Đã hoàn thành';
                                                break;
                                        }
                                        ?></td>
                                    <td><?php echo $test_drive['created_at']; ?></td>
                                    <td class="text-center">
                                        <a href="/test_drive_edit/<?php echo htmlspecialchars($test_drive['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/test_drive_delete/<?= htmlspecialchars($test_drive['id']) ?? 0 ?>" onclick="return confirm('Are you sure you want to delete this test drive?');" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.querySelectorAll('nav a.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('section').forEach(section => {
                    section.style.display = 'none';
                });
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.style.display = 'block';
                }
            });
        });
    </script>
</body>

</html>