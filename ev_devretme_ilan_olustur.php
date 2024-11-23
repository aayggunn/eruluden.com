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
    <title>Erülüden | Ev Devretme Kiralama</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="ikinci_el_ilan_olustur.css">
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
                <div class="olustur">
                    <div class="duzen">
                    <a href = "ev_devretme.php"><div class="buton">
                    <input type="submit" class="btn" value="Geri Dön" name="ekle"><i class="fa-solid fa-arrow-left"></i></input>
                </div></a>
				<?php
include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Girdileri temizle ve filtrele
    $baslik = htmlspecialchars($_POST["baslik"]);
    $yazi = htmlspecialchars($_POST["yazi"]);
    $fiyat = floatval($_POST["fiyat"]); // Güvenli bir şekilde float olarak dönüştür

    // Oturum açmış kullanıcının id'sini al
    if (isset($_SESSION["uye_id"]) && is_numeric($_SESSION["uye_id"])) {
        $kullanici_id = intval($_SESSION["uye_id"]);

        // Resim yükleme işlemleri
        $resim_klasor = "ilan_resimleri/"; // Resimlerin yükleneceği klasör
        $resim_ad = $_FILES["resim"]["name"]; // Yüklenen resmin adı
        $resim_yol = $resim_klasor . $resim_ad; // Resmin tam yolu

        // Resimi klasöre kaydet
        move_uploaded_file($_FILES["resim"]["tmp_name"], $resim_yol);

        // İlanları veritabanına kaydet
        $ekle_ilanlar1 = $baglanti->prepare("INSERT INTO eruluden_ev_devretme_kiralama_ilanlar (uye_id, ilan_baslik, ilan_yazi, ilan_fiyat, ilan_resim) VALUES (?, ?, ?, ?, ?)");
        $ekle_ilanlar1->bind_param("issss", $kullanici_id, $baslik, $yazi, $fiyat, $resim_yol);
        $ekle_ilanlar1->execute();
        $ekle_ilanlar1->close();

        $ekle_ilanlar2 = $baglanti->prepare("INSERT INTO eruluden_ilanlar (uye_id, ilan_baslik, ilan_yazi, ilan_fiyat, ilan_resim) VALUES (?, ?, ?, ?, ?)");
        $ekle_ilanlar2->bind_param("issss", $kullanici_id, $baslik, $yazi, $fiyat, $resim_yol);
        $ekle_ilanlar2->execute();
        $ekle_ilanlar2->close();
		
		echo "İlanınız başarıyla yüklendi.";
        exit;
    } else {
        echo "Oturum açmış bir kullanıcı bulunamadı.";
    }

    $baglanti->close();
}
?>

<h1 class="add">İlan Ekle</h1>
<div class="form-container">
    <form action="ev_devretme_ilan_olustur.php" method="POST" enctype="multipart/form-data">
        <label for="title">İlan Başlığı Girin:</label>
        <input type="text" id="title" name="baslik" required>

        <label for="content">İlan İçeriği Girin:</label>
        <textarea id="content" name="yazi" rows="4" required></textarea>

        <label for="price">ilan Fiyatı Girin:</label>
        <input type="text" id="price" name="fiyat" required>

        <label for="image">İlan Resmi Yükleyin:</label>
        <input type="file" id="image" name="resim" accept="image/*" required>

        <input type="submit" value="İlanı Oluştur" name="ikinci_el_esya_ilan_olustur" class="button">
    </form>
</div>
                    </div>
                </div>
			

            </article>
    </div>

    <script src="site.js"></script>
  
</body>

</html>