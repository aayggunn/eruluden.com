<?php
session_start();

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$kime = "iletisim@eruluden.com"; // Mesajın gitmesini istediğiniz e-posta adresi.
$konu = "İletişim Formundan Mesaj!";
$DateandTime = date("d-m-Y H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gonderenin_kullanici_adi = $_POST["GONDERENIN_KULLANICI_ADI"];
    $eposta_adresi = $_POST["EPOSTA_ADRESI"];
    $gonderenin_mesaji = $_POST["GONDERENIN_MESAJI"];

    // Boş alan kontrolü
    if (empty($gonderenin_kullanici_adi) || empty($eposta_adresi) || empty($gonderenin_mesaji)) {
        echo "Lütfen tüm alanları doldurun.";
        exit();
    }

    $mesaj = "İletişim Formunuzdan Gönderilen Mesajın İçeriği Aşağıdadır:\n"
        . "Kullanıcı Adı: $gonderenin_kullanici_adi\n"
        . "E-Posta Adresi: $eposta_adresi\n"
        . "Yazdığı Mesaj: $gonderenin_mesaji";

    $mail = new PHPMailer(true);

    try {
        // SMTP ayarları
        $mail->isSMTP();
        $mail->Host = 'mail.eruluden.com'; // SMTP sunucu adresinizi girin
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@eruluden.com'; // SMTP kullanıcı adınızı girin
        $mail->Password = '6751ayGun!'; // SMTP şifrenizi girin
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Güvenli bağlantı türü
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Gönderen ve alıcı bilgileri
        $mail->setFrom($eposta_adresi, $gonderenin_kullanici_adi); // Gönderen bilgileri
        $mail->addAddress($kime); // Alıcı e-posta adresi

        // E-posta içeriği
        $mail->isHTML(false); // Düz metin (HTML değil)
        $mail->Subject = $konu;
        $mail->Body = $mesaj;

        // E-postayı gönder
        $mail->send();

        // Başarılı gönderim sonrası yönlendirme
        echo "<script>alert('Mesajınız başarıyla gönderildi.'); window.location.href = 'https://www.eruluden.com/iletisim.php';</script>";
        exit();
    } catch (Exception $e) {
        echo "<script>alert('E-posta gönderilemedi. Hata: {$mail->ErrorInfo}');</script>";
    }
} else {
     echo "<script>alert('Geçersiz istek.');</script>";
}
?>
