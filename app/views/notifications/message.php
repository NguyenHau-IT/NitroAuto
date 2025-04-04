<!-- message.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #121212;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status') || 'error';
        const message = urlParams.get('message') || (status === 'success' ? 'Thành công!' : 'Đã xảy ra lỗi không xác định.');
        const href = urlParams.get('href') || '/home';

        Swal.fire({
            icon: ['success', 'error', 'warning', 'info', 'question'].includes(status) ? status : 'info',
            title: status === 'success' ? 'Thành công!' : 'Lỗi!',
            text: message,
            confirmButtonText: 'Quay lại',
            backdrop: true,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            window.location.href = href;
        });
    </script>
</body>
</html>
