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
    <title>Erülüden | İlan</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="ilan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
			<div class="ilan-kutu">
				<?php
include("baglanti.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ilan_id = intval($_GET['id']);

    $ilan_detay = $baglanti->prepare("SELECT i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat, i.ilan_resim, i.uye_id FROM eruluden_ikinci_el_ilanlar i INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id WHERE i.ilan_id = ?");
    $ilan_detay->bind_param("i", $ilan_id);
    $ilan_detay->execute();
    $ilan_detay->bind_result($ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat, $ilan_resim, $ilan_sahibi_id);
    $ilan_detay->fetch();

    echo "<div class='ilan-detay'>
            <div class='img-box'>
                <img src='{$ilan_resim}' alt=''>
            </div>
            <i><label>$ilan_tarih tarihinde <a href='kullanici.php?id=$ilan_sahibi_id'>$kullanici_adi</a> tarafından paylaşıldı</label></i>
            <h1><label>{$ilan_baslik}</label></h1>
            <p><label>{$ilan_yazi}</label></p>";

    if (!empty($ilan_fiyat)) {
        echo "<p class='fiyat'><label>Fiyat: {$ilan_fiyat} TL </label></p>";
    }

    echo "<div class='buton-kısım'>
            <div class='paylas'>
                <form action='ilan_paylas.php' method='POST'>
                    <input type='submit' class='btn' value='İlan Paylaş' name='ekle'><i class='fa-solid fa-share-nodes'></i>
                </form>
            </div>
           
    <div class='mesaj'>
    <a href='mesaj_gonder.php?gonderen_id={$_SESSION['uye_id']}&alici_id={$ilan_sahibi_id}'>
        <input type='submit' class='btn' value='Mesaj Gönder' name='ekle'><i class='fa-regular fa-message'></i>
    </a>
    </div>


        </div>
    </div>";
   $ilan_detay->close();
} else {
    echo "Geçerli bir ilan ID belirtilmedi.";
}

$baglanti->close();
?>

            </article>
    </div>

    <script src="site.js"></script>
  
</body>

</html>