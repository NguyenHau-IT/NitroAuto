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
            $mail->Subject = "<h1>Mã xác nhận tài khoản NitroAuto</h1>";
            $mail->Body    = "<p>Chào bạn,</p>
                              <p>Mã xác nhận của bạn là: <strong>$code</strong></p>
                              <p>Mã có hiệu lực trong 5 phút.</p>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
