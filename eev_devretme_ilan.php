<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | İlan</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="eev_devretme_ilan.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
	<div class="wrapper">
	<header class="baslik">
			<div class="logo-part">
				<img src="logo1.jpg" alt="profil resmi">
			</div>
			<h1><a href="index.html">ERULUDEN</a></h1>

		</header>
		<hr>
		</hr>

		<div class="navbar">
			<ul>
				<li>
					<p class="log"><a href="login.php">Giriş Yap</a></p>
					<p class="log"><a href="kayit.php">Üye Ol</a></p>
				</li>
				<li> <a class="aktif" href="index.html">
						<i class="fa-solid fa-house"></i>
						<label for="anasayfa" class="text">Anasayfa</label>
					</a></li>
				<li><a href="iilanlar.html"> <i class="fa-solid fa-rectangle-ad"></i> <label for="ilanlar"
							class="text">İlanlar</label> </a>
				</li>
				<li><a href="dduyurular_haberler.html"> <i class="fa-solid fa-bullhorn"></i> <label for="duyurular"
							class="text">Duyurular-Haberler</label> </a> </li>
				<li><a href="dders_notu.php"> <i class="fa-regular fa-note-sticky"></i> <label for="sorular"
							class="text">Notlar</label></a> </li>
				<li><a href="kkampus.html"> <i class="fa-regular fa-building"></i><label for="kampus" class="text">
							Kampüs-Yurtlar</label> </a></li>

			</ul>

		</div>
			<article>
				<div class="ilan-kutu">
					<div class="ilan-kutu">
					<?php
					include("baglanti.php");

					if (isset($_GET['id']) && is_numeric($_GET['id'])) {
						$ilan_id = intval($_GET['id']);
						
						$ilan_detay = $baglanti->prepare("SELECT i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat FROM eruluden_ev_devretme_kiralama_ilanlar i INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id WHERE i.ilan_id = ?");
						$ilan_detay->bind_param("i", $ilan_id);
						$ilan_detay->execute();
						$ilan_detay->bind_result($ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat);
						$ilan_detay->fetch();
						
						echo "<div class='ilan-detay'>
            <div class='img-box'>
                <img src='{$ilan_resim}' alt=''>
            </div>
            <i><label>$ilan_tarih tarihinde <a href='login.php'>$kullanici_adi</a> tarafından paylaşıldı</label></i>
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
	<a href='login.php'>
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
					</div>
				
				</div>
			
			</article>

	</div>



</body>

</html>