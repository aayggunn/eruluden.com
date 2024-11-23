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
	$stmt_resim->bind_result($profil_resmi);
	$stmt_resim->fetch();
	$stmt_resim->close();

	$baglanti->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erülüden | Anasayfa</title>
    <link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="anasayfa.css">
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
									if (!empty($profil_resmi)) { ?>
									<img src="<?php echo $profil_resmi; ?>" alt="Profil Resmi">
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
                <div class="kutular">
                    <div class="ilan">
                    <div class="alt">
                        <h3><label class="baslik">İlanlar</label> <a href="ilanlar.php">Tümünü Gör</a></h3>
                        <a href="ilanlar.php" class="f">
                        <iframe src="iframe_ilanlar.php" frameborder="0" scrolling="no"></iframe>
                        </a>
                        </div>
                    </div>
                    <div class="ikinci">
                    <div class="duyuru">
                        <h3><label class="baslik">Duyurular</label><a href="duyurular.php">Tümünü Gör</a></h3>
                        <a href="duyurular.php" class="f">
                        <iframe src="iframe_duyurular.php" frameborder="0" scrolling="no"></iframe>
                        </a>
                        </div>
                    </div>
                    <div class="ucuncu">
                    <div class="haber">
                        <h3><label class="baslik">Haberler</label><a href="haberler.php">Tümünü Gör</a></h3>
                        <a href="haberler.php" class="f">
                        <iframe src="iframe_haberler.php" frameborder="0" scrolling="no"></iframe>
                        </a>
                        </div>
                    </div>
                    <div class="yemekhane">
                        <div class="yemek">
                            <h3>Bugünün Menüsü</h3>
                            <iframe src="iframe_yemekhane.php" frameborder="0" scrolling="no"></iframe>
                        </div>
                    </div>
                    <div class="burs-kutu">
                        <div class="burs">
                            <h3><label class="baslik">Burslar</label><a href="burslar.php">Tümünü Gör</a></h3>
                            <a href="burslar.php" class="f">
                            <iframe src="iframe_burslar.php" frameborder="0" scrolling="no"></iframe>
                            </a>
                        </div>
                    </div>
                </div>

            </article>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>


</body>

</html>