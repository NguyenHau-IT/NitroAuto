<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-cogs me-2 text-primary"></i> Manage Accessories
    </h2>
    <a href="/add_accessory" class="btn btn-success shadow-sm">
        <i class="fas fa-plus-circle me-1"></i> Add New Accessory
    </a>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-hover table-bordered align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th style="min-width: 60px;">ID</th>
                <th style="min-width: 200px;">Name</th>
                <th style="min-width: 120px;">Price</th>
                <th style="min-width: 300px;">Description</th>
                <th style="min-width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody class="text-dark">
            <?php foreach ($accessoires as $accessory): ?>
                <tr>
                    <td class="text-center"><?= $accessory['id'] ?></td>
                    <td><?= htmlspecialchars($accessory['name']) ?></td>
                    <td><?= number_format($accessory['price']) ?> VND</td>
                    <td>
                        <div class="bg-light rounded p-2 overflow-auto" style="max-height: 120px; white-space: pre-wrap;">
                            <?= nl2br(htmlspecialchars($accessory['description'])) ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="/edit_accessory/<?= htmlspecialchars($accessory['id']) ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="/delete_accessory/<?= htmlspecialchars($accessory['id']) ?>"
                           onclick="return confirm('Are you sure you want to delete this accessory?');"
                           class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
