<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İframe Haberler</title>
    <link rel="stylesheet" href="iframe_yemekhane.css">
</head>
<body>
    <article>

      
        <?php
        require 'simple_html_dom.php';

        $url = 'https://www.erciyes.edu.tr/tr/2/personel-yemek-listesi';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $html = str_get_html($response);

        // Yemek menüsünü içeren div
        echo '<div class="yemek-menu">';

        $gun = '';
        foreach ($html->find('.yemekListesiBlok li') as $element) {
            $tarihElement = $element->find('.title', 0);
            if ($tarihElement) {
                $gun = trim($tarihElement->plaintext);
                echo '<div class="gun">' . $gun . '</div>';
            }

            $yemekElement = $element->find('.position', 0);
            if ($yemekElement) {
                $yemekAdi = trim(explode(" ", $yemekElement->plaintext, 2)[0]);
                $kalori = trim(explode(" ", $yemekElement->plaintext, 2)[1]);
                
                echo '<div class="yemek">';
                echo $yemekAdi . '<br>';
                echo $kalori . ' Kalori' . '<br>';
                echo '</div>';
            }
        }
        echo '</div>'; // yemek-menu div'i kapat
    ?>

    </article>
</body>
</html>