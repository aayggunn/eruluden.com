<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="iframe_ilanlar.css">
</head>
<body>
    <article>
        <?php
								
					include("baglanti.php");

					$limit = 10;
					$offset = isset($_GET['id']) ? $_GET['id'] : 0;

					$toplam = $baglanti->query("SELECT count(*) FROM eruluden_ilanlar");
					$sayfa_sayisi = $toplam->fetch_row()[0]; // Sayfa sayısını direkt olarak alıyoruz
					$toplam->close();

					$ilan = $baglanti->prepare("SELECT i.ilan_id, i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat, i.ilan_resim FROM eruluden_ikinci_el_ilanlar i INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id ORDER BY i.ilan_id DESC LIMIT ? OFFSET ?");
					$ilan->bind_param("ii", $limit, $offset);
					$ilan->execute();
					$ilan->store_result();
					$ilan->bind_result($ilan_id, $ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat, $ilan_resim);

					while ($ilan->fetch()) {
						if (strlen(strip_tags($ilan_yazi)) > 50) {
							$ilan_yazi = substr(strip_tags($ilan_yazi), 0, 50) . '...';
						}

						echo "<div class='ilan'>
								<div class='resim'>
									<img src='{$ilan_resim}' alt=''>
								</div>
								<div class='bilgi'>
									<h5>{$ilan_baslik}</h5>             
								</div>
							</div>\n";
					}				
					$ilan->close();
					$baglanti->close();
			?>
    </article>
</body>
</html>