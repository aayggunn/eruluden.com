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
    <title>Erülüden | Ayarlar</title>
    <link rel="stylesheet" href="ayarlar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>
    <div class="wrapper">
        <header class="baslik">
            <h1><a href="anasayfa.php">ERULUDEN</a></h1>

        
            <nav class="menu">
                <ul>
                    <li> <a class="aktif" href="anasayfa.php">
                            <i class="fa-solid fa-house"></i>
                            <label for="anasayfa" class="text">Anasayfa</label>
                        </a></li>

                    <li><a href="ilanlar.php"> <i class="fa-solid fa-rectangle-ad"></i> <label
                                for="ilanlar" class="text">İlanlar</label></a>
                       
                    </li>
                    <li><a href="duyurular_haberler.php"> <i class="fa-solid fa-bullhorn"></i> <label for="duyurular"
                                class="text">Duyurular-Haberler</label> </a> </li>
                    <li><a href="ders_notu.php"> <i class="fa-regular fa-note-sticky"></i> <label for="sorular"
                                class="text">Notlar</label></a> </li>
                    <li><a href="kampus.php"> <i class="fa-regular fa-building"></i><label for="kampus" class="text">
                                Kampus-Yurtlar</label>
                        </a></li>

                </ul>
            </nav>
            <section class="bolum1">
                <nav class="sidebar close">
                <div class="logo-part">

                    <img src="logo1.jpg" alt="profil resmi">

                </div>
                    <header class="sider">
                        <div class="image-text">
                            <span class="image">
                                <img src="Desert.jpg" alt="profil resmi">
                            </span>

                      
                        </div>
                    </header>

                    <div class="sidemenu">
                        <div class="menu1">
                            <ul class="menu-links">
                                <li class="nav-link">
                                    <a class="side" href="profil.php">
                                        <i class="fa-regular fa-user icon"></i>
                                        <span class="text nav-text">Profil</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="ayarlar.php">
                                        <i class="fa-solid fa-gear icon"></i>
                                        <span class="text nav-text">Ayarlar</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="iletisim.php">
                                        <i class="fa-solid fa-phone icon"></i>
                                        <span class="text nav-text">İletişim</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="hakkimizda.php">
                                        <i class="fa-solid fa-briefcase icon"></i>
                                        <span class="text nav-text">Hakkımızda</span>
                                    </a>
                                </li>
                                <li class="nav-link">
                                    <a class="side" href="cikis.php">
                                        <i class="fa-solid fa-xmark icon"></i>
                                        <span class="text nav-text">Çıkış Yap</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </section>
            <article>
                <div class="ayar-kutu">
                    
                </div>
            </article>

    </div>

</body>

</html>