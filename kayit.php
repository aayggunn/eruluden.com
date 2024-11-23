<?php
include("baglanti.php");
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$uyari = ""; // Uyarı mesajını saklamak için değişken

if (isset($_POST["kaydet"])) {
    $name = $_POST["ad"];
    $username = $_POST["kullanici_adi"];
    $email = $_POST["email"];
    $password = password_hash($_POST["sifre"], PASSWORD_DEFAULT);
    $about = $_POST["hakkimda"];

    // Kullanıcı adı veya e-posta kontrolü
    $kontrol_sorgu = "SELECT kullanici_adi, email FROM eruluden_uyeler WHERE kullanici_adi = ? OR email = ?";
    if (!$stmt = $baglanti->prepare($kontrol_sorgu)) {
        $uyari = "Veritabanı hatası: " . $baglanti->error;
    } else {
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($db_username, $db_email);
        $stmt->fetch(); // Fetch the result into bound variables

        if ($db_username === $username) {
            $uyari = "Bu kullanıcı adı kullanılıyor!";
        } elseif ($db_email === $email) {
            $uyari = "Bu e-posta adresi zaten kayıtlı! Giriş Yap ekranındaki 'Şifremi Unuttum' seçeneği ile şifrenizi sıfırlayabilirsiniz";
        } else {
            // Yeni kullanıcıyı ekle
            $ekle = "INSERT INTO eruluden_uyeler (ad, kullanici_adi, email, sifre, hakkimda) VALUES (?, ?, ?, ?, ?)";
            if (!$stmt = $baglanti->prepare($ekle)) {
                $uyari = "Veritabanı hatası: " . $baglanti->error;
            } else {
                $stmt->bind_param("sssss", $name, $username, $email, $password, $about);
                if ($stmt->execute()) {
                    $uye_id = $baglanti->insert_id;
					 $uyari = "";

                    // Yeni eklenen üyenin ID'sini almak için sorgu
                    $alici_email_sorgu = $baglanti->prepare("SELECT email, ad FROM eruluden_uyeler WHERE uye_id = ?");
                    if ($alici_email_sorgu === false) {
                        die('Sorgu hazırlama hatası: ' . $baglanti->error);
                    }
                    $alici_email_sorgu->bind_param("i", $uye_id);
                    $alici_email_sorgu->execute();
                    $alici_email_sorgu->bind_result($alici_email, $alici_ad);
                    $alici_email_sorgu->fetch();
                    $alici_email_sorgu->close();

                    if (!empty($alici_email)) {
                        $konu = "Eruluden'e Hoşgeldin!";
                        $mesaj_icerigi = "Merhaba " . $alici_ad . ",\n\nHoşgeldiniz! Hesabınız başarıyla oluşturuldu. Artık burada ilanlarını paylaşabilir, paylaşılmış ilanları inceleyebilir ve insanlarla iletişime geçebilirsin. Kullanıcı katılımlı PDF havuzunda PDF arayabilir veya yükleyebilirsin. Profilini tamamlayıp gerçek bir Erü'lü olarak burada yerini al ve bu topluluğa katıl.";

                        // PHPMailer ile e-posta gönderme
                        $mail = new PHPMailer(true);

                        try {
                            // SMTP ayarları
                            $mail->isSMTP();
                            $mail->Host = 'mail.eruluden.com'; // SMTP sunucu adresinizi girin
                            $mail->SMTPAuth = true;
                            $mail->Username = 'no-reply@eruluden.com'; // SMTP kullanıcı adınızı girin
                            $mail->Password = '6751ayGun!'; // SMTP şifrenizi girin
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;
                            $mail->CharSet = 'UTF-8';

                            // Gönderen ve alıcı bilgileri
                            $mail->setFrom('no-reply@eruluden.com', 'Eruluden');
                            $mail->addAddress($alici_email, $alici_ad);

                            // E-posta içeriği
                            $mail->isHTML(true);
                            $mail->Subject = $konu;
                            $mail->Body = nl2br($mesaj_icerigi);

                            $mail->send();
                        } catch (Exception $e) {
                            echo "<script>alert('E-posta gönderilemedi. Hata: {$mail->ErrorInfo}');</script>";
                        }
                    } else {
                        echo "<script>alert('Alıcının e-posta adresi bulunamadı.');</script>";
                    }
                } else {
                    $uyari = "Kayıt başarısız: " . $stmt->error;
                }
            }
        }
        $stmt->close();
    }
    
    mysqli_close($baglanti);

    if (empty($uyari)) {
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Erülüden | Üye Ol</title>
  <link rel="stylesheet" href="kayit.css">
  <link rel="icon" href="logo1.jpg" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2063708385257899"
     crossorigin="anonymous"></script>
</head>
<body>
  <div class="wrapper">
    <h1>Üye Ol</h1>
    <form action="kayit.php" method="POST">
      <div class="input-box">
        <input type="text" id="name" name="ad" placeholder="İsim" maxlength="25" required>
        <i class="fa-solid fa-signature"></i>
      </div>

      <div class="input-box">
        <input type="text" id="username" name="kullanici_adi" placeholder="Kullanıcı Adı" maxlength="25" required>
        <i class="fa-solid fa-user"></i>
      </div>

      <div class="input-box">
        <input type="email" id="email" name="email" placeholder="Email" maxlength="50" required>
        <i class="fa-regular fa-envelope"></i>
      </div>

      <div class="input-box">
        <input type="password" id="password" name="sifre" placeholder="Şifre" maxlength="50" required>
        <i class="fa-solid fa-lock"></i>
      </div>

      <div class="input-box">
        <input type="text" id="about" name="hakkimda" placeholder="Hakkımda" maxlength="50">
        <i class="fa-solid fa-font"></i>
      </div>

      <button type="submit" name="kaydet" class="btn">Üye Ol</button>
    </form>
  </div>
  <script>
        window.onload = function() {
            var uyari = "<?php echo $uyari; ?>";
            if (uyari) {
                alert(uyari);
            }
        }
    </script>
</body>
</html>
