<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İframe İkinci El</title>
    <link rel="stylesheet" href="iframe_ev_arkadasi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <article>
        <?php
        include("baglanti.php");

        $limit = 10;
        $offset = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $toplam = $baglanti->query("SELECT COUNT(*) FROM eruluden_ikinci_el_ilanlar");
        $sayfa_sayisi = $toplam->fetch_row()[0]; // Toplam ilan sayısını al
        $toplam->close();

        $ilan = $baglanti->prepare("SELECT i.ilan_id, i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat, i.ilan_resim
                                    FROM eruluden_ikinci_el_ilanlar i 
                                    INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id 
                                    ORDER BY i.ilan_id DESC 
                                    LIMIT ? OFFSET ?");
        $ilan->bind_param("ii", $limit, $offset);
        $ilan->execute();
        $ilan->store_result();
        $ilan->bind_result($ilan_id, $ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat, $ilan_resim);

        while ($ilan->fetch()) {
            if (strlen(strip_tags($ilan_yazi)) > 50) {
                $ilan_yazi = substr(strip_tags($ilan_yazi), 0, 50) . '...';
            }

            echo "<div class='ilan'>";
            echo '<div class="resim">';
            echo "<img src='{$ilan_resim}' alt=''>"; // Resim kaynağını buraya ekleyin
            echo '</div>';
            echo '<div class="bilgi">';
            echo "<h5><strong>{$ilan_baslik}</strong></h5>";
            if (!empty($ilan_fiyat)) {
                echo "<p>Fiyat: {$ilan_fiyat} TL</p>";
            }
            echo '</div>';
            echo "</div>\n";
        }

        if ($sayfa_sayisi > $limit) {
            $x = 0;
            for ($i = 0; $i < $sayfa_sayisi; $i += $limit) {
                $x++;
                echo "<a href='?id=$i'>[$x]</a> ";
            }
        }

        $ilan->close();
        $baglanti->close();
        ?>
    </article>
</body>
</html>