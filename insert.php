<?php
							error_reporting(E_ALL);
							ini_set('display_errors', 1);

							include("baglanti.php");

							if (!isset($_SESSION["kullanici_adi"])) {
								header("location: login.php");
								exit;
							}

							// İlan ID'sini al
							if (isset($_GET['id']) && is_numeric($_GET['id'])) {
								$ilan_id = intval($_GET['id']);
							} else {
								echo "Geçerli bir ilan ID belirtilmedi.";
								exit;
							}

							$gonderen_id = $_SESSION['uye_id']; // Oturum açan kullanıcının ID'sini al

							// İlan sahibinin ID'sini almak için SQL sorgusu
							$sahip_id_sorgu = $baglanti->prepare("SELECT uye_id FROM eruluden_ikinci_el_ilanlar WHERE ilan_id = ?");
							if ($sahip_id_sorgu === false) {
								die('Sorgu hazırlama hatası: ' . $baglanti->error);
							}

							$sahip_id_sorgu->bind_param("i", $ilan_id);
							$sahip_id_sorgu->execute();
							$sahip_id_sorgu->store_result();

							if ($sahip_id_sorgu->num_rows > 0) {
								$sahip_id_sorgu->bind_result($ilan_sahibi_id);
								$sahip_id_sorgu->fetch();

								// İlan sahibinin bilgilerini almak için SQL sorgusu
								$ilan_sahibi_sorgu = $baglanti->prepare("SELECT kullanici_adi FROM eruluden_uyeler WHERE uye_id = ?");
								if ($ilan_sahibi_sorgu === false) {
									die('Sorgu hazırlama hatası: ' . $baglanti->error);
								}

								$ilan_sahibi_sorgu->bind_param("i", $ilan_sahibi_id);
								$ilan_sahibi_sorgu->execute();
								$ilan_sahibi_sorgu->store_result();

								if ($ilan_sahibi_sorgu->num_rows > 0) {
									$ilan_sahibi_sorgu->bind_result($kullanici_adi);
									$ilan_sahibi_sorgu->fetch();

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

										$mesaj_kaydet->bind_param("iiss", $gonderen_id, $ilan_sahibi_id, $mesaj, $kaydetme_tarihi);

										if ($mesaj_kaydet->execute()) {
										} else {
											echo "Mesaj Gönderme Başarısız: " . $baglanti->error;
										}

										$mesaj_kaydet->close();
									}
								} else {
									echo "İlan sahibinin bilgileri bulunamadı.";
								}

								$ilan_sahibi_sorgu->close();
							} else {
								echo "İlan sahibinin ID'si bulunamadı.";
							}

							$sahip_id_sorgu->close();
							?>