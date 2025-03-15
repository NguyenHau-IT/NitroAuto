<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    body {
        background-image: url('/uploads/bg.webp');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #fff;
        font-size: 18px; /* Tăng kích thước chữ */
    }

    .overlay {
        border-radius: 50px;
        background: rgba(0, 0, 0, 0.7);
        padding: 50px 20px;
        margin-top: 50px;
    }

    .container {
        max-width: 600px;
        margin: auto;
    }

    .form-group label {
        font-weight: bold;
        font-size: 20px; /* Tăng kích thước chữ */
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 25px;
        padding: 10px 20px;
        font-size: 18px; /* Tăng kích thước chữ */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>

<div class="container mt-5 overlay text-white fs-5 mb-4">
    <h2 class="mb-4 text-center">Đặt hàng xe</h2>

    <!-- Hiển thị thông tin người mua -->
    <div class="mb-3 fs-3">
        <h4>Thông tin người mua</h4>
        <p><strong>Tên:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address'] ?? '-'); ?></p>
    </div>

    <form id="orderForm">
    <input type="hidden" name="Nội dung" value="Đặt mua xe">
    
    <input type="hidden" name="Tên người mua" value="<?= htmlspecialchars($user['full_name']) ?>">
    <input type="hidden" name="Email" value="<?= htmlspecialchars($user['email']) ?>">
    <input type="hidden" name="Số điện thoại" value="<?= htmlspecialchars($user['phone']) ?>">
    <input type="hidden" name="Địa chỉ" value="<?= htmlspecialchars($user['address']) ?>">
    <input type="hidden" name="Tên xe" id="car_name">

    <div class="form-group">
        <label for="car_id">Chọn xe:</label>
        <select class="form-control" id="car_id" name="car_id" onchange="updatePrice()">
            <option value="">Chọn xe</option>
            <?php foreach ($cars as $car): ?>
                <option value="<?= htmlspecialchars($car['id']) ?>" data-price="<?= htmlspecialchars($car['price']) ?>" data-name="<?= htmlspecialchars($car['name']) ?>">
                    <?= htmlspecialchars($car['name']) ?> - <?= number_format($car['price']) ?> VNĐ
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Số lượng:</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="1" onchange="updatePrice()">
    </div>

    <div class="form-group">
        <label for="total_price">Tổng tiền:</label>
        <input type="text" class="form-control" id="total_price" name="total_price" readonly>
        <span id="total_price_display"></span>
    </div>

    <button type="submit" class="btn btn-primary">Đặt hàng</button>
</form>

<script>
document.getElementById("orderForm").addEventListener("submit", function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    fetch("/placeOrder", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Server Response:", data);
    })
    .catch(error => {
        console.error("Error:", error);
    });

    fetch("https://formspree.io/f/movevqyb", {
        method: "POST",
        body: formData,
        headers: { "Accept": "application/json" } 
    })
    .then(response => response.json())
    .then(data => {
        console.log("Formspree Response:", data);
        alert("Đặt hàng thành công!");
        window.location.href = "/home"; 
    })
    .catch(error => {
        console.error("Error:", error);
    });
});

function updatePrice() {
    var carSelect = document.getElementById("car_id");
    var quantityInput = document.getElementById("quantity");
    var totalPriceInput = document.getElementById("total_price");
    var totalPriceDisplay = document.getElementById("total_price_display");
    var carNameInput = document.getElementById("car_name");

    var selectedCar = carSelect.options[carSelect.selectedIndex];
    var price = selectedCar.getAttribute("data-price") ? parseFloat(selectedCar.getAttribute("data-price")) : 0;
    var quantity = parseInt(quantityInput.value) || 1;

    var total = price * quantity;
    totalPriceInput.value = total;
    totalPriceDisplay.innerText = total.toLocaleString('vi-VN') + " VNĐ";
    carNameInput.value = selectedCar.getAttribute("data-name");
}
</script>
</div>
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>