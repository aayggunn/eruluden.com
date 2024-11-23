<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | Notlar</title>
	<meta name="keywords" content="mustafa balcı genel matematik pdf, serway fizik, genel fizik 1 ders notları, erciyes üniversitesi,erciyes universitesi,eru obisis,eru,google akademik,erü webmail,webmail,eru bm,eru,erudm,eruzem,eru kampus, erü kampüs">
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="dders_notu.css">
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
			<div class="kutu">
				<div class="not-kutu">
				<a href = "login.php"><div class="buton">
                    <input type="submit" class="btn" value="Dosya Yükle" name="ekle"><i class="fa-solid fa-file-arrow-up"></i></input>
                </div></a>
				<?php
					include("baglanti.php");

					// Veritabanından dosya bilgilerini tarih sırasına göre çek
					$sql = "SELECT * FROM eruluden_ders_notu ORDER BY ders_notu_tarih DESC"; // DESC: En yeni en üstte
					$result = $baglanti->query($sql);

					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$ders_notu_baslik = $row["ders_notu_baslik"];
							$ders_notu_path = $row["ders_notu_path"];
							$yukleme_tarihi = $row["ders_notu_tarih"];

							echo '<div class="not-listesi">';
							echo '    <div class="pdf">';
							echo '        <i class="fa-regular fa-file-pdf"></i>';
							echo '    </div>';
							echo '    <div class="not">';
							echo "        <i>$yukleme_tarihi</i>";
							echo "        <p>$ders_notu_baslik</p>";
							echo '    <div class="not-btn">';           
							echo "        <a href='login.php' target='_blank'>Dosya İndir<i class='fa-regular fa-circle-down'></i></a>";
							echo "        <a href='login.php' target='_blank'>Dosya Görüntüle<i class='fa-regular fa-file'></i></a>";
							echo '    </div>';
							echo '    </div>';
							echo '</div>';
						}
					} else {
						echo "Veritabanında dosya bulunmuyor.";
					}

					$baglanti->close();
					?>

				</div>
			</div>
				

			</article>

	</div>



</body>

</html>