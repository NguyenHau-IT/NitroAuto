<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-heart me-2 text-danger"></i> Manage Favorites
    </h2>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th style="min-width: 60px;">ID</th>
                <th style="min-width: 200px;">Khách hàng</th>
                <th style="min-width: 200px;">Xe</th>
                <th style="min-width: 180px;">Thời gian</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($favorites as $favorite): ?>
                <tr>
                    <td><?= htmlspecialchars($favorite['id']) ?></td>
                    <td><?= htmlspecialchars($favorite['user_name']) ?></td>
                    <td><?= htmlspecialchars($favorite['car_name']) ?></td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($favorite['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
