<?php
$serverName = "GODZILLA\\MSSQLSERVER01"; // Lưu ý: escape dấu \
$database = "CarBusiness";
$username = "webuser"; // thay bằng user bạn tạo
$password = "StrongPassword123";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối SQL Server: " . $e->getMessage());
}
?>
