<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | Duyurular</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="dduyurular.css">
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
				<?php
					require 'simple_html_dom.php';

					$url = 'https://www.erciyes.edu.tr/tr/2/duyurular/ogrenci-duyurulari/';

						
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
						curl_close($ch);

						
						$html = str_get_html($response);

						// Duyuruları içeren div
						echo '<div class="duyuru-listesi">';

						foreach ($html->find('.col-lg-9 a') as $element) {
							$tarih = trim($element->find('.date-bg', 0)->plaintext);
							$icerik = trim($element->find('.mt-1', 0)->plaintext);
							$duyuruLink = 'https://www.erciyes.edu.tr/' . $element->href;
							echo '<div class="duyuru">';
							echo '<p>Tarih: ' . $tarih . '</p>';
							echo '<p><a href="' . $duyuruLink . '" target="_blank" class="alt" >' . $icerik . '</a></p>';
							echo '</div><hr>';
						}

						echo '</div>'; // duyuru-listesi div'i kapat
						?>
			</article>

	</div>



</body>

</html>