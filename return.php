<?php
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