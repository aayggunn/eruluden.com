<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | Haberler</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="hhaberler.css">
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



</body>

</html>