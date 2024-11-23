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
    <title>Erülüden | Haberler</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="haberler.css">
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
                <div class="haber-kutu">
				<?php
					require 'simple_html_dom.php';

					// Hedef URL
					$url = 'https://www.sondakika.com/kayseri/';

					// cURL örneği
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$response = curl_exec($ch);
					curl_close($ch);

					// HTML'i işle
					$html = str_get_html($response);

					// Haberleri al ve işle
					foreach ($html->find('.fl li') as $element) {
						$resimElement = $element->find('img.lazy', 0); // Resim etiketini seç
						$resimSrc = $resimElement ? $resimElement->getAttribute('data-original') : ''; // Resim src değerini al
						$baslik = $element->find('.content', 0)->plaintext;
						$icerik = $element->find('.news-detail', 0)->plaintext;
						$tarihElement = $element->find('.hour.data_calc', 0); // Tarih etiketini seç
						$tarih = $tarihElement ? $tarihElement->title : ''; // Tarih verisini al
						
						echo '<div class="haber">
								<div class="img-kutu">
									<img src="' . $resimSrc . '" alt="' . $baslik . '">
								</div>
								<h2><label class="baslik">' . $baslik . '</label></h2>
								<div class="icerik-kutu">
									<p>' . $icerik . '</p>
								</div>
								<i>Tarih: ' . $tarih . '</i> <!-- Tarih ekrana yazdırıldı -->
							  </div><hr>';
					}
				?>
                </div>


			</article>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

</body>

</html>