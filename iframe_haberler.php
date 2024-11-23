<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="iframe_haberler.css">
	<title>Document</title>
</head>
<body>
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
								<img src="' . $resimSrc . '" alt="' . $baslik . '">
								<h2>' . $baslik . '</h2>
								<p>' . $icerik . '</p>
								<p>Tarih: ' . $tarih . '</p> <!-- Tarih ekrana yazdırıldı -->
							  </div><hr>';
					}
				?>
</body>
</html>
