<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erülüden | İlan</title>
	<link rel="icon" href="logo1.jpg" type="image/x-icon" />
	<link rel="stylesheet" href="iikinci_el_esya_ilan.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2063708385257899"
     crossorigin="anonymous"></script>
	 <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CommunityOrganization",
      "name": "Erülüden | Erciyes Üniversitesi Öğrenci Platformu",
      "url": "https://www.eruluden.com",
      "logo": "https://www.eruluden.com/logo1.jpg",
      "description": "Erciyes Üniversitesi öğrenci ve mezunlarının buluşma noktası. Eğitim, etkinlikler ve daha fazlası için platformumuzu keşfedin.",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+90-507-843-1670",
        "contactType": "Customer Support",
        "email": "info@eruluden.com"
      },
      "sameAs": [
        "https://www.facebook.com/eruluden",
        "https://www.twitter.com/eruluden",
        "https://www.instagram.com/eruludencom"
      ]
    }
    </script>
</head>

<body>
	<div class="wrapper">
		<header class="baslik">
			<div class="logo-part">
				<img src="logo1.jpg" alt="profil resmi">
			</div>
			<h1><a href="index.html">ERULUDEN</a></h1>
		</header>
		<hr />

		<div class="navbar">
			<ul>
				<li>
					<p class="log"><a href="login.php">Giriş Yap</a></p>
					<p class="log"><a href="kayit.php">Üye Ol</a></p>
				</li>
				<li> <a class="aktif" href="aanasayfa.html">
						<i class="fa-solid fa-house"></i>
						<label for="anasayfa" class="text">Anasayfa</label>
					</a></li>
				<li><a href="iikinci_el_esya.php"> <i class="fa-solid fa-rectangle-ad"></i> <label for="ilanlar"
							class="text">İlanlar</label> </a>
				</li>
				<li><a href="dduyurular_haberler.html"> <i class="fa-solid fa-bullhorn"></i> <label for="duyurular"
							class="text">Duyurular-Haberler</label> </a> </li>
				<li><a href="dders_notu.php"> <i class="fa-regular fa-note-sticky"></i> <label for="sorular"
							class="text">Notlar</label></a> </li>
				<li><a href="kkampus.html"> <i class="fa-regular fa-buiding"></i><label for="kampus" class="text">
							Kampüs-Yurtlar</label> </a></li>
			</ul>
		</div>

		<article>
			<div class="ilan-kutu">
				<div class="ilan-kutu">
					<?php
					include("baglanti.php");

					if (isset($_GET['id']) && is_numeric($_GET['id'])) {
						$ilan_id = intval($_GET['id']);
						
						$ilan_detay = $baglanti->prepare("SELECT i.ilan_baslik, i.ilan_tarih, i.ilan_yazi, u.kullanici_adi, i.ilan_fiyat, i.ilan_resim FROM eruluden_ikinci_el_ilanlar i INNER JOIN eruluden_uyeler u ON i.uye_id = u.uye_id WHERE i.ilan_id = ?");
						$ilan_detay->bind_param("i", $ilan_id);
						$ilan_detay->execute();
						$ilan_detay->bind_result($ilan_baslik, $ilan_tarih, $ilan_yazi, $kullanici_adi, $ilan_fiyat, $ilan_resim);
						$ilan_detay->fetch();
						
						echo "<div class='ilan-detay'>
						<div class='img-box'>
							<img src='{$ilan_resim}' alt=''>
						</div>
						<h1>{$ilan_baslik}</h1>
						<i>{$ilan_tarih} tarihinde <a href='kullanici.php?id=$ilan_sahibi_id'>$kullanici_adi</a> tarafından paylaşıldı</i>
						<p>{$ilan_yazi}</p>";
						
						if (!empty($ilan_fiyat)) {
							echo "<p class='fiyat'><label>Fiyat: {$ilan_fiyat} TL </label></p>";
						}
					
						echo "<div class='buton-kısım'>
        <div class='paylas'>
            <button type='button' class='btn' onclick='showShareOptions(event)' value='İlanı Paylaş' name='ekle'>
                <i class='fa-solid fa-share-nodes'>  İlanı Paylaş</i> 
               
            </button>
        </div>

        <div class='mesaj'>
            <a href='login.php'>
                <input type='submit' class='btn' value='Mesaj Gönder' name='ekle'>
                <i class='fa-regular fa-message'></i>
            </a>
        </div>
    </div>";

											
						$ilan_detay->close();
					} else {
						echo "Geçerli bir ilan ID belirtilmedi.";
					}

					$baglanti->close();
					?>
				</div>
			</div>
		</article>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="shareModalLabel">İlanı Paylaş</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<button class="btn btn-primary" onclick="copyLink()">Linki Kopyala</button>
					<button class="btn btn-success" onclick="shareWhatsApp()">WhatsApp ile Gönder</button>
					<button class="btn btn-danger" onclick="shareInstagramStory()">Instagram'da Paylaş</button>
				</div>
			</div>
		</div>
	</div>

	<!-- JavaScript (jQuery, Popper.js, Bootstrap JS) -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	
	<script>
		function showShareOptions(event) {
			event.preventDefault();  // Formun gönderilmesini engelle
			$('#shareModal').modal('show');  // Modalı göster
		}

		function copyLink() {
			const url = window.location.href;
			navigator.clipboard.writeText(url).then(() => {
				alert('Link kopyalandı!');
			});
		}

		function shareWhatsApp() {
			const url = window.location.href;
			window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(url)}`, '_blank');
		}

		function shareInstagramStory() {
    const storyUrl = `https://www.instagram.com/create/story`;
    window.open(storyUrl, '_blank');
}

	</script>

</body>

</html>
