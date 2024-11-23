<?php

	session_start();
	
	if(isset($_SESSION["kullanici_adi"]))
	{
		
	}
	
	else 
	{
		header("location: login.php");
	}
?>
<?php
	include("baglanti.php");

	// Kullanıcının oturum yönetiminden alınan ID'si
	$uye_id = $_SESSION['uye_id'];

	// Veritabanından kullanıcı bilgilerini çekme işlemi
	$sql = "SELECT ad, kullanici_adi, hakkimda FROM eruluden_uyeler WHERE uye_id = ?";
	$stmt = $baglanti->prepare($sql);
	$stmt->bind_param("i", $uye_id);
	$stmt->execute();
	$stmt->bind_result($ad, $kullanici_adi, $hakkimda);
	$stmt->fetch();
	$stmt->close();

	// Profil resmi yolu al
	$sql_resim = "SELECT pp_path FROM eruluden_profil_resimleri WHERE uye_id = ?";
	$stmt_resim = $baglanti->prepare($sql_resim);
	$stmt_resim->bind_param("i", $uye_id);
	$stmt_resim->execute();
	$stmt_resim->bind_result($profil_resmii);
	$stmt_resim->fetch();
	$stmt_resim->close();

	$baglanti->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erülüden | Üye</title>
    <link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="kullanici.css">
	
</head>

<body>
    <div class="wrapper">
        <header class="baslik">
            <h1><a href="anasayfa.php">ERULUDEN</a></h1>

            <div class="navbar">
                <ul>
                    <li> <a class="aktif" href="anasayfa.php">
                            <i class="fa-solid fa-house"></i>
                            <label for="anasayfa" class="text"> Anasayfa</label>
                        </a></li>
                    <li><a href="ilanlar.php"> <i class="fa-solid fa-rectangle-ad"></i> <label for="ilanlar"
                                class="text"> İlanlar</label></a>
                    </li>
                    <li><a href="duyurular_haberler.php"> <i class="fa-solid fa-bullhorn"></i> <label for="duyurular"
                                class="text"> Duyurular-Haberler</label> </a> </li>
                    <li><a href="ders_notu.php"> <i class="fa-regular fa-note-sticky"></i> <label for="sorular"
                                class="text"> Notlar</label></a> </li>
                    <li><a href="kampus.php"> <i class="fa-regular fa-building"></i><label for="kampus" class="text">
                                Kampus-Yurtlar</label>
                        </a></li>
                </ul>
            </div>
            <nav class="sidebar close">
                <div class="logo-part">
                    <img src="logo1.jpg" alt="profil resmi">
                </div>
                <header class="sider">
                    <div class="image-text">
                        <span class="image">
                        <?php 
									if (!empty($profil_resmii)) { ?>
									<img src="<?php echo $profil_resmii; ?>" alt="Profil Resmi">
									<?php }
									
									else { ?>
									<img src="default.jpg" alt="Profil Resmi">
									<?php } 
								?>

                        </span>
                    </div>
                </header>
                <div class="sidemenu">
                    <div class="menu1">
                        <ul class="menu-links">
                            <li class="nav-link">
                                <a class="side" href="profil.php">
                                    <i class="fa-regular fa-user icon"></i>
                                </a>
                            </li>
                            <li class="nav-link">
                            <a class="side" href="mesaj_kutusu.php">
                                        <i class="fa-solid fa-inbox icon"></i>   
                                </a>
                            </li>
                            <li class="nav-link">
                            <a class="side" href="ara.php">
                            <i class="fa-solid fa-magnifying-glass icon"></i>  
                                </a>
                            </li>
                            <li class="nav-link">
                                <a class="side" href="iletisim.php">
                                    <i class="fa-solid fa-phone icon"></i>
                                </a>
                            </li>
                            <li class="nav-link">
                                <a class="side" href="hakkimizda.php">
                                    <i class="fa-solid fa-briefcase icon"></i>
                                </a>
                            </li>
                            <li class="nav-link">
                                <a class="side" href="cikis.php">
                                    <i class="fa-solid fa-xmark icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <article class="alan">
				<div class="profill-kutu">
                    <div class="profil-bilgileri">
    <?php
    session_start();
    include("baglanti.php");

    if (isset($_GET['id'])) {
        $ziyaret_edilen_uye_id = $_GET['id'];

        // Ziyaret edilen kullanıcının bilgilerini çekme işlemi
        $sql = "SELECT ad, kullanici_adi, hakkimda FROM eruluden_uyeler WHERE uye_id = ?";
        $stmt = $baglanti->prepare($sql);
        $stmt->bind_param("i", $ziyaret_edilen_uye_id);
        $stmt->execute();
        $stmt->bind_result($ad, $kullanici_adi, $hakkimda);
        $stmt->fetch();
        $stmt->close();

        // Ziyaret edilen kullanıcının profil resmini çekme işlemi
        $sql_resim = "SELECT pp_path FROM eruluden_profil_resimleri WHERE uye_id = ?";
        $stmt_resim = $baglanti->prepare($sql_resim);
        $stmt_resim->bind_param("i", $ziyaret_edilen_uye_id);
        $stmt_resim->execute();
        $stmt_resim->bind_result($profil_resmi);
        $stmt_resim->fetch();
        $stmt_resim->close();

        // Ziyaret edilen kullanıcının bilgilerini ve profil resmini gösterme
        echo "<div class='proffil'>";
        echo "<h2><label class='profil'>Profil Bilgileri</label></h2>";
        echo "<div class='pro'>";
        echo "<div class='profil-resmi'>";
        if (!empty($profil_resmi)) {
            echo "<img src='{$profil_resmi}' alt='Profil-resmi'>";
        } else {
            echo "<img src='default.jpg' alt='Profil Resmi'>";
        }
        echo "</div>";
        echo "<div class='mesaj-button'>";
        echo "<button><label class='send'><a href='mesaj_gonder.php?gonderen_id={$_SESSION['uye_id']}&alici_id={$ziyaret_edilen_uye_id}'>Mesaj Gönder</a></label></button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<div class='profil-bilgi'>";
        echo "<div class='kbilgi'>";
        echo "<p><strong>Ad:</strong> {$ad}</p>";
        echo "<p><strong>Kullanıcı Adı:</strong> {$kullanici_adi}</p>";
        echo "<p><strong>Hakkımda:</strong> {$hakkimda}</p>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>Kullanıcı ID'si eksik veya hatalı.</p>";
    }
    ?>
    <div class="ilanlarim">
        <div class="kutularim">
            <h4>İkinci El Eşya İlanları</h4>
            <?php
            // Kullanıcının paylaştığı ikinci el eşya ilanlarını çek ve görüntüle
            $ilan_sql = "SELECT ilan_baslik, ilan_resim, ilan_fiyat FROM eruluden_ikinci_el_ilanlar WHERE uye_id = ?";
            $ilan_stmt = $baglanti->prepare($ilan_sql);
            $ilan_stmt->bind_param("i", $ziyaret_edilen_uye_id);
            $ilan_stmt->execute();
            $ilan_stmt->store_result();
            $ilan_stmt->bind_result($ilan_baslik, $ilan_resim, $ilan_fiyat);

            if ($ilan_stmt->num_rows > 0) {
                while ($ilan_stmt->fetch()) {
                    echo "<div class='kutu'>";
                    echo "<div class='ilan'>";
                    echo "<h5>{$ilan_baslik}</h5>";
                    echo "<img src='{$ilan_resim}' alt='İlan Resmi'>";

                    if (!empty($ilan_fiyat)) {
                        echo "<p>Fiyat: {$ilan_fiyat} TL</p>";
                    }

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Kullanıcının ikinci el eşya ilanı yok.</p>";
            }

            $ilan_stmt->close();
            ?>
        </div>
    </div>
    <div class="ilanlarim">
        <div class="kutularim">
            <h4>Ev Devretme/Kiralama İlanları</h4>
            <?php
            // Kullanıcının paylaştığı ev devretme/kiralama ilanlarını çek ve görüntüle
            $ilan_sql = "SELECT ilan_baslik, ilan_resim, ilan_fiyat FROM eruluden_ev_devretme_kiralama_ilanlar WHERE uye_id = ?";
            $ilan_stmt = $baglanti->prepare($ilan_sql);
            $ilan_stmt->bind_param("i", $ziyaret_edilen_uye_id);
            $ilan_stmt->execute();
            $ilan_stmt->store_result();
            $ilan_stmt->bind_result($ilan_baslik, $ilan_resim, $ilan_fiyat);

            if ($ilan_stmt->num_rows > 0) {
                while ($ilan_stmt->fetch()) {
                    echo "<div class='kutu'>";
                    echo "<div class='ilan'>";
                    echo "<h5>{$ilan_baslik}</h5>";
                    echo "<img src='{$ilan_resim}' alt='İlan Resmi'>";

                    if (!empty($ilan_fiyat)) {
                        echo "<p>Fiyat: {$ilan_fiyat} TL</p>";
                    }

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Kullanıcının ev devretme/kiralama ilanı yok.</p>";
            }

            $ilan_stmt->close();
            ?>
        </div>
    </div>
    <div class="ilanlarim">
        <div class="kutularim">
            <h4>Ev Arkadaşı İlanları</h4>
            <?php
            // Kullanıcının paylaştığı ev arkadaşı ilanlarını çek ve görüntüle
            $ilan_sql = "SELECT ilan_baslik, ilan_resim, ilan_fiyat FROM eruluden_ev_arkadasi_ilanlar WHERE uye_id = ?";
            $ilan_stmt = $baglanti->prepare($ilan_sql);
            $ilan_stmt->bind_param("i", $ziyaret_edilen_uye_id);
            $ilan_stmt->execute();
            $ilan_stmt->store_result();
            $ilan_stmt->bind_result($ilan_baslik, $ilan_resim, $ilan_fiyat);

            if ($ilan_stmt->num_rows > 0) {
                while ($ilan_stmt->fetch()) {
                    echo "<div class='kutu'>";
                    echo "<div class='ilan'>";
                    echo "<h5>{$ilan_baslik}</h5>";
                    echo "<img src='{$ilan_resim}' alt='İlan Resmi'>";

                    if (!empty($ilan_fiyat)) {
                        echo "<p>Fiyat: {$ilan_fiyat} TL</p>";
                    }

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Kullanıcının ev arkadaşı ilanı yok.</p>";
            }

            $ilan_stmt->close();
            ?>
			 </div>
			  </div>
        </div>
    </div>
</article>

    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>


</body>

</html>