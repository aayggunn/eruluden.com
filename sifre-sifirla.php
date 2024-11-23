<?php
include("baglanti.php");

$uyari = "";
$success = false;

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    
    // E-posta adresini doğrula
    $sorgu = "SELECT email FROM eruluden_uyeler WHERE email = ?";
    if ($stmt = $baglanti->prepare($sorgu)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // E-posta adresi mevcutsa, şifre güncelleme formunu göster
            if (isset($_POST['submit'])) {
                $new_password = $_POST['new_password'];
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                $update_sorgu = "UPDATE eruluden_uyeler SET sifre = ? WHERE email = ?";
                if ($update_stmt = $baglanti->prepare($update_sorgu)) {
                    $update_stmt->bind_param("ss", $hashed_password, $email);
                    if ($update_stmt->execute()) {
                        $success = true;
                        $uyari = "Şifreniz başarıyla güncellendi.";
                    } else {
                        $uyari = "Şifre güncellenirken bir hata oluştu.";
                    }
                }
            }
        } else {
            $uyari = "Geçersiz e-posta adresi.";
        }
    }
    
    mysqli_close($baglanti);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Şifre Sıfırlama</title>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2063708385257899"
     crossorigin="anonymous"></script>
</head>
<body>
    <section>
        <div class="login-box">
            <?php if ($success): ?>
                <p><?php echo $uyari; ?></p>
            <?php else: ?>
                <form action="sifre_sifirla.php?email=<?php echo htmlspecialchars($_GET['email']); ?>" method="POST">
                    <h1>Yeni Şifre Belirleyin</h1>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" id="new_password" name="new_password" required>
                        <label>Yeni Şifre</label>
                    </div>
                    <input type="submit" class="btn" value="Şifreyi Güncelle" name="submit">
                    <?php if (!empty($uyari)): ?>
                        <p><?php echo $uyari; ?></p>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
