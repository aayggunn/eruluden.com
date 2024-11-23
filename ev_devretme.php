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
    <link rel="stylesheet" href="ev_devretme.css">
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
									<img src="default.jpg" alt="Profil Resmi">
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
                <div class="devretme-kutu">
                    <div class="devretme">
                    <a href = "ev_devretme_ilan_olustur.php"><div class="buton">
                    <input type="submit" class="btn" value="İlan Ekle" name="ekle"><i class="fa-solid fa-pen"></i></input>
                </div></a>
              <?php
								
					include("baglanti.php");

					$limit = 10;
					$offset = isset($_GET['id']) ? $_GET['id'] : 0;

					$toplam = $baglanti->query("SELECT count(*) FROM eruluden_ev_devretme_kiralama_ilanlar");
					$sayfa_sayisi = $toplam->fetch_row()[0]; // Sayfa sayısını direkt olarak alıyoruz
					$toplam->close();

					$ilan = $baglanti->prepare("SELECT i.ilan_id, i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat, i.ilan_resim FROM eruluden_ev_devretme_kiralama_ilanlar i INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id ORDER BY i.ilan_id DESC LIMIT ? OFFSET ?");
					$ilan->bind_param("ii", $limit, $offset);
					$ilan->execute();
					$ilan->store_result();
					$ilan->bind_result($ilan_id, $ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat, $ilan_resim);

					while ($ilan->fetch()) {
						if (strlen(strip_tags($ilan_yazi)) > 50) {
							$ilan_yazi = substr(strip_tags($ilan_yazi), 0, 50) . '...';
						}

						echo "<div class='ilan'>
						<h5 class='ilan_baslik'>{$ilan_baslik}</h5>
    <i class='ilan_tarih'>{$ilan_tarih} tarihinde {$kullanici_adi} tarafından gönderildi</i>
    <div class='bolum'>
        <div class='img-box'>
                    <img src='{$ilan_resim}' alt=''>
        </div>
        <div class='aciklama'>
            <p class='ilan_yazi'>{$ilan_yazi}</p>
        </div>
    </div>";

if (!empty($ilan_fiyat)) {
    echo "<p class='fyt'>Fiyat: {$ilan_fiyat} TL</p>";
}

echo "<p><a href='ev_devretme_ilan.php?id={$ilan_id}' class='devam-link'>Devamını Göster</a></p>
</div>";

					}

					if ($sayfa_sayisi > $limit) {
						$x = 0;
						for ($i = 0; $i < $sayfa_sayisi; $i += $limit) {
							$x++;
							echo "<a href='?id=$i'>[$x]</a>";
						}
					}

					$ilan->close();
					$baglanti->close();
			?>
                    </div>
                </div>
           

            </article>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

    <script src="site.js"></script>
  
</body>

</html>