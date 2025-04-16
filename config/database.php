<?php
$serverName = "GODZILLA\SQLDEV"; // Lưu ý: escape dấu \
$database = "CarBusiness";
$username = "sqluser"; // thay bằng user bạn tạo
$password = "Strong@123";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối SQL Server: " . $e->getMessage());
}
?>
