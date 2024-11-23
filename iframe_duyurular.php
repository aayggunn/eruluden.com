<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İframe Duyurular</title>
    <link rel="stylesheet" href="iframe_duyurular.css">

</head>
<body>
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


            // Iterate through each announcement
            foreach ($html->find('.col-lg-9 a') as $element) {
                // Extract date and content
                $tarih = trim($element->find('.date-bg', 0)->plaintext);
                $icerik = trim($element->find('.mt-1 ', 0)->plaintext);
                $duyuruLink = 'https://www.erciyes.edu.tr/' . $element->find('.mt-1 a', 0)->href;

                // Output HTML for each announcement
                echo '<div class="duyuru-listesi">';
                echo '<div class="resim">';
                echo '<img src="duyuruu.jpeg" alt="">'; // Placeholder for image source
                echo '</div>';
                echo '<div class="duyuru">';
                echo '<p><a href="' . htmlspecialchars($duyuruLink, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($icerik, ENT_QUOTES, 'UTF-8') . '</a></p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
    </article>
</body>

</html>
