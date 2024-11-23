<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | Burslar</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="bburslar.css">
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

	$url = 'https://www.guncel-egitim.org/burslar/';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);

	$html = str_get_html($response);

	echo '<div class="staj-listesi">';

	foreach ($html->find('.post') as $element) {
		$baslik = trim($element->find('.title a', 0)->plaintext);
		$stajLink = $element->find('.title a', 0)->href;

		echo '<div class="staj">';
		echo '<p><a href="' . $stajLink . '" target="_blank" class="alt">' . $baslik . '</a></p>';  
		echo '</div>';
	}

	echo '</div>';
?>

			</article>

	</div>



</body>

</html>