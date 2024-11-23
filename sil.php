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
    <title>Erülüden | Anasayfa</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="anasayfa.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>
    <div class="wrapper">
        <header class="baslik">
            <h1><a href="anasayfa.php">ERULUDEN</a></h1>
       
            <nav class="menu">
                <ul>
                    <li> <a class="aktif" href="anasayfa.php">
                            <i class="fa-solid fa-house"></i>
                            <label for="anasayfa" class="text">Anasayfa</label>
                        </a></li>

                    <li><a href="ilanlar.php"> <i class="fa-solid fa-rectangle-ad"></i> <label
                                for="ilanlar" class="text">İlanlar</label></a>                    
                    </li>
                    <li><a href="duyurular_haberler.php"> <i class="fa-solid fa-bullhorn"></i> <label for="duyurular"
                                class="text">Duyurular-Haberler</label> </a> </li>
                    <li><a href="ders_notu.php"> <i class="fa-regular fa-note-sticky"></i> <label for="sorular"
                                class="text">Notlar</label></a> </li>
                    <li><a href="kampus.php"> <i class="fa-regular fa-building"></i><label for="kampus" class="text">
                                Kampüs-Yurtlar</label>
                        </a></li>

                </ul>
            </nav>
            <section class="bolum1">
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
                                        <span class="text nav-text">Profil</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="ayarlar.php">
                                        <i class="fa-solid fa-gear icon"></i>
                                        <span class="text nav-text">Ayarlar</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="iletisim.php">
                                        <i class="fa-solid fa-phone icon"></i>
                                        <span class="text nav-text">İletişim</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="hakkimizda.php">
                                        <i class="fa-solid fa-briefcase icon"></i>
                                        <span class="text nav-text">Hakkımızda</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="cikis.php">
                                        <i class="fa-solid fa-xmark icon"></i>
                                        <span class="text nav-text">Çıkış Yap</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </section>
			<article class="alan">
				<a href = "profil.php"><div class="buton">
                    <input type="submit" class="btn" value="Geri Dön" name="ekle"><i class="fa-solid fa-arrow-left"></i></input>
                </div></a>
				<?php
				// Hata mesajlarını ekranda görüntülemek için kullanılır.
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $ilan_id = intval($_GET["id"]);

    // İlgili ilanı sil
    $sil_ilanlar1 = $baglanti->prepare("DELETE FROM eruluden_ikinci_el_ilanlar WHERE ilan_id = ?");
    $sil_ilanlar1->bind_param("i", $ilan_id);
    $sil_ilanlar1->execute();
    $sil_ilanlar1->close();
	
	$sil_ilanlar2 = $baglanti->prepare("DELETE FROM eruluden_ev_devretme_kiralama_ilanlar WHERE ilan_id = ?");
    $sil_ilanlar2->bind_param("i", $ilan_id);
    $sil_ilanlar2->execute();
    $sil_ilanlar2->close();
	
	$sil_ilanlar3 = $baglanti->prepare("DELETE FROM eruluden_ev_arkadasi_ilanlar WHERE ilan_id = ?");
    $sil_ilanlar3->bind_param("i", $ilan_id);
    $sil_ilanlar3->execute();
    $sil_ilanlar3->close();

    $sil_ilanlar4 = $baglanti->prepare("DELETE FROM eruluden_ilanlar WHERE ilan_id = ?");
    $sil_ilanlar4->bind_param("i", $ilan_id);
    $sil_ilanlar4->execute();
    $sil_ilanlar4->close();

    echo "İlan başarıyla silindi.";
} else {
    echo "İlan silme işlemi sırasında bir hata oluştu.";
}

$baglanti->close();
?>
			</article>

    </div>

  
</body>

</html>