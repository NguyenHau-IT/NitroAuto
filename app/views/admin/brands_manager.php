<div class="d-flex justify-content-between mb-3">
                    <h2>Manage Brands</h2>
                    <a href="/add_brand" class="btn btn-primary mb-3">Add New Brand</a>
                </div>
                <div style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-bordered table-striped bg-dark">
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