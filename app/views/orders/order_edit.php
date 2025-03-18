<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
    <h1>Edit Order #<?php echo htmlspecialchars($order['order_id']); ?></h1>
    <p>Customer: <?php echo htmlspecialchars($order['user_name']); ?></p>
    <p>Product: <?php echo htmlspecialchars($order['car_name']); ?></p>
    <p>Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
    <p>Current Status: <?php echo htmlspecialchars($order['status']); ?></p>

    <form method="POST" action="/orderupdate/<?= htmlspecialchars($order['order_id']) ?>">
        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
        <label for="status">Update Status:</label>
        <select name="order_status" id="status">
            <option value="pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="completed" <?php if ($order['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
            <option value="canceled" <?php if ($order['status'] == 'Canceled') echo 'selected'; ?>>Cancelled</option>
            <option value="shipped" <?php if ($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
            <option value="confirmed" <?php if ($order['status'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
        </select>
        <button type="submit">Update</button>
    </form>
    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>