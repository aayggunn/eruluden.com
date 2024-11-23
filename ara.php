<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["kullanici_adi"])) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="ara.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <title>Erülüden | Arama Yap</title>
</head>
<body>
    <div class="ara-kutu">
        <div class="ara">
            <form method="POST" action="ara.php">
                <input type="text" name="aranan_kelime" placeholder="Arama Yapın">
                <button type="submit" value="Ara" class="src"><label><i class="fa-solid fa-magnifying-glass"></i></label></button>
            </form>
            <h2>Arama Sonuçları</h2>

            <?php
            include("baglanti.php");

            if (isset($_POST["aranan_kelime"])) {
                $aranan_kelime = "%" . $_POST["aranan_kelime"] . "%";

               $arama_sorgu = $baglanti->prepare("
                    SELECT 'İkinci El Eşya İlanları' AS kategori, ilan_baslik AS sonuc, ilan_id AS id, ilan_resim AS resim, NULL AS profil_resmi, NULL AS ad, NULL AS dosya_yolu
                    FROM eruluden_ikinci_el_ilanlar
                    WHERE ilan_baslik LIKE ?
                    UNION
                    SELECT 'Ev Devretme İlanları' AS kategori, ilan_baslik AS sonuc, ilan_id AS id, ilan_resim AS resim, NULL AS profil_resmi, NULL AS ad, NULL AS dosya_yolu
                    FROM eruluden_ev_devretme_kiralama_ilanlar
                    WHERE ilan_baslik LIKE ?
                    UNION
                    SELECT 'Ev Arkadaşı İlanları' AS kategori, ilan_baslik AS sonuc, ilan_id AS id, ilan_resim AS resim, NULL AS profil_resmi, NULL AS ad, NULL AS dosya_yolu
                    FROM eruluden_ev_arkadasi_ilanlar
                    WHERE ilan_baslik LIKE ?
                    UNION
                    SELECT 'Üyeler' AS kategori, u.ad AS sonuc, u.uye_id AS id, NULL AS resim, r.pp_path AS profil_resmi, u.ad AS ad, NULL AS dosya_yolu
                    FROM eruluden_uyeler u
                    LEFT JOIN eruluden_profil_resimleri r ON u.uye_id = r.uye_id
                    WHERE u.ad LIKE ?
                    UNION
                    SELECT 'Ders Notları' AS kategori, ders_notu_baslik AS sonuc, ders_notu_id AS id, NULL AS resim, NULL AS profil_resmi, NULL AS ad, ders_notu_path AS dosya_yolu
                    FROM eruluden_ders_notu
                    WHERE ders_notu_baslik LIKE ?
                ");

                if ($arama_sorgu === false) {
                    die('Sorgu hazırlama hatası: ' . $baglanti->error);
                }

                // 5 adet parametre geçiriyoruz
                $arama_sorgu->bind_param("sssss", $aranan_kelime, $aranan_kelime, $aranan_kelime, $aranan_kelime, $aranan_kelime);
                $arama_sorgu->execute();

                // Sonuçları almak için değişkenler tanımlayın
                $kategori = '';
                $sonuc = '';
                $id = '';
                $resim = '';
                $profil_resmi = '';
                $ad = '';
                $dosya_yolu = '';

                $arama_sorgu->bind_result($kategori, $sonuc, $id, $resim, $profil_resmi, $ad, $dosya_yolu);

// Sonuçları gruplamak için bir dizi oluşturun
$sonuclar = array();

while ($arama_sorgu->fetch()) {
    $sonuclar[$kategori][] = array('sonuc' => $sonuc, 'id' => $id, 'dosya_yolu' => $dosya_yolu, 'profil_resmi' => $profil_resmi, 'ad' => $ad, 'resim' => $resim);
}


                // Her kategori için sonuçları gösterin
                foreach ($sonuclar as $kategori => $sonucListesi) {
                   
                   
                    foreach ($sonucListesi as $sonuc) {
                        if ($kategori === 'İkinci El Eşya İlanları') {
							 echo "<div class='kutu-alan'>";
							echo "<div class='kutular'>";
                            echo "<div class='resim'>";
                            echo "<img src='{$sonuc['resim']}' alt='İlan Resmi'>";
                            echo "</div>";
                            echo "<div class='icerik'>";
                            echo "<p><a href='ikinci_el_esya_ilan.php?id={$sonuc['id']}'>{$sonuc['sonuc']}</a></p>";
                            echo "</div>";
                            echo "<div class='kat'>";
                            echo "<h3>{$kategori}</h3>";
                            echo "</div></div></div>";
                        } else if ($kategori === 'Ev Devretme İlanları') {
							 echo "<div class='kutu-alan'>";
							 echo "<div class='kutular'>";
                            echo "<div class='resim'>";
                            if (!empty($sonuc['resim'])) {
                                echo "<img src='{$sonuc['resim']}' alt='İlan Resmi'>";
                            } else {
                                echo "<img src='default.jpg' alt='Varsayılan Resim'>";
                            }
                            echo "</div>";
                            echo "<div class='icerik'>";
                            echo "<p><a href='ev_devretme_ilan.php?id={$sonuc['id']}'>{$sonuc['sonuc']}</a></p>";
                            echo "</div>";
                            echo "<div class='kat'>";
                            echo "<h3>{$kategori}</h3>";
                            echo "</div></div></div>";
                        } else if ($kategori === 'Ev Arkadaşı İlanları') {
							 echo "<div class='kutu-alan'>";
							 echo "<div class='kutular'>";
                            echo "<div class='resim'>";
                            if (!empty($sonuc['resim'])) {
                                echo "<img src='{$sonuc['resim']}' alt='İlan Resmi'>";
                            } else {
                                echo "<img src='default.jpg' alt='Varsayılan Resim'>";
                            }
                            echo "</div>";
                            echo "<div class='icerik'>";
                            echo "<p><a href='ev_arkadasi_ilan.php?id={$sonuc['id']}'>{$sonuc['sonuc']}</a></p>";
                            echo "</div>";
                            echo "<div class='kat'>";
                            echo "<h3>{$kategori}</h3>";
                            echo "</div></div></div>";
                        }  else if ($kategori === 'Üyeler') {
							 echo "<div class='kutu-alan'>";
							 echo "<div class='kutular'>";
                            echo "<div class='resim'>";
                            if (!empty($sonuc['profil_resmi'])) {
                                echo "<img src='{$sonuc['profil_resmi']}' alt='Profil Resmi'>";
                            } else {
                                echo "<img src='default.jpg' alt='Varsayılan Resim'>";
                            }
                            echo "</div>";
                            echo "<div class='icerik'>";
                            echo "<p><a href='kullanici.php?id={$sonuc['id']}'>{$sonuc['ad']}</a></p>";
                            echo "</div>";
                            echo "<div class='kat'>";
                            echo "<h3>{$kategori}</h3>";
                            echo "</div></div></div>";
                        } else if ($kategori === 'Ders Notları') {
    echo "<div class='kutu-alan'>";
    echo "<div class='kutular'>";
    echo "<div class='resim'>";
    echo "<img src='document.ico' alt='Ders Notu İkonu'></img>";
    echo "</div>";
    echo "<div class='icerik'>";
    // Dosyanın yolunu kullanarak bağlantıyı oluşturun
    echo "<p><a href='{$sonuc['dosya_yolu']}' download>{$sonuc['sonuc']}</a></p>";
    echo "</div>";
    echo "<div class='kat'>";
    echo "<h3>{$kategori}</h3>";
    echo "</div></div></div>";
}



                    }
                }

                // Bağlantıları kapatın
                $arama_sorgu->close();
                mysqli_close($baglanti);
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
</body>

</html>