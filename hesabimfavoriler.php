<?php
if (isset($_SESSION["Kullanici"])) {

    $SayfalamaIcinSolVeSagButonSayisi = 2;
    $SayfaBasinaGosterilecekKayitSayisi = 10;
    $ToplamKayitSayisiSorgusu = $VeritabaniBaglantisi->prepare("SELECT * FROM favoriler WHERE ue_id = ? ORDER BY id DESC");
    $ToplamKayitSayisiSorgusu->execute([$KullaniciID]);
    $ToplamKayitSayisiSorgusu = $ToplamKayitSayisiSorgusu->rowCount();
    $SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
    $BulunanSayfaSayisi = ceil($ToplamKayitSayisiSorgusu / $SayfaBasinaGosterilecekKayitSayisi);
    ?>
    <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <hr/>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="203"
                            style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a
                                    href="index.php?SK=50" style="text-decoration: none; color: black;">Üyelik
                                Bilgileri</a></td>
                        <td width="10">&nbsp;</td>
                        <td width="203"
                            style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a
                                    href="index.php?SK=58" style="text-decoration: none; color: black;">Adresler</a>
                        </td>
                        <td width="10">&nbsp;</td>
                        <td width="203"
                            style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a
                                    href="index.php?SK=59" style="text-decoration: none; color: black;">Favoriler</a>
                        </td>
                        <td width="10">&nbsp;</td>
                        <td width="203"
                            style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a
                                    href="index.php?SK=60" style="text-decoration: none; color: black;">Yorumlar</a>
                        </td>
                        <td width="10">&nbsp;</td>
                        <td width="203"
                            style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a
                                    href="index.php?SK=61" style="text-decoration: none; color: black;">Siparişler</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <hr/>
            </td>
        </tr>
        <tr>
            <td width="1065" valign="top">
                <table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr height="40">
                        <td colspan="4" style="color:#FF9900"><h3>Hesabım > Favoriler</h3></td>
                    </tr>
                    <tr height="30">
                        <td colspan="4" valign="top" style="border-bottom: 1px dashed #CCCCCC;">Favorilerinize
                            Eklediğiniz Tüm Ürünleri Bu Alandan Görüntüleyebilirsiniz.
                        </td>
                    </tr>
                    <tr height="50">
                        <td width="75" style="background: #f8ffa7; color: black;" align="left">&nbsp;Resim</td>
                        <td width="25" style="background: #f8ffa7; color: black;" align="left">Sil</td>
                        <td width="865" style="background: #f8ffa7; color: black;" align="left">Adı</td>
                        <td width="100" style="background: #f8ffa7; color: black;" align="left">Fiyatı</td>
                    </tr>
                    <?php
                    $FavorilerSorgusu = $VeritabaniBaglantisi->prepare("SELECT * FROM favoriler WHERE uye_id = ? ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
                    $FavorilerSorgusu->execute([$KullaniciID]);
                    $FavoriSayisi = $FavorilerSorgusu->rowCount();
                    $FavoriKayitlari = $FavorilerSorgusu->fetchAll(PDO::FETCH_ASSOC);

                    if ($FavoriSayisi > 0) {
                        foreach ($FavoriKayitlari as $FavoriSatirlar) {
                            $UrunlerSorgusu = $VeritabaniBaglantisi->prepare("SELECT urun.id,urun.urun_adi,kategori.kategori_adi,urun.UrunResmiBir,urun.fiyat FROM urun as urun,kategori as kategori WHERE urun.id = ? and urun.kategori_id=kategori.id LIMIT 1");
                            $UrunlerSorgusu->execute([$FavoriSatirlar["urun_id"]]);
                            $UrunKaydi = $UrunlerSorgusu->fetch(PDO::FETCH_ASSOC);


                            $UrununAdi = $UrunKaydi["urun_adi"];
                            $UrununUrunTuru = $UrunKaydi["kategori_adi"];
                            $UrununResmi = $UrunKaydi["UrunResmiBir"];
                            $UrununUrunFiyati = $UrunKaydi["fiyat"];
                            if ($UrununUrunTuru == "Ampüller ve Led Ürünleri") {
                                $ResimKlasoruAdi = "Ampüller ve Led Ürünleri";
                            } elseif ($UrununUrunTuru == "Avizeler") {
                                $ResimKlasoruAdi = "Avizeler";
                            } elseif ($UrununUrunTuru == "Aynalar") {
                                $ResimKlasoruAdi = "Aynalar";
                            } elseif ($UrununUrunTuru == "bardak ve Sürahiler") {
                                $ResimKlasoruAdi = "bardak ve Sürahiler";
                            } elseif ($UrununUrunTuru == "Çatal Kaşık") {
                                $ResimKlasoruAdi = "Çatal Kaşık";
                            } elseif ($UrununUrunTuru == "Dekoratif Obje") {
                                $ResimKlasoruAdi = "Dekoratif Obje";
                            } elseif ($UrununUrunTuru == "Kapı Önü Aksesuarları") {
                                $ResimKlasoruAdi = "Kapı Önü Aksesuarları";
                            } elseif ($UrununUrunTuru == "Kitaplık") {
                                $ResimKlasoruAdi = "Kitaplık";
                            } elseif ($UrununUrunTuru == "Led Aydınlatmalar") {
                                $ResimKlasoruAdi = "Led Aydınlatmalar";
                            } elseif ($UrununUrunTuru == "Oturma Odası") {
                                $ResimKlasoruAdi = "Oturma Odası";
                            } elseif ($UrununUrunTuru == "Saklama Kapları") {
                                $ResimKlasoruAdi = "Saklama Kapları";
                            } elseif ($UrununUrunTuru == "Sarkıtlar") {
                                $ResimKlasoruAdi = "Sarkıtlar";
                            } elseif ($UrununUrunTuru == "Sehpa") {
                                $ResimKlasoruAdi = "Sehpa";
                            } elseif ($UrununUrunTuru == "Servis Ürünleri") {
                                $ResimKlasoruAdi = "Servis Ürünleri";
                            } elseif ($UrununUrunTuru == "Spot Lambaları") {
                                $ResimKlasoruAdi = "Spot Lambaları";
                            } elseif ($UrununUrunTuru == "Tablo") {
                                $ResimKlasoruAdi = "Tablo";
                            } elseif ($UrununUrunTuru == "Tv Ünitesi") {
                                $ResimKlasoruAdi = "Tv Ünitesi";
                            } elseif ($UrununUrunTuru == "Yatak Odası") {
                                $ResimKlasoruAdi = "Yatak Odası";
                            } else {
                                $ResimKlasoruAdi = "Yemek Takımları";
                            }
                            ?>
                            <tr height="30">
                                <td width="75" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a
                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($UrunKaydi["id"]); ?>"><img
                                                src="Resimler/UrunResimleri/<?php echo $ResimKlasoruAdi; ?>/<?php echo DonusumleriGeriDondur($UrununResmi); ?>"
                                                border="0" width="60" height="80"></a></td>
                                <td width="50" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a
                                            href="index.php?SK=81&ID=<?php echo DonusumleriGeriDondur($FavoriSatirlar["id"]); ?>"><img
                                                src="Resimler/Sil20x20.png" border="0"></a></td>
                                <td width="415" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a
                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($UrunKaydi["id"]); ?>"
                                            style="color: #646464; text-decoration: none;"><?php echo DonusumleriGeriDondur($UrununAdi); ?></a>
                                </td>
                                <td width="100" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a
                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($UrunKaydi["id"]); ?>"
                                            style="color: #646464; text-decoration: none;"><?php echo FiyatBicimlendir(DonusumleriGeriDondur($UrununUrunFiyati)); ?>TL</a>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($BulunanSayfaSayisi > 1) {
                            ?>
                            <tr height="50">
                                <td colspan="4" align="center">
                                    <div class="SayfalamaAlaniKapsayicisi">
                                        <div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
                                            Toplam <?php echo $BulunanSayfaSayisi; ?>
                                            sayfada, <?php echo $ToplamKayitSayisiSorgusu; ?> adet kayıt bulunmaktadır.
                                        </div>

                                        <div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
                                            <?php
                                            if ($Sayfalama > 1) {
                                                echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=1'><<</a></span>";
                                                $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama - 1;
                                                echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span>";
                                            }

                                            for ($SayfalamaIcinSayfaIndexDegeri = $Sayfalama - $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri <= $Sayfalama + $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++) {
                                                if (($SayfalamaIcinSayfaIndexDegeri > 0) and ($SayfalamaIcinSayfaIndexDegeri <= $BulunanSayfaSayisi)) {
                                                    if ($Sayfalama == $SayfalamaIcinSayfaIndexDegeri) {
                                                        echo "<span class='SayfalamaAktif'>" . $SayfalamaIcinSayfaIndexDegeri . "</span>";
                                                    } else {
                                                        echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $SayfalamaIcinSayfaIndexDegeri . "'> " . $SayfalamaIcinSayfaIndexDegeri . "</a></span>";
                                                    }
                                                }
                                            }

                                            if ($Sayfalama != $BulunanSayfaSayisi) {
                                                $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama + 1;
                                                echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
                                                echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $BulunanSayfaSayisi . "'>>></a></span>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr height="50">
                            <td colspan="4" align="left">Sisteme Kayıtlı Favori Ürününüz Bulunmamaktadır.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </td>
        </tr>
    </table>
    <?php
} else {
    header("Location:index.php");
    exit();
}
?>