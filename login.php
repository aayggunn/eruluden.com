<?php
	include("baglanti.php");
	$uyari = ""; // Uyarı mesajını saklamak için değişken

	if(isset($_POST["giris"]))
	{
		$username = $_POST["kullanici_adi"];
		$password = $_POST["sifre"];
		
		if(isset($username) && isset($password))
		{
			$secim = "SELECT * FROM eruluden_uyeler WHERE kullanici_adi = '$username'";
			$calistir = mysqli_query($baglanti, $secim);
			$kayitsayisi = mysqli_num_rows($calistir);
			
			if($kayitsayisi > 0)
			{
				$ilgilikayit = mysqli_fetch_assoc($calistir);
				$hashlisifre = $ilgilikayit["sifre"];
				
				if(password_verify($password, $hashlisifre))
				{
					session_start();
					$_SESSION["uye_id"] = $ilgilikayit["uye_id"];
					$_SESSION["kullanici_adi"] = $ilgilikayit["kullanici_adi"];
					$_SESSION["ad"] = $ilgilikayit["ad"];
					$_SESSION["hakkimda"] = $ilgilikayit["hakkimda"];
					$_SESSION["email"] = $ilgilikayit["email"];
					header("location: anasayfa.php");
					exit(); // Redirect sonrası kod çalışmasını durdur
				}
				else
				{
					$uyari = "Şifre Yanlış";
				}
			}
			else
			{
				$uyari = "Kullanıcı Adı veya Şifre Yanlış";
			}
		}
	}
		
	mysqli_close($baglanti); 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Erülüden | Giriş Yap</title>
    <link rel="stylesheet" href="login.css">
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta charset="UTF-8">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2063708385257899"
     crossorigin="anonymous"></script>
    <script>
        window.onload = function() {
            var uyari = "<?php echo $uyari; ?>";
            if (uyari) {
                alert(uyari);
            }
        }
    </script>
</head>

<body>
    <section>
        <div class="login-box">
            <form action="login.php" method="POST">
                <h1>Giriş</h1>
                <div class="input-box">
                    <span class="icon"><i class="fa-regular fa-user"></i></span>
                    <input type="text" id="username" name="kullanici_adi" required>
                    <label>Kullanıcı Adı</label>
                </div>
                
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="password" name="sifre" required>
                    <label>Şifre</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Beni Hatırla</label>
                    <a href="sifre-sifirla-talep.php">Şifremi Unuttum</a>
                </div>
                <input type="submit" class="btn" value="Giriş Yap" name="giris"></input>
                <div class="register-link">
                    <p>Hesabın Yok Mu? <a href="kayit.php">Kaydol</a></p>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
