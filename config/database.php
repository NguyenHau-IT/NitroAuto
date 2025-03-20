<?php
$serverName = "GODZILLA\MSSQLSERVER01";
$database = "CarBusiness";
$username = "";
$password = "";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối SQL Server: " . $e->getMessage());
}
?>
