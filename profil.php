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
	$profil_resmi2 = $profil_resmi;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erülüden | Profilim</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="profil.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
								if (!empty($profil_resmi2)) { ?>
								<img src="<?php echo $profil_resmi2; ?>" alt="Profil Resmi">
								<?php } 
								
								else { ?>
								<img src="download.png" alt="Profil Resmi">
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
				 <div class="proffil">
        <h2><label class="profil">Profil Bilgilerim</label></h2>
        <div class="pro">
            <div class="profil-resmi">
                <?php if (!empty($profil_resmi)) { ?>
                    <img src="<?php echo $profil_resmi; ?>" alt="Profil-resmi">
                <?php } else { ?>
                    <img src="download.png" alt="Profil-resmi">
                <?php } ?>
            </div>
            <div class="btn">
                <div class="pp-butonu">
                    <a href="profil_resmi_yukle.php">Profil Resmi Yükle/Güncelle</a>
                </div>
            </div>
        </div>
		</div>
        <div class="profil-bilgi">
            <div class="duzenle-butonu">
                <a href="duzenle.php">Profil Bilgilerimi Düzenle</a>
            </div>
            <div class="kbilgi">
                <p><strong>Ad:</strong> <?php echo $ad; ?></p>
                <p><strong>Kullanıcı Adı:</strong> <?php echo $kullanici_adi; ?></p>
                <p><strong>Hakkımda:</strong> <?php echo $hakkimda; ?></p>
            </div>
        </div>
        <div class="hesap">
            <h1>Hesabımı Doğrula</h1>
            <p>@erciyes.edu.tr uzantılı mail adresinizi girip hesabımı doğrula tuşuna bastıktan sonra mailinize bir hesap doğrulama maili gelecektir. O maili onaylarsanız Erciyes Üniversitesi öğrencisi olduğunuz anlaşılacaktır ve bunun diğer kullanıcılar tarafından da anlaşılabilmesi için kullanıcı adınızın yanında mavi tik olacaktır.</p>
            <div class="form-kutu">
                <form>
                    <label for="email" class="mail">E-posta:</label>
                    <input type="text" id="email" name="email" required>
                    <button type="button" onclick="validateEmail()">Hesabımı Doğrula</button>
                </form>
            </div>
        </div>
        <div class="ilanlarim">
            <div class="kutularim">
                <h4>İkinci El Eşya İlanlarım</h4>
                <?php
                include("baglanti.php");

                if (isset($_SESSION['uye_id'])) {
                    $uye_id = $_SESSION['uye_id'];

                    $kullanici_ilan = $baglanti->prepare("SELECT ilan_id, ilan_baslik, ilan_resim, ilan_fiyat FROM eruluden_ikinci_el_ilanlar WHERE uye_id = ? ORDER BY ilan_id DESC");

                    if ($kullanici_ilan !== false) {
                        $kullanici_ilan->bind_param("i", $uye_id);
                        if ($kullanici_ilan->execute()) {
                            $kullanici_ilan->store_result();
                            $kullanici_ilan->bind_result($ilan_id, $ilan_baslik, $ilan_resim, $ilan_fiyat);

                            while ($kullanici_ilan->fetch()) {
							echo "<div class='kutu'>
							<div class='ilan'>
								<h5>{$ilan_baslik}</h5>
								<img src='{$ilan_resim}' alt=''>";

						if (!empty($ilan_fiyat)) {
							echo "<p>Fiyat: {$ilan_fiyat} TL</p>";
						}

						echo "</div>
							<div class='ilan-buton'>
								<a href='ikinci_el_esya_ilan_sil.php?id={$ilan_id}'>Sil<i class='fa-solid fa-trash'></i></a> |
								<a href='ikinci_el_esya_ilan_duzenle.php?id={$ilan_id}'>Düzenle<i class='fa-solid fa-user-pen'></i></a>
							</div>
						</div>";

													}

                            $kullanici_ilan->close();
                        } else {
                            die("Sorgu hatası: " . $kullanici_ilan->error);
                        }
                    } else {
                        die("Sorgu hazırlama hatası: " . $baglanti->error);
                    }
                }
                ?>
            </div>

            <div class="kutularim">
                <h4>Ev Devretme-Kiralama İlanlarım</h4>
                <?php
                if (isset($_SESSION['uye_id'])) {
                    $uye_id = $_SESSION['uye_id'];

                    $kullanici_ilan = $baglanti->prepare("SELECT ilan_id, ilan_baslik, ilan_resim, ilan_fiyat FROM eruluden_ev_devretme_kiralama_ilanlar WHERE uye_id = ? ORDER BY ilan_id DESC");

                    if ($kullanici_ilan !== false) {
                        $kullanici_ilan->bind_param("i", $uye_id);
                        if ($kullanici_ilan->execute()) {
                            $kullanici_ilan->store_result();
                            $kullanici_ilan->bind_result($ilan_id, $ilan_baslik, $ilan_resim, $ilan_fiyat);

                            while ($kullanici_ilan->fetch()) {
                              
							echo "<div class='kutu'>
								<div class='ilan'>
									<h5>{$ilan_baslik}</h5>
									<img src='{$ilan_resim}' alt=''>";

							if (!empty($ilan_fiyat)) {
								echo "<p>Fiyat: {$ilan_fiyat} TL</p>";
							}

							echo "</div>
								<div class='ilan-buton'>
									<a href='ev_devretme_ilan_sil.php?id={$ilan_id}'>Sil<i class='fa-solid fa-trash'></i></a>
									<a href='ev_devretme_ilan_duzenle.php?id={$ilan_id}'>Düzenle<i class='fa-solid fa-user-pen'></i></a>
								</div>
							</div>";

														}


                            $kullanici_ilan->close();
                        } else {
                            die("Sorgu hatası: " . $kullanici_ilan->error);
                        }
                    } else {
                        die("Sorgu hazırlama hatası: " . $baglanti->error);
                    }
                }
                ?>
            </div>

            <div class="kutularim">
                <h4>Ev Arkadaşı İlanlarım</h4>
                <?php
                if (isset($_SESSION['uye_id'])) {
                    $uye_id = $_SESSION['uye_id'];

                    $kullanici_ilan = $baglanti->prepare("SELECT ilan_id, ilan_baslik, ilan_resim, ilan_fiyat FROM eruluden_ev_arkadasi_ilanlar WHERE uye_id = ? ORDER BY ilan_id DESC");

                    if ($kullanici_ilan !== false) {
                        $kullanici_ilan->bind_param("i", $uye_id);
                        if ($kullanici_ilan->execute()) {
                            $kullanici_ilan->store_result();
                            $kullanici_ilan->bind_result($ilan_id, $ilan_baslik, $ilan_resim, $ilan_fiyat);

                            while ($kullanici_ilan->fetch()) {
echo "<div class='kutu'>
    <div class='ilan'>
        <h5>{$ilan_baslik}</h5>
        <img src='{$ilan_resim}' alt=''>";

if (!empty($ilan_fiyat)) {
    echo "<p>Fiyat: {$ilan_fiyat} TL</p>";
}

echo "</div>
    <div class='ilan-buton'>
        <a href='ev_arkadasi_ilan_sil.php?id={$ilan_id}'>Sil<i class='fa-solid fa-trash'></i></a>
        <a href='ev_arkadasi_ilan_duzenle.php?id={$ilan_id}'>Düzenle<i class='fa-solid fa-user-pen'></i></a>
    </div>
</div>";


                            }

                            $kullanici_ilan->close();
                        } else {
                            die("Sorgu hatası: " . $kullanici_ilan->error);
                        }
                    } else {
                        die("Sorgu hazırlama hatası: " . $baglanti->error);
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

            </article>

    </div>
	<script src="hesap_onay.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

	
</body>

</html>