<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="fas fa-th-list me-2 text-primary"></i> Manage Categories
    </h2>
    <a href="/add_category" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus-circle me-1"></i> Add New Category
    </a>
</div>

<div class="table-responsive rounded shadow-sm border mb-5" style="max-height: 700px; overflow-y: auto;">
    <table class="table table-bordered table-striped align-middle bg-white mb-0">
        <thead class="table-dark text-center sticky-top" style="top: 0; z-index: 10;">
            <tr>
                <th style="min-width: 60px;">ID</th>
                <th style="min-width: 300px;">Name</th>
                <th style="min-width: 150px;">Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['id'] ?? 0) ?></td>
                    <td class="text-start"><?= htmlspecialchars($category['name'] ?? '') ?></td>
                    <td>
                        <a href="/edit_category/<?= htmlspecialchars($category['id'] ?? 0) ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="/delete_category/<?= htmlspecialchars($category['id'] ?? 0) ?>"
                           onclick="return confirm('Are you sure you want to delete this category?');"
                           class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
