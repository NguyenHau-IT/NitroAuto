<?php
require_once '../../config/database.php'; // Đảm bảo đường dẫn đúng

header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $query = trim($_GET['q']);

    // Dùng LIKE để tìm kiếm tên thương hiệu xe
    $stmt = $conn->prepare("SELECT TOP 10 name FROM Brands WHERE name LIKE :query");
    $stmt->execute(['query' => "%$query%"]);
    $brands = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($brands);
} else {
    echo json_encode(["error" => "Thiếu tham số 'q'"]);
}
?>
