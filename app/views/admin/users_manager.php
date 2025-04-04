<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-users me-2 text-primary"></i> Manage Users
    </h2>
    <a href="/add_user" class="btn btn-primary shadow-sm">
        <i class="fas fa-user-plus me-1"></i> Add New User
    </a>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-striped table-bordered align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
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
        <tbody class="text-center">
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td class="text-start"><?= $user['address'] ?></td>
                    <td>
                        <?php
                        $role = $user['role'];
                        if ($role === 'admin') {
                            echo '<span class="badge bg-danger">Quản trị viên</span>';
                        } elseif ($role === 'customer') {
                            echo '<span class="badge bg-secondary">Người dùng</span>';
                        } else {
                            echo '<span class="badge bg-warning text-dark">Khác</span>';
                        }
                        ?>
                    </td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($user['created_at'])) ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
