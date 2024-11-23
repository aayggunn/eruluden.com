<?php
include("baglanti.php");
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$uyari = "";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    
    // Kullanıcının e-posta adresini doğrula
    $kontrol_sorgu = "SELECT uye_id FROM eruluden_uyeler WHERE email = ?";
    if ($stmt = $baglanti->prepare($kontrol_sorgu)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // E-posta adresi mevcutsa, şifre sıfırlama bağlantısı gönder
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'mail.eruluden.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'no-reply@eruluden.com';
                $mail->Password = '6751ayGun!';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('no-reply@eruluden.com', 'Eruluden');
                $mail->addAddress($email);
                
                $mail->isHTML(true);
                $mail->Subject = 'Şifre Sıfırlama Talebi';
                $mail->Body = "Şifre sıfırlama talebinde bulundunuz. Lütfen <a href='http://eruluden.com/sifre-sifirla.php?email=$email'>bu bağlantıya</a> tıklayarak şifrenizi sıfırlayın.";

                $mail->send();
                $uyari = "Şifre sıfırlama bağlantısı e-postanıza gönderildi.";
            } catch (Exception $e) {
                $uyari = "E-posta gönderilemedi: {$mail->ErrorInfo}";
            }
        } else {
            $uyari = "Bu e-posta adresi kayıtlı değil.";
        }
        $stmt->close();
    }
    
    mysqli_close($baglanti);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Şifre Sıfırlama Talebi</title>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2063708385257899"
     crossorigin="anonymous"></script>
</head>
<body>
    <section>
        <div class="login-box">
            <form action="sifre-sifirla-talep.php" method="POST">
                <h1>Şifre Sıfırlama</h1>
                <div class="input-box">
                    <span class="icon"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" id="email" name="email" required>
                    <label>Email</label>
                </div>
                <input type="submit" class="btn" value="Şifre Sıfırlama Bağlantısı Gönder" name="submit">
                <?php if (!empty($uyari)): ?>
                    <p><?php echo $uyari; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </section>
</body>
</html>
