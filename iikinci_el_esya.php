<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | İkinci El Eşya</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="iikinci_el.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2063708385257899"
     crossorigin="anonymous"></script>
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
				<li> <a class="aktif" href="aanasayfa.html">
						<i class="fa-solid fa-house"></i>
						<label for="anasayfa" class="text">Anasayfa</label>
					</a></li>
				<li><a href="iikinci_el_esya.php"> <i class="fa-solid fa-rectangle-ad"></i> <label for="ilanlar"
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
			<article class="alan">
    <div class="kutular">
        <div class="ikinci">
            <div class="buton">
			<i class="fa-solid fa-pen"></i>
                <a href="login.php">
                    <input type="submit" class="btn" value="İlan Ekle" name="ekle">
                    
                </a>
            </div>

            <?php
            include("baglanti.php");

            $limit = 10;
            $offset = isset($_GET['id']) ? $_GET['id'] : 0;

            // Toplam ilan sayısını alıyoruz
            $toplam = $baglanti->query("SELECT count(*) FROM eruluden_ikinci_el_ilanlar");
            $sayfa_sayisi = $toplam->fetch_row()[0];
            $toplam->close();

            // İlanları çekiyoruz
            $ilan = $baglanti->prepare("SELECT i.ilan_id, i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat, i.ilan_resim 
                                        FROM eruluden_ikinci_el_ilanlar i 
                                        INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id 
                                        ORDER BY i.ilan_id DESC LIMIT ? OFFSET ?");
            $ilan->bind_param("ii", $limit, $offset);
            $ilan->execute();
            $ilan->store_result();
            $ilan->bind_result($ilan_id, $ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat, $ilan_resim);

            // İlanları listeleme
            while ($ilan->fetch()) {
                if (strlen(strip_tags($ilan_yazi)) > 50) {
                    $ilan_yazi = substr(strip_tags($ilan_yazi), 0, 50) . '...';
                }

                echo "
                <div class='ilan'>
                    <h5 class='ilan_baslik'>{$ilan_baslik}</h5>
                    
                    <div class='bolum'>
                        <div class='img-box'>
                            <img src='{$ilan_resim}' alt='İlan Resmi'>
                        </div>
                        
                        <div class='aciklama'>
                            <p class='ilan_yazi'>{$ilan_yazi} <a href='iikinci_el_esya_ilan.php?id={$ilan_id}'>  ...devamını Göster</a></p>
                        </div>
                    </div>";

                if (!empty($ilan_fiyat)) {
                    echo "<p class='fyt'>Fiyat: {$ilan_fiyat} TL</p>";
                }

                echo "</div>";
            }

            // Sayfalama
            if ($sayfa_sayisi > $limit) {
                $x = 0;
                for ($i = 0; $i < $sayfa_sayisi; $i += $limit) {
                    $x++;
                    echo "<a href='?id=$i'>[$x]</a> ";
                }
            }

            $ilan->close();
            $baglanti->close();
            ?>

        </div>
    </div>
</article>


	</div>



</body>

</html>