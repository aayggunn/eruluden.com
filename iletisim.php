<?php

	session_start();
	
	if(isset($_SESSION["kullanici_adi"]))
	{
		
	}
	
	else 
	{
		header("location: login.php");
	}
?>
<?php
	include("baglanti.php");

	// Kullanıcının oturum yönetiminden alınan ID'si
	$uye_id = $_SESSION['uye_id'];

	// Veritabanından kullanıcı bilgilerini çekme işlemi
	$sql = "SELECT ad, kullanici_adi, hakkimda FROM eruluden_uyeler WHERE uye_id = ?";
	$stmt = $baglanti->prepare($sql);
	$stmt->bind_param("i", $uye_id);
	$stmt->execute();
	$stmt->bind_result($ad, $kullanici_adi, $hakkimda);
	$stmt->fetch();
	$stmt->close();

	// Profil resmi yolu al
	$sql_resim = "SELECT pp_path FROM eruluden_profil_resimleri WHERE uye_id = ?";
	$stmt_resim = $baglanti->prepare($sql_resim);
	$stmt_resim->bind_param("i", $uye_id);
	$stmt_resim->execute();
	$stmt_resim->bind_result($profil_resmi);
	$stmt_resim->fetch();
	$stmt_resim->close();

	$baglanti->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | İletişim</title>
	<link rel="stylesheet" href="iletisim.css">
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
	<div class="wrapper">
		<header class="baslik">
			<h1><a href="anasayfa.php">ERULUDEN</a></h1>

		
			<div class="navbar">
                <ul>
                    <li> <a class="aktif" href="anasayfa.php">
                            <i class="fa-solid fa-house"></i>
                            <label for="anasayfa" class="text"> Anasayfa</label>
                        </a></li>
                    <li><a href="ilanlar.php"> <i class="fa-solid fa-rectangle-ad"></i> <label for="ilanlar"
                                class="text"> İlanlar</label></a>
                    </li>
                    <li><a href="duyurular_haberler.php"> <i class="fa-solid fa-bullhorn"></i> <label for="duyurular"
                                class="text"> Duyurular-Haberler</label> </a> </li>
                    <li><a href="ders_notu.php"> <i class="fa-regular fa-note-sticky"></i> <label for="sorular"
                                class="text"> Notlar</label></a> </li>
                    <li><a href="kampus.php"> <i class="fa-regular fa-building"></i><label for="kampus" class="text">
                                Kampus-Yurtlar</label>
                        </a></li>
                </ul>
            </div>
			
				<nav class="sidebar close">
					<header class="sider">
					<div class="logo-part">

                     <img src="logo1.jpg" alt="profil resmi">

                    </div>
					<div class="image-text">
					<span class="image">
                                <?php 
									if (!empty($profil_resmi)) { ?>
									<img src="<?php echo $profil_resmi; ?>" alt="Profil Resmi">
									<?php }
									
									else { ?>
									<img src="download.png" alt="Profil Resmi">
									<?php } 
								?>
                            </span>
							</div> 
					</header>

					<div class="sidemenu">
						<div class="menu1">
							<ul class="menu-links">
								<li class="nav-link">
									<a class="side" href="profil.php">
										<i class="fa-regular fa-user icon"></i>
									</a>
								</li>
								<li class="nav-link">
								<a class="side" href="mesaj_kutusu.php">
                                        <i class="fa-solid fa-inbox icon"></i>   
									</a>
								</li>
								

                                <li class="nav-link">
                                  <a class="side" href="ara.php">
                                  <i class="fa-solid fa-magnifying-glass icon"></i>  
                                </a>
                                </li>
								<li class="nav-link">
									<a class="side" href="iletisim.php">
										<i class="fa-solid fa-phone icon"></i>
									</a>
								</li>
								<li class="nav-link">
									<a class="side" href="hakkimizda.php">
										<i class="fa-solid fa-briefcase icon"></i>
									</a>
								</li>
								<li class="nav-link">
									<a class="side" href="cikis.php">
										<i class="fa-solid fa-xmark icon"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>

				
				<article class="alan">
				<div class="form-kutu">
					<form action="gonder.php" method="POST">
						<div class="contact">
							<h1>Bize Ulaşın</h1>
							<div class="input-box">
								<input type="text" placeholder="Kullanıcı Adı" class="form-control"
									name="GONDERENIN_KULLANICI_ADI" required>
							</div>
							<div class="input-box">
								<input type="email" placeholder="Email" class="form-control" name="EPOSTA_ADRESI" required>
							</div>
							<div class="input-box">
								<textarea name="GONDERENIN_MESAJI" placeholder="Mesaj" rows="10" required></textarea>
							</div>
							<button type="submit" class="bt">Gönder</button>
						</div>
					</form>
				</div>
			</article>	
			
	</div>
	

</body>

</html>