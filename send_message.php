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

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("baglanti.php");

if (!isset($_SESSION["kullanici_adi"])) {
    header("location: login.php");
    exit;
}

$alici_id = 0; // Başlangıçta alıcı ID'si 0 olarak ayarlanır

if (isset($_GET['alici_id']) && is_numeric($_GET['alici_id'])) {
    $alici_id = intval($_GET['alici_id']);
} else {
    echo "Geçerli bir alıcı ID belirtilmedi.";
    exit;
}

// Alıcı bilgilerini almak için SQL sorgusu
$alici_bilgi_sorgu = $baglanti->prepare("SELECT kullanici_adi FROM eruluden_uyeler WHERE uye_id = ?");
if ($alici_bilgi_sorgu === false) {
    die('Sorgu hazırlama hatası: ' . $baglanti->error);
}

$alici_bilgi_sorgu->bind_param("i", $alici_id);
$alici_bilgi_sorgu->execute();
$alici_bilgi_sorgu->store_result();

if ($alici_bilgi_sorgu->num_rows > 0) {
    $alici_bilgi_sorgu->bind_result($alici_kullanici_adi);
    $alici_bilgi_sorgu->fetch();

    // Alıcı adını ve profil resmini almak için ek sorgular
    $alici_ad = $alici_kullanici_adi;

    $profil_resim_sorgu = $baglanti->prepare("SELECT pp_path FROM eruluden_profil_resimleri WHERE uye_id = ?");
    if ($profil_resim_sorgu === false) {
        die('Sorgu hazırlama hatası: ' . $baglanti->error);
    }

    $profil_resim_sorgu->bind_param("i", $alici_id);
    $profil_resim_sorgu->execute();
    $profil_resim_sorgu->bind_result($alici_profil_resmi);
    $profil_resim_sorgu->fetch();

    $profil_resim_sorgu->close();
}

$alici_bilgi_sorgu->close();
?>



<?php
		// Mesajları döngü ile görüntüle
		$mesaj_sorgu = $baglanti->prepare("SELECT gonderici_id, alici_id, mesaj, tarih FROM eruluden_mesajlar WHERE (gonderici_id = ? AND alici_id = ?) OR (gonderici_id = ? AND alici_id = ?) ORDER BY tarih ASC");
		if ($mesaj_sorgu === false) {
			die('Sorgu hazırlama hatası: ' . $baglanti->error);
		}

		$mesaj_sorgu->bind_param("iiii", $gonderen_id, $ilan_sahibi_id, $ilan_sahibi_id, $gonderen_id);
		$mesaj_sorgu->execute();
		$mesaj_sorgu->store_result();

		if ($mesaj_sorgu->num_rows > 0) {
			$mesaj_sorgu->bind_result($mesaj_gonderen_id, $mesaj_alici_id, $mesaj_metni, $mesaj_tarihi);
			while ($mesaj_sorgu->fetch()) {
				$gonderen_adi = "";
				if ($mesaj_gonderen_id == $gonderen_id) {
					$gonderen_adi = "Siz";
				} else {
					$gonderen_adi = $kullanici_adi;
				}
?>

<?php
			}
		}
		$mesaj_sorgu->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mesajlasma.css">
    <link rel="icon" href="logo1.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Erülüden | Mesaj Gönder</title>
	
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
                <div class="kutu">

                
                <div class="mesajlasma-alan">
                    <header class="person">
                        <div class="ust">
                            <div class="back">
                                <a href="mesaj_kutusu.php"><i class="fa-solid fa-chevron-left"></i></a>
                            </div>
                            <div class="img-kutu">
								<?php echo '<img src="' . (!empty($alici_profil_resmi) ? $alici_profil_resmi : 'default.jpg') . '" alt="Profil Resmi">'; ?>
                            </div>
                            <div class="kisi">
                                <label class="kisi-adi"><a href="kullanici.php?id=<?php echo $alici_id; ?>" class="kisi-adi"><?php echo $alici_kullanici_adi; ?></a></label>
                            </div>
                        </div>
                    </header>
                    <div class="chat-container">
                        <div class="chat">
						<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("baglanti.php");

if (!isset($_SESSION["kullanici_adi"])) {
    header("location: login.php");
    exit;
}

$gonderen_id = $_SESSION['uye_id']; // Oturum açan kullanıcının ID'sini al

if (isset($_GET['gonderen_id']) && is_numeric($_GET['gonderen_id'])) {
    $gonderen_id = intval($_GET['gonderen_id']);
} else {
    echo "Geçerli bir gönderen ID belirtilmedi.";
    exit;
}

$alici_id = 0; // Başlangıçta alıcı ID'si 0 olarak ayarlanır

if (isset($_GET['alici_id']) && is_numeric($_GET['alici_id'])) {
    $alici_id = intval($_GET['alici_id']);
} else {
    echo "Geçerli bir alıcı ID belirtilmedi.";
    exit;
}

// Alıcı bilgilerini almak için SQL sorgusu
$alici_bilgi_sorgu = $baglanti->prepare("SELECT kullanici_adi FROM eruluden_uyeler WHERE uye_id = ?");
if ($alici_bilgi_sorgu === false) {
    die('Sorgu hazırlama hatası: ' . $baglanti->error);
}

$alici_bilgi_sorgu->bind_param("i", $alici_id);
$alici_bilgi_sorgu->execute();
$alici_bilgi_sorgu->store_result();

if ($alici_bilgi_sorgu->num_rows > 0) {
    $alici_bilgi_sorgu->bind_result($alici_kullanici_adi);
    $alici_bilgi_sorgu->fetch();
    
    // Alıcı adını ve profil resmini almak için ek sorgular
    $alici_ad = $alici_kullanici_adi;
    
    $profil_resim_sorgu = $baglanti->prepare("SELECT pp_path FROM eruluden_profil_resimleri WHERE uye_id = ?");
    if ($profil_resim_sorgu === false) {
        die('Sorgu hazırlama hatası: ' . $baglanti->error);
    }
    
    $profil_resim_sorgu->bind_param("i", $alici_id);
    $profil_resim_sorgu->execute();
    $profil_resim_sorgu->bind_result($alici_profil_resmi);
    $profil_resim_sorgu->fetch();
    
    $profil_resim_sorgu->close();

    // Mesaj gönder düğmesine tıklandığında
    if (isset($_POST['mesaj_gonder'])) {
        // Gönderilen mesajı al
        $mesaj = $_POST['mesaj'];

        // Mesajı veritabanına kaydet
        $kaydetme_tarihi = date('Y-m-d H:i:s'); // Şu anki tarih ve saat
        $mesaj_kaydet = $baglanti->prepare("INSERT INTO eruluden_mesajlar (gonderici_id, alici_id, mesaj, tarih) VALUES (?, ?, ?, ?)");
        if ($mesaj_kaydet === false) {
            die('Sorgu hazırlama hatası: ' . $baglanti->error);
        }

        $mesaj_kaydet->bind_param("iiss", $gonderen_id, $alici_id, $mesaj, $kaydetme_tarihi);

        if ($mesaj_kaydet->execute()) {
        } else {
            echo "Mesaj Gönderme Başarısız: " . $baglanti->error;
        }

        $mesaj_kaydet->close();
    }
} else {
    echo "Alıcı bilgileri bulunamadı.";
}

$alici_bilgi_sorgu->close();
?>

<!-- Mesajları döngü ile görüntüle (ters sırada) -->
<?php
$mesaj_sorgu = $baglanti->prepare("SELECT gonderici_id, alici_id, mesaj, tarih FROM eruluden_mesajlar WHERE (gonderici_id = ? AND alici_id = ?) OR (gonderici_id = ? AND alici_id = ?) ORDER BY tarih ASC");
if ($mesaj_sorgu === false) {
    die('Sorgu hazırlama hatası: ' . $baglanti->error);
}

$mesaj_sorgu->bind_param("iiii", $gonderen_id, $alici_id, $alici_id, $gonderen_id);
$mesaj_sorgu->execute();
$mesaj_sorgu->store_result();

$mesajlar = array(); // Mesajları saklamak için bir dizi oluşturun

if ($mesaj_sorgu->num_rows > 0) {
    $mesaj_sorgu->bind_result($mesaj_gonderen_id, $mesaj_alici_id, $mesaj_metni, $mesaj_tarihi);
    
    // Mesajları bir diziye ekleyin
    while ($mesaj_sorgu->fetch()) {
        $gonderen_adi = "";
        if ($mesaj_gonderen_id == $gonderen_id) {
            $gonderen_adi = "Siz";
        } else {
            $gonderen_adi = $alici_ad;
        }
        
        $mesajlar[] = array(
            'gonderen_adi' => $gonderen_adi,
            'mesaj_metni' => $mesaj_metni,
            'mesaj_tarihi' => $mesaj_tarihi
        );
    }
}

// Mesajları ters sırada görüntüleyin
$mesajlar = array_reverse($mesajlar);

foreach ($mesajlar as $mesaj) {
    ?>
    <div class="<?php echo ($mesaj['gonderen_adi'] == 'Siz') ? 'giden-mesaj' : 'gelen-mesaj'; ?>">
        <p class="kisi"><?php echo $mesaj['gonderen_adi']; ?></p>
        <p><?php echo $mesaj['mesaj_metni']; ?></p>
        <i><?php echo $mesaj['mesaj_tarihi']; ?></i>
    </div>
    <?php
}

$mesaj_sorgu->close();
?>



                        </div>

                    </div>
                    <div class="mesaj-kutu">
					<div class="yaz">
						<form method="post">
						<textarea name="mesaj" id="mesaj" cols="30" rows="10" placeholder="Mesaj Gönder"></textarea>
					</div>
					<div class="gonder">
						<button class="send" type="submit" name="mesaj_gonder"><i class="fa-solid fa-paper-plane"></i> Gönder</button>
					</div>
						</form>
	</div>

                </div>
            </div>

            </article>

    </div>

</body>

</html>