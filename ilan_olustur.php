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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erülüden | İkinci El Eşya</title>
    <link rel="stylesheet" href="ilan_olustur.css">
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
			<a href = "ilan_ekle.php"><div class="buton">
                    <input type="submit" class="btn" value="İlan Ekle" name="ekle"><i class="fa-solid fa-pen"></i></input>
					<style> .buton{margin-left:400px;}</style>
                </div></a>
				<?php
				error_reporting(E_ALL);
ini_set('display_errors', '1');

include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Girdileri temizle ve filtrele
    $baslik = htmlspecialchars($_POST["baslik"]);
    $yazi = htmlspecialchars($_POST["yazi"]);
    $fiyat = floatval($_POST["fiyat"]); // Güvenli bir şekilde float olarak dönüştür

    // Oturum açmış kullanıcının id'sini al
    if (isset($_SESSION["uye_id"]) && is_numeric($_SESSION["uye_id"])) {
        $kullanici_id = intval($_SESSION["uye_id"]);

        // Veritabanına ilanı kaydet
        $ekle = $baglanti->prepare("INSERT INTO eruluden_ikinci_el_ilanlar (uye_id, ilan_baslik, ilan_yazi, ilan_fiyat) VALUES (?, ?, ?, ?)");
        $ekle->bind_param("isss", $kullanici_id, $baslik, $yazi, $fiyat);

        if ($ekle->execute()) {
            $ekle->close();
            exit; // İşlemi sonlandır
			header("location: ikinci_el_esya.php");
        } else {
            echo "İlan kaydedilirken bir hata oluştu.";
        }

    } else {
        echo "Oturum açmış bir kullanıcı bulunamadı.";
    }

    $baglanti->close();
}

?>


				 <h1 class="add">İlan Ekle</h1>
				  <div class="form-container">
					<form action="ilan_olustur.php" method="POST">
					  <label for="title">İlan Başlık:</label>
					  <input type="text" id="title" name="baslik" required>
					  <label for="content">İlan İçerik:</label>
					  <textarea id="content" name="yazi" rows="4" required></textarea>
					  <label for="price">Fiyat:</label>
					  <input type="text" id="price" name="fiyat" required>
					  <input type="submit" value="İlanı Ekle" class="button" name="ilan_olustur">
					</form>
				  </div>
            </article>
        </div>

        
    </body>
</html>
