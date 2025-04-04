<div class="container mt-5">
    <h2>Add Car</h2>
    <form action="/add" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="brand_id">Brand:</label>
            <select class="form-control" id="brand_id" name="brand_id" required>
                <option value="" disabled selected>Select a brand</option>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="" disabled selected>Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" class="form-control" id="year" name="year" required>
        </div>

        <div class="form-group">
            <label for="mileage">Mileage:</label>
            <input type="number" class="form-control" id="mileage" name="mileage" required>
        </div>

        <div class="form-group">
            <label for="fuel_type">Fuel Type:</label>
            <select class="form-control" id="fuel_type" name="fuel_type">
                <option value="Gasoline">Gasoline</option>
                <option value="Diesel">Diesel</option>
                <option value="Hybrid">Hybrid</option>
                <option value="Electric">Electric</option>
            </select>
        </div>

        <div class="form-group">
            <label for="transmission">Transmission:</label>
            <select class="form-control" id="transmission" name="transmission">
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>

        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock">
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" class="form-control" id="color" name="color">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="image_url">Image URL:</label>
            <input type="file" class="form-control" id="image_url" name="image_url">
        </div>

        <div class="form-group">
            <label for="image_3d_url">3D Image URL:</label>
            <input type="text" class="form-control" id="image_3d_url" name="image_3d_url" placeholder="Nhập link ảnh 3D">
        </div>

        <button type="submit" class="btn btn-success">Add Car</button>
    </form>
</div>

<?php include '/ProjectCarSale/includes/footer.php'; ?>