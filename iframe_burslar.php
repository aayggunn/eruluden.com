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
			$duyuruLink = 'https://www.guncel-egitim.org/' . $element->href;

            echo '<div class="ilan">';
            echo '<div class="resim">';
            echo '<img src="burs.jpeg" alt="">';
            echo '</div>';
            echo '<div class="bilgi">';
            echo '<p><a href="' . $stajLink . '" target="_blank">' . $baslik . '</a></p>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        ?>
    </article>
</body>

</html>

