<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-industry me-2 text-primary"></i> Manage Brands
    </h2>
    <a href="/add_brand" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus-circle me-1"></i> Add New Brand
    </a>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th style="min-width: 60px;">ID</th>
                <th style="min-width: 200px;">Name</th>
                <th style="min-width: 150px;">Country</th>
                <th style="min-width: 120px;">Logo</th>
                <th style="min-width: 150px;">Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($brands as $brand): ?>
                <tr>
                    <td><?= htmlspecialchars($brand['id'] ?? 0) ?></td>
                    <td class="text-start"><?= htmlspecialchars($brand['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($brand['country'] ?? '') ?></td>
                    <td>
                        <?php if (!empty($brand['logo'])): ?>
                            <img src="<?= htmlspecialchars($brand['logo']) ?>"
                                 alt="<?= htmlspecialchars($brand['name'] ?? 'Brand Logo') ?>"
                                 class="img-thumbnail"
                                 style="max-width: 100px; max-height: 80px;">
                        <?php else: ?>
                            <span class="text-muted">No logo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/edit_brand/<?= htmlspecialchars($brand['id'] ?? 0) ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="/delete_brand/<?= htmlspecialchars($brand['id'] ?? 0) ?>"
                           onclick="return confirm('Are you sure you want to delete this brand?');"
                           class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
