<?php
require '../config/database.php';
if (!isset($_SESSION['user'])) {
    header("Location: /home");
    exit();
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
    <link rel="stylesheet" href="/public/style.css">
    <script src="/script.js"></script>
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Admin Dashboard</h1>
            <div>
                <a class="nav-link d-inline text-white ml-3" href="/home"><i class="fas fa-home"></i> Home</a>
                <a class="nav-link d-inline text-white ml-3" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['full_name']); ?></span>
            </div>
        </div>
    </header>
    <div class="d-flex overlay">
        <nav class="bg-dark text-white p-3" style="min-width:100px; position: sticky; top: 0; height: 100%;">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#cars"><i class="fas fa-car"></i> Manage Cars</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#brands"><i class="fas fa-building"></i> Manage Brands</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#categories"><i class="fas fa-list"></i> Manage Categories</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#accessories"><i class="fas fa-cogs"></i> Manage Accessories</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#users"><i class="fas fa-users"></i> Manage Users</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#favorites"><i class="fas fa-heart"></i> Manage Favorites</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#orders"><i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#test_drives"><i class="fas fa-car"></i> Manage Test Drives</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#banners"><i class="fas fa-image"></i> Manage Banners</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </nav>
        <main class="container mt-4 flex-grow-1" style="margin-left: 30px; width: 100%;">

            <section id="dashboard">
                <h2>Welcome to the Admin Dashboard</h2>
                <p>Here you can manage cars, users, and settings.</p>
            </section>

            <section id="cars" style="display: none; width: 1550px;">
                <?php require_once __DIR__ . '/cars_manager.php'; ?>
            </section>

            <section id="brands" style="display: none;width: 1550px;">
                
            </section>

            <section id="categories" style="display: none;width: 1550px;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Categories</h2>
                    <a href="/add_category" class="btn btn-primary mb-3">Add New Category</a>
                </div>
                <div style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-bordered table-striped bg-dark">
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

            <section id="accessories" style="display: none;width: 1550px;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Accessories</h2>
                    <a href="/add_accessory" class="btn btn-primary mb-3">Add New Accessory</a>
                </div>
                <div class="table-responsive mb-5" style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle bg-dark">
                        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
                            <?php foreach ($accessoires as $accessory): ?>
                                <tr>
                                    <td><?php echo $accessory['id']; ?></td>
                                    <td><?php echo $accessory['name']; ?></td>
                                    <td><?php echo number_format($accessory['price']); ?> VND</td>
                                    <td class="text-start" style="max-width: 400px; overflow: hidden; word-wrap: break-word; white-space: normal;">
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            <?php echo nl2br(htmlspecialchars($accessory['description'])); ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="/edit_accessory/<?php echo htmlspecialchars($accessory['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/delete_accessory/<?php echo htmlspecialchars($accessory['id']); ?>"
                                            onclick="return confirm('Are you sure you want to delete this accessory?');"
                                            class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="users" style="display: none;width: 1550px;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Users</h2>
                    <a href="/add_user" class="btn btn-primary mb-3">Add New User</a>
                </div>
                <div class="table-responsive mb-5" style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle bg-dark">
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

            <section id="favorites" style="display: none;width: 1550px;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Favorites</h2>
                </div>
                <div class="table-responsive mb-5" style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle bg-dark">
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

            <section id="orders" style="display: none; width: 1550px;">
                <?php require_once __DIR__ . '/orders_manager.php'; ?>
            </section>

            <section id="test_drives" style="display: none;width: 1550px;">
                <div class="d-flex justify-content-between mb-3">
                    <h2>Manage Test Drives</h2>
                </div>
                <div class="table-responsive mb-5" style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-striped table-bordered align-middle bg-dark">
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

            <section id="banners" style="display: none;width: 1550px;">
                <?php require_once __DIR__ . '/banners_manager.php'; ?>
            </section>
        </main>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/style.css">

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