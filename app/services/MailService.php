<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public static function sendVerificationCode($toEmail, $code)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // SMTP server của bạn (Gmail, Outlook...)
            $mail->SMTPAuth   = true;
            $mail->Username   = 'nguyenhau1720@gmail.com'; // Email gửi
            $mail->Password   = 'wpkr grsh fsby xkkk';    // App password (không phải mật khẩu đăng nhập Gmail)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('nguyenhau1720@gmail.com', 'NitroAuto');
            $mail->addAddress($toEmail);

            // Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "Yêu cầu đặt lại mật khẩu - NitroAuto";
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; font-size: 15px; color: #333;'>
                    <p>Xin chào bạn,</p>
                    <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản <strong>NitroAuto</strong> của bạn.</p>
                    <p>Vui lòng sử dụng mã xác nhận bên dưới để tiếp tục quá trình:</p>
                    <p style='font-size: 20px; font-weight: bold; color: #D32F2F;'>$code</p>
                    <p><em>Lưu ý:</em> Mã xác nhận này có hiệu lực trong vòng <strong>5 phút</strong>. Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                    <p>Để đảm bảo an toàn, không chia sẻ mã này với bất kỳ ai.</p>
                    <p>Trân trọng,<br/>Đội ngũ NitroAuto</p>
                </div>";
            $mail->AltBody = "Mã đặt lại mật khẩu của bạn là: $code. Mã có hiệu lực trong 5 phút. Nếu bạn không yêu cầu, vui lòng bỏ qua email này.";
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
