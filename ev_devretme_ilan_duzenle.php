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
    <title>Erülüden | Ev Devretme</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="ev_devretme_ilan_duzenle.css">
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
                <div class="logo-part">

                    <img src="logo1.jpg" alt="profil resmi">

                </div>
                    <header class="sider">
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
				<div class="ilan-duzen">
					<div class="duzen">
					<a href = "profil.php"><div class="buton">
                    <input type="submit" class="btn" value="Geri Dön" name="ekle"><i class="fa-solid fa-arrow-left"></i></input>
                </div></a>
			<?php
				error_reporting(E_ALL);
				ini_set('display_errors', 1);

				include("baglanti.php");

				// Kullanıcı doğrulaması eklemesi
				// Örnek olarak, kullanıcı oturum kontrolü yapılıyor varsayalım

				if (!isset($_SESSION['uye_id'])) {
					echo "Bu işlem için giriş yapmalısınız.";
					exit;
				}

				$kullanici_id = $_SESSION['uye_id'];

				// İlanı düzenlenecek ilan ID'sini alma
				if (isset($_GET['id']) && is_numeric($_GET['id'])) {
					$ilan_id = intval($_GET['id']);

					// İlanı veritabanından seçme
					$duzenlenecek_ilan = $baglanti->prepare("SELECT ilan_baslik, ilan_yazi, ilan_fiyat FROM eruluden_ev_devretme_kiralama_ilanlar WHERE ilan_id = ? AND uye_id = ?");
					if ($duzenlenecek_ilan !== false) {
						$duzenlenecek_ilan->bind_param("ii", $ilan_id, $kullanici_id);
						if ($duzenlenecek_ilan->execute()) {
							$duzenlenecek_ilan->store_result();

							// İlan bilgilerini çekme
							$duzenlenecek_ilan->bind_result($ilan_baslik, $ilan_yazi, $ilan_fiyat);
							if ($duzenlenecek_ilan->fetch()) {
								// İlan bulundu ve bilgiler alındı.
								$duzenlenecek_ilan->close();
							} else {
								// İlan bulunamadı, geçersiz ID
								echo "Geçersiz ilan ID'si veya bu ilan size ait değil.";
							}
						} else {
							die("Sorgu hatası: " . $duzenlenecek_ilan->error);
						}
					} else {
						die("Sorgu hazırlama hatası: " . $baglanti->error);
					}
				} else {
					echo "Düzenlenecek ilan ID'si belirtilmedi veya geçersiz.";
				}

				if (isset($_POST['duzenle'])) {
					// Formdan gelen verileri alın
					$ilan_baslik = $_POST['ilan_baslik'];
					$ilan_yazi = $_POST['ilan_yazi'];
					$ilan_fiyat = $_POST['ilan_fiyat'];

					// İlan güncelleme SQL sorgusu
					$guncelle_sorgu = $baglanti->prepare("UPDATE eruluden_ev_devretme_kiralama_ilanlar SET ilan_baslik = ?, ilan_yazi = ?, ilan_fiyat = ? WHERE ilan_id = ? AND uye_id = ?");
					if ($guncelle_sorgu !== false) {
						$guncelle_sorgu->bind_param("ssdii", $ilan_baslik, $ilan_yazi, $ilan_fiyat, $ilan_id, $kullanici_id);
						if ($guncelle_sorgu->execute()) {
							echo "İlan başarıyla güncellendi.";
							exit();
						} else {
							die("Güncelleme hatası: " . $guncelle_sorgu->error);
						}
					} else {
						die("Güncelleme sorgusu hazırlama hatası: " . $baglanti->error);
					}
				}

				$baglanti->close();
			?>

				<h2 class="add">İlanı Düzenle</h2>
				<div class="form-container">
				<form action="ev_devretme_ilan_duzenle.php?id=<?php echo $ilan_id; ?>" method="post">
					<label for="ilan_baslik">Başlık:</label>
					<input type="text" name="ilan_baslik" id="ilan_baslik" value="<?php echo $ilan_baslik; ?>">
					<br><br>
					<label for="ilan_yazi">Açıklama:</label>
					<textarea name="ilan_yazi" id="ilan_yazi"><?php echo $ilan_yazi; ?></textarea>
					<br><br>
					<label for="ilan_fiyat">Fiyat:</label>
					<input type="text" name="ilan_fiyat" id="ilan_fiyat" value="<?php echo $ilan_fiyat; ?>">
					<br><br>
					<input type="submit" name="duzenle" value="Düzenle" class="bt">
				</form>

				</div>
				
					</div>
				</div>
			
		</article>

    </div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

</body>

</html>