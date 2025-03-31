<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/public/script.js"></script>
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container">
        <div class="row shadow-lg p-4 bg-white rounded">
            <!-- Login Form Column -->
            <div class="col-md-6 border-end">
                <h2 class="text-center mb-4">Đăng nhập</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
                <div class="text-center mt-3">
                    <a href="register" class="text-decoration-none d-block text-primary">Chưa có tài khoản? Đăng ký</a>
                    <a href="home" class="text-decoration-none d-block text-primary">Quay lại trang chủ</a>
                </div>
            </div>

            <!-- OTP Column -->
            <div class="col-md-6">
                <div class="mt-4">
                    <h5 class="mb-3">Nhập số điện thoại</h5>
                    <input type="text" id="phone" class="form-control mb-3" placeholder="Số điện thoại">
                    <button onclick="sendOTP()" class="btn btn-info w-100">Gửi OTP</button>
                </div>
                <div class="mt-4">
                    <h5 class="mb-3">Nhập mã OTP</h5>
                    <input type="text" id="otp" class="form-control mb-3" placeholder="Mã OTP">
                    <button onclick="verifyOTP()" class="btn btn-success w-100">Xác thực</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
