<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_adi"])) {
    header("location: login.php");
    exit;
}

$gonderen_id = $_SESSION['uye_id'];
$alici_id = intval($_GET['alici_id']);

$mesaj_sorgu = $baglanti->prepare("SELECT gonderici_id, alici_id, mesaj, tarih FROM eruluden_mesajlar WHERE (gonderici_id = ? AND alici_id = ?) OR (gonderici_id = ? AND alici_id = ?) ORDER BY tarih ASC");
$mesaj_sorgu->bind_param("iiii", $gonderen_id, $alici_id, $alici_id, $gonderen_id);
$mesaj_sorgu->execute();
$mesaj_sorgu->store_result();
$mesaj_sorgu->bind_result($mesaj_gonderen_id, $mesaj_alici_id, $mesaj_metni, $mesaj_tarihi);

$mesajlar = array();

while ($mesaj_sorgu->fetch()) {
    $gonderen_adi = ($mesaj_gonderen_id == $gonderen_id) ? "Siz" : "Diğer";
    
    $mesajlar[] = array(
        'gonderen_adi' => $gonderen_adi,
        'mesaj_metni' => $mesaj_metni,
        'mesaj_tarihi' => $mesaj_tarihi
    );
}

$mesaj_sorgu->close();

foreach (array_reverse($mesajlar) as $mesaj) {
    echo '<div class="'. ($mesaj['gonderen_adi'] == 'Siz' ? 'giden-mesaj' : 'gelen-mesaj') .'">';
    echo '<p class="kisi">'. $mesaj['gonderen_adi'] .'</p>';
    echo '<p>'. $mesaj['mesaj_metni'] .'</p>';
    echo '<i>'. $mesaj['mesaj_tarihi'] .'</i>';
    echo '</div>';
}
?>
