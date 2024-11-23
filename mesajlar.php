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

<!-- Mesajları döngü ile görüntüle -->
<?php
$mesaj_sorgu = $baglanti->prepare("SELECT gonderici_id, alici_id, mesaj, tarih FROM eruluden_mesajlar WHERE (gonderici_id = ? AND alici_id = ?) OR (gonderici_id = ? AND alici_id = ?) ORDER BY tarih ASC");
if ($mesaj_sorgu === false) {
    die('Sorgu hazırlama hatası: ' . $baglanti->error);
}

$mesaj_sorgu->bind_param("iiii", $gonderen_id, $alici_id, $alici_id, $gonderen_id);
$mesaj_sorgu->execute();
$mesaj_sorgu->store_result();

if ($mesaj_sorgu->num_rows > 0) {
    $mesaj_sorgu->bind_result($mesaj_gonderen_id, $mesaj_alici_id, $mesaj_metni, $mesaj_tarihi);
    while ($mesaj_sorgu->fetch()) {
        $gonderen_adi = "";
        if ($mesaj_gonderen_id == $gonderen_id) {
            $gonderen_adi = "Siz";
        } else {
            $gonderen_adi = $alici_ad;
        }

        ?>
        <div class="<?php echo ($mesaj_gonderen_id == $gonderen_id) ? 'giden-mesaj' : 'gelen-mesaj'; ?>">
            <p class="kisi"><?php echo $gonderen_adi; ?></p>
            <p><?php echo $mesaj_metni; ?></p>
            <i><?php echo $mesaj_tarihi; ?></i>
        </div>
        <?php
    }
}
$mesaj_sorgu->close();
?>

