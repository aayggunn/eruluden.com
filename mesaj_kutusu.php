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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="mesaj_kutusu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Erülüden | Mesaj Kutusu</title>
</head>

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
    <link rel="stylesheet" href="mesaj_kutusu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Mesaj Kutusu</title>
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
            <article class="mesaj">
                <div class="mesaj-kutu">

                
                <div class="mesaj-alan">
                   <?php

						include("baglanti.php");

						if (!isset($_SESSION["kullanici_adi"])) {
							header("location: login.php");
							exit;
						}

						$gonderen_id = $_SESSION['uye_id']; // Oturum açan kullanıcının ID'sini al

						// Kullanıcının aldığı veya gönderdiği son mesajları sorgula
						$son_mesajlar_sorgu = $baglanti->prepare("SELECT DISTINCT m1.gonderici_id, m1.alici_id, m1.mesaj, m1.tarih, 
																   IF(m1.gonderici_id = ?, m1.alici_id, m1.gonderici_id) AS muhatap_id
														  FROM eruluden_mesajlar AS m1
														  WHERE (m1.gonderici_id = ? OR m1.alici_id = ?)
														  AND m1.tarih = (SELECT MAX(tarih) FROM eruluden_mesajlar AS m2
																		 WHERE (m2.gonderici_id = m1.gonderici_id AND m2.alici_id = m1.alici_id) OR (m2.gonderici_id = m1.alici_id AND m2.alici_id = m1.gonderici_id))
														  ORDER BY m1.tarih DESC"); // Her muhatap için son mesajları getir
						if ($son_mesajlar_sorgu === false) {
							die('Sorgu hazırlama hatası: ' . $baglanti->error);
						}

						$son_mesajlar_sorgu->bind_param("iii", $gonderen_id, $gonderen_id, $gonderen_id);
						$son_mesajlar_sorgu->execute();
						$son_mesajlar_sorgu->store_result();

						if ($son_mesajlar_sorgu->num_rows > 0) {
							$son_mesajlar_sorgu->bind_result($mesaj_gonderici_id, $mesaj_alici_id, $mesaj_metni, $mesaj_tarihi, $muhatap_id);

							while ($son_mesajlar_sorgu->fetch()) {
								// Muhatap kullanıcısının adını ve profil resmini al
								$muhatap_adi = "";
								$profil_resmi_path = "";

								$muhatap_sorgu = $baglanti->prepare("SELECT kullanici_adi FROM eruluden_uyeler WHERE uye_id = ?");
								if ($muhatap_sorgu === false) {
									die('Sorgu hazırlama hatası: ' . $baglanti->error);
								}
								$muhatap_sorgu->bind_param("i", $muhatap_id);
								$muhatap_sorgu->execute();
								$muhatap_sorgu->bind_result($muhatap_adi);
								$muhatap_sorgu->fetch();
								$muhatap_sorgu->close();

								// Muhatap kullanıcısının profil resmini al
								$profil_resim_sorgu = $baglanti->prepare("SELECT pp_path FROM eruluden_profil_resimleri WHERE uye_id = ?");
								if ($profil_resim_sorgu === false) {
									die('Sorgu hazırlama hatası: ' . $baglanti->error);
								}
								$profil_resim_sorgu->bind_param("i", $muhatap_id);
								$profil_resim_sorgu->execute();
								$profil_resim_sorgu->bind_result($profil_resmi_path);
								$profil_resim_sorgu->fetch();
								$profil_resim_sorgu->close();
								
								?>
								<div class="mesaj-alan">
										<a href="mesaj_gonder.php?gonderen_id=<?php echo ($mesaj_alici_id == $gonderen_id) ? $mesaj_alici_id : $mesaj_gonderici_id; ?>&alici_id=<?php echo ($mesaj_alici_id == $gonderen_id) ? $mesaj_gonderici_id : $mesaj_alici_id; ?>">
										<div class="gelen">
											<div class="profil-kutu">
												<img src="<?php 
if (!empty($profil_resmi_path)) {
    echo $profil_resmi_path;
} else {
    echo 'default.jpg';
}
?>" alt="<?php echo $muhatap_adi; ?>">

											</div>
											<div class="yazi-alan">
												<h4>
													<?php echo $muhatap_adi; ?>
													<label class="tarih">
														<p class="date">
														<?php echo $mesaj_tarihi; ?>
														</p>
													</label>
												</h4>
												<p><?php echo $mesaj_metni; ?></p>
											</div>
										</div>
									</a>
								</div>
								<?php
							}
						} else {
							echo "Henüz hiç mesajınız yok.";
						}

						$son_mesajlar_sorgu->close();
						?>

                </div>
                <br></br>
                </div>
            </article>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

</body>

</html>

</html>