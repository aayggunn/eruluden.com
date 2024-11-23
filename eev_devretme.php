<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | Ev Devretme - Kiralama</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="eev_devretme.css">
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
				<div class="kutu">
					<div class="kutu-alt">
					<a href = "login.php"><div class="buton">
                    <input type="submit" class="btn" value="İlan Ekle" name="ekle"><i class="fa-solid fa-pen"></i></input>
                </div></a>
              <?php
								
					include("baglanti.php");

					$limit = 10;
					$offset = isset($_GET['id']) ? $_GET['id'] : 0;

					$toplam = $baglanti->query("SELECT count(*) FROM eruluden_ev_devretme_kiralama_ilanlar");
					$sayfa_sayisi = $toplam->fetch_row()[0]; // Sayfa sayısını direkt olarak alıyoruz
					$toplam->close();

					$ilan = $baglanti->prepare("SELECT i.ilan_id, i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat FROM eruluden_ev_devretme_kiralama_ilanlar i INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id ORDER BY i.ilan_id DESC LIMIT ? OFFSET ?");
					$ilan->bind_param("ii", $limit, $offset);
					$ilan->execute();
					$ilan->store_result();
					$ilan->bind_result($ilan_id, $ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat);

					while ($ilan->fetch()) {
						if (strlen(strip_tags($ilan_yazi)) > 50) {
							$ilan_yazi = substr(strip_tags($ilan_yazi), 0, 50) . '...';
						}

						echo "<div class='ilan'>
							<h5>{$ilan_baslik}</h5>
							<i>{$ilan_tarih} tarihinde {$kullanici_adi} tarafından paylaşıldı</i>
							<p>{$ilan_yazi} ... <a href='eev_devretme_ilan.php?id={$ilan_id}'>Devamını Göster</a></p>";

						if (!empty($ilan_fiyat)) {
							echo "<p>Fiyat: {$ilan_fiyat} TL </p>";
						}

						echo "</div>\n";
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



</body>

</html>