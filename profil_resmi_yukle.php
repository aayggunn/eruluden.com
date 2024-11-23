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
    <title>Erülüden | Anasayfa</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="profil_resmi_yukle.css">
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
									if (!empty($profil_resmi)) { ?>
									<img src="<?php echo $profil_resmi; ?>" alt="Profil Resmi">
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
                <div class="resim-duzen">
                    <div class="duzen">
                    <a href = "profil.php"><div class="buton">
                    <input type="submit" class="btn" value="Geri Dön" name="ekle"><i class="fa-solid fa-arrow-left"></i></input>
                </div></a>
					<?php
						session_start();

						error_reporting(E_ALL);
						ini_set('display_errors', 1);

						if (isset($_SESSION["kullanici_adi"])) {
							$uye_id = $_SESSION['uye_id'];

							include("baglanti.php");

							// Mevcut profil resmini veritabanından al
							$get_pp_sql = "SELECT pp_path FROM eruluden_profil_resimleri WHERE uye_id = ?";
							$get_pp_stmt = $baglanti->prepare($get_pp_sql);
							$get_pp_stmt->bind_param("i", $uye_id);
							$get_pp_stmt->execute();
							$get_pp_stmt->bind_result($profil_resmi);
							$get_pp_stmt->fetch();
							$get_pp_stmt->close();

							if ($_SERVER["REQUEST_METHOD"] == "POST") {
								if (isset($_FILES["profil_resmi"]) && $_FILES["profil_resmi"]["error"] == 0) {
									$upload_path = "profil_resimleri/";
									$file_name = uniqid() . "_" . $_FILES["profil_resmi"]["name"]; // Rastgele resim adı oluştur
									$file_path = $upload_path . $file_name;

									if (move_uploaded_file($_FILES["profil_resmi"]["tmp_name"], $file_path)) {
										// Mevcut profil resmini silme
										$delete_sql = "DELETE FROM eruluden_profil_resimleri WHERE uye_id = ?";
										$delete_stmt = $baglanti->prepare($delete_sql);
										$delete_stmt->bind_param("i", $uye_id);
										$delete_stmt->execute();
										$delete_stmt->close();

										// Yeni profil resmini ekleme
										$insert_sql = "INSERT INTO eruluden_profil_resimleri (uye_id, pp_path) VALUES (?, ?)";
										$stmt = $baglanti->prepare($insert_sql);
										$stmt->bind_param("is", $uye_id, $file_path);

										if ($stmt->execute()) {
											$profil_resmi = $file_path; // Yeni resmi mevcut resim olarak güncelle
											echo "Profil resminiz başarıyla yüklendi ve güncellendi.";
											exit();
										} else {
											echo "Ekleme sorgusunda hata: " . $stmt->error;
										}
										$stmt->close();
									} else {
										echo "Dosya yüklenirken bir hata oluştu.";
									}
								} else {
									echo "Dosya yüklenirken bir hata oluştu: " . $_FILES["profil_resmi"]["error"];
								}
							}

							$baglanti->close();
						} else {
							header("location: login.php");
						}
					?>

				<h2>Profil Resmi Yükle/Güncelle</h2>
                <div class="form-container">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
					<label for="profil_resmi" class="resim">Profil Resmi Seçin:</label>
					<input type="file" name="profil_resmi" id="profil_resmi" accept="image/*"><br><br>
					<input type="submit" name="upload" value="Yükle/Güncelle" class="button">
				</form>
                </div>
                    </div>
                </div>
			
				
			</article>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

</body>

</html>