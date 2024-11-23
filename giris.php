<?php
	include("baglanti.php");
	
	if(isset($_POST["giris"]))
	{
		$username = $_POST["kullanici_adi"];
		$email = $_POST["email"];
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
					$_SESSION["kullanici_adi"] = $ilgilikayit["kullanici_adi"];
					$_SESSION["ad"] = $ilgilikayit["ad"];
					$_SESSION["hakkimda"] = $ilgilikayit["hakkimda"];
					$_SESSION["email"] = $ilgilikayit["email"];
					header("location: anasayfa.php");
				}
				else
				{
					echo '<div class="alert alert-danger" role="alert">
  						Şifre Yanlış 
					</div>';
				}
			}
			else
			{
				echo '<div class="alert alert-danger" role="alert">
  					Kullanıcı Adı veya Şifre Yanlış 
					</div>';
			}
		}
	}
		
	mysqli_close($baglanti); 
?>

<!DOCTYPE html>
<html>

<head>
    <title>Erülüden | Üye Ol </title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <div class="wrapper">


        <form action="login.php" method="POST">
            <h1>Giriş Yap</h1>
            <div class="input-box">
                <input type="text" placeholder="Kullanıcı Adı" id="username" name="kullanici_adi" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Şifre" id="password" name="sifre" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="input-box">
                <input type="email" placeholder="Email" id="email" name="email" required>
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox"> Beni Hatırla
                </label>
                <a href="#">Şifremi Unuttum</a>
            </div>

            <input type="submit" class="btn" value="Giriş Yap" name="giris"></input>

            <div class="register-link">
                <p>Hesabın Yok Mu? <a href="kayit.php">Kaydol</a></p>
            </div>
        </form>

    </div>

</body>

</html>