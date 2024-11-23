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
    <title>Erülüden | Hakkımızda</title>
    <link rel="stylesheet" href="hakkimizda.css">
    <link rel="icon" href="logo1.jpg" type="image/x-icon" />

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
					<header class="sider">
					<div class="logo-part">

                     <img src="logo1.jpg" alt="profil resmi">

                    </div>
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
                                </a>								<li class="nav-link">
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
            
                <article class="about">


                 <div class="biz">
                      <div class="hakkimiz">
                    <h4> BİZ KİMİZ </h4>
        <p>
            Merhaba ve Hoş Geldiniz!
            <br></br>
            eruluden.com, Erciyes Üniversitesi öğrencilerine ikinci el eşya alım satımında, ev devretme -
            kiralama ve ev arkadaşı arama bulma gibi konularda sağlayacağı kolaylık ve güven başta olmak
            üzere; notlar kısmında kullanıcı katılımlı oluşturulacak ve sürekli büyüyecek, zenginleşecek bir
            online kütüphane ve ders notu çıkmış soru kaynağı ile ve ileride eklenecek olan forum kısmı ile
            öğrenciler arası bilgi alışverişini ve iletişimi güçlendirmeye ve kolaylaştırmaya çalışacak bir
            platformdur.
            <br></br>
            Amacımız:
            <br></br>
            eruluden.com olarak amacımız, Erciyes Üniversitesi öğrencileri ve mezunlarına yönelik benzersiz
            bir çevrimiçi platform oluşturarak onları desteklemek ve bir araya getirmektir. Tek bir çatı
            altında, öğrencilerin çeşitli ihtiyaçlarını karşılamak ve bilgi paylaşımını kolaylaştırmak için
            çalışıyoruz.
            <br></br>
            Neler Sunuyoruz?
            <br></br>
            İkinci El Eşya Alım Satım: Öğrencilerin ihtiyaç duydukları ikinci el eşyaları uygun fiyatlarla
            bulmalarını ve artık kullanmadıkları eşyalarını satmalarını sağlayan bir platform sunuyoruz.
            Böylece öğrenciler hem bütçelerine uygun eşyalara ulaşırken hem de çevreye duyarlı bir alışveriş
            deneyimi yaşarlar. Ayrıca doğrulanmış hesap sistemiyle Erciyes Üniversitesi öğrencisi olduğuna
            yüzde yüz güvenebileceğiniz bir sistemde eşya alım satımları daha güvenli ve pratik hale
            gelecek.
            <br></br>
            Ev Arkadaşı Arama ve Bulma: Öğrencilerin kampüs yakınında uygun bir ev ve ev arkadaşı
            bulmalarına yardımcı oluyoruz. Konaklama konusundaki endişelerini ortadan kaldırarak,
            öğrencilere güvenilir, Erciyes Üniversitesi öğrencisi olup olmadığını bildiğiniz ve uyumlu ev
            arkadaşlarıyla bir araya gelmelerine olanak tanıyoruz.
            <br></br>
            Ev Devretme ve Kiralama: Öğrencilerin öğrenimleri süresince veya tatil dönemlerinde evlerini
            devretmelerini veya kiralama işlemlerini kolaylaştırıyoruz. Bu sayede öğrenciler, boş kalan
            evlerini değerlendirebilir veya kısa süreli konaklama seçenekleri bulabilirler.
            <br></br>
            Ders Notu Paylaşımı: Öğrencilerin akademik başarılarına katkı sağlamak için ders notu paylaşım
            platformu sunuyoruz. Öğrenciler, ders notlarını ve ders kitaplarını PDF formatında yükleyerek
            diğer öğrenci arkadaşlarıyla paylaşabilir ve birbirlerine destek olabilirler.

            eruluden.com'a katılarak, Erciyes Üniversitesi öğrencileri arasında dayanışma ve yardımlaşma
            ruhuna katkı sağlayabilirsiniz. <br></br>Platformumuzda kolayca üye olabilir ve sunulan
            hizmetlerimizden faydalanabilirsiniz. Eğer Erciyes Üniversitesi öğrencisiyseniz veya mezunsanız,
            siz de bu büyüyen topluluğa katılarak değerli bir üye olabilirsiniz.

            Bize katılarak, Erciyes Üniversitesi'nin dinamik öğrenci topluluğunda yer almanın ayrıcalığını
            yaşayın.

            Teşekkür ederiz, sizinle birlikte büyümek için sabırsızlanıyoruz!<br></br>

        </p>
            
      
    </div>
   
</div>

</article>
    </div>


</body>

</html>