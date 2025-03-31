<?php
$status = isset($_GET['status']) ? $_GET['status'] : "error";
$message = isset($_GET['message']) ? $_GET['message'] : ($status === "success" ? "Thành công!" : "Đã xảy ra lỗi không xác định.");
$href = isset($_GET['href']) ? $_GET['href'] : "/home";

if ($status !== "success") {
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/style.css">
</head>

<body class="bg-dark text-white d-flex justify-content-center align-items-center" style="height: 100vh;">
    <script>
        Swal.fire({
            icon: "<?= $status ?>",
            title: "<?= $status === 'success' ? 'Thành công!' : 'Lỗi!' ?>",
            text: "<?= addslashes($message); ?>",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "<?= $href ?>";
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>