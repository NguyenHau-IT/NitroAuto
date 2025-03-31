<div class="container mt-5">
    <h2>Edit Car</h2>
    <form action="/update_car/<?= htmlspecialchars($car['id']) ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($car['name']) ?>" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="brand_id">Brand:</label>
            <select class="form-control" id="brand_id" name="brand_id" required>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?= $brand['id'] ?>" <?= $brand['id'] == $car['brand_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($brand['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $car['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($car['price']) ?>" required min="0">
        </div>

        <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" class="form-control" id="year" name="year" value="<?= htmlspecialchars($car['year']) ?>" required min="1886" max="<?= date('Y') ?>">
        </div>

        <div class="form-group">
            <label for="fuel_type">Fuel Type:</label>
            <select class="form-control" id="fuel_type" name="fuel_type" required>
                <option value="Gasoline" <?= $car['fuel_type'] == 'Gasoline' ? 'selected' : '' ?>>Gasoline</option>
                <option value="Diesel" <?= $car['fuel_type'] == 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                <option value="Hybrid" <?= $car['fuel_type'] == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                <option value="Electric" <?= $car['fuel_type'] == 'Electric' ? 'selected' : '' ?>>Electric</option>
            </select>
        </div>

        <div class="form-group">
            <label for="transmission">Transmission:</label>
            <select class="form-control" id="transmission" name="transmission" required>
                <option value="Automatic" <?= $car['transmission'] == 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                <option value="Manual" <?= $car['transmission'] == 'Manual' ? 'selected' : '' ?>>Manual</option>
            </select>
        </div>

        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($car['stock']) ?>" required min="0">
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" class="form-control" id="color" name="color" value="<?= htmlspecialchars($car['color']) ?>" required maxlength="50">
        </div>

        <div class="form-group">
            <label for="mileage">Mileage:</label>
            <input type="number" class="form-control" id="mileage" name="mileage" value="<?= htmlspecialchars($car['mileage']) ?>" required min="0">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required maxlength="1000"><?= htmlspecialchars($car['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="created_at">Created At:</label>
            <input type="datetime-local" class="form-control" id="created_at" name="created_at" value="<?= htmlspecialchars($car['created_at'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="image_url">Image URL:</label>
            <input type="file" class="form-control" id="image_url" name="image_url" value="<?= htmlspecialchars($car['normal_image_url']) ?>">
        </div>

        <div class="form-group">
            <label for="image_url3D">Image URL 3D:</label>
            <input type="text" class="form-control" id="image_url3D" name="image_url3D" value="<?= htmlspecialchars($car['three_d_image_url'] ?? '') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/admin" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '/ProjectCarSale/includes/footer.php'; ?>