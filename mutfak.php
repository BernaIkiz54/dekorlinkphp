<?php
if (isset($_REQUEST["MenuID"])) {
    $GelenMenuId = SayiliIcerikleriFiltrele(Guvenlik($_REQUEST["MenuID"]));
    $MenuKosulu = " AND MenuId = '" . $GelenMenuId . "' ";
    $SayfalamaKosulu = "&MenuID=" . $GelenMenuId;
} else {
    $GelenMenuId = "";
    $MenuKosulu = "";
    $SayfalamaKosulu = "";
}

if (isset($_REQUEST["AramaIcerigi"])) {
    $GelenAramaIcerigi = Guvenlik($_REQUEST["AramaIcerigi"]);
    $AramaKosulu = " AND urun_adi LIKE '%" . $GelenAramaIcerigi . "%' ";
    $SayfalamaKosulu .= "&AramaIcerigi=" . $GelenAramaIcerigi;
} else {
    $AramaKosulu = "";
    $SayfalamaKosulu .= "";
}

$SayfalamaIcinSolVeSagButonSayisi = 2;
$SayfaBasinaGosterilecekKayitSayisi = 10;
if ($GelenMenuId != "") {
    $ToplamKayitSayisiSorgusu = $VeritabaniBaglantisi->prepare("SELECT *  FROM urun,kategori WHERE  urun.kategori_id=kategori.id AND kategori.ust_id=8 AND kategori.id=$GelenMenuId $AramaKosulu  ORDER BY kategori.id DESC");
    $ToplamKayitSayisiSorgusu->execute();
    $ToplamKayitSayisiSorgusu = $ToplamKayitSayisiSorgusu->rowCount();
    $SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
    $BulunanSayfaSayisi = ceil($ToplamKayitSayisiSorgusu / $SayfaBasinaGosterilecekKayitSayisi);
} else {
    $ToplamKayitSayisiSorgusu = $VeritabaniBaglantisi->prepare("SELECT *  FROM urun,kategori WHERE  urun.kategori_id=kategori.id AND kategori.ust_id=8  $AramaKosulu  ORDER BY kategori.id DESC");
    $ToplamKayitSayisiSorgusu->execute();
    $ToplamKayitSayisiSorgusu = $ToplamKayitSayisiSorgusu->rowCount();
    $SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
    $BulunanSayfaSayisi = ceil($ToplamKayitSayisiSorgusu / $SayfaBasinaGosterilecekKayitSayisi);
}
$AnaMenununTumUrunSayiSorgusu = $VeritabaniBaglantisi->prepare("SELECT Count(*) AS MenununToplamUrunu FROM urun,kategori WHERE urun.kategori_id=kategori.id AND kategori.ust_id=8");
$AnaMenununTumUrunSayiSorgusu->execute();
$AnaMenununTumUrunSayiSorgusu = $AnaMenununTumUrunSayiSorgusu->fetch(PDO::FETCH_ASSOC);
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="250" align="left" valign="top">
            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="250" align="center" border="0" cellpadding="0" cellspacing="0"
                               style="background-color: #F6F6F6;">
                            <tr height="50">
                                <td bgcolor="#F1F1F1"><b>&nbsp;MENÜLER</b></td>
                            </tr>
                            <tr height="30">
                                <td><a href="index.php?SK=85"
                                       style="text-decoration: none; <?php if ($GelenMenuId == "") { ?>color: #FF9900;<? } else { ?>color: #646464;<?php } ?> font-weight: bold;">&nbsp;Tüm
                                        Ürünler (<?php echo $AnaMenununTumUrunSayiSorgusu["MenununToplamUrunu"]; ?>)</a>
                                </td>
                            </tr>
                            <?php
                            $MenulerSorgusu = $VeritabaniBaglantisi->prepare("SELECT id,kategori_adi FROM kategori WHERE ust_id=8 ORDER BY kategori_adi ASC");
                            $MenulerSorgusu->execute();
                            $MenuKayitSayisi = $MenulerSorgusu->rowCount();
                            $MenuKayitlari = $MenulerSorgusu->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($MenuKayitlari as $Menu) {
                                $id = $Menu["id"];
                                $kategorisorgusu = $VeritabaniBaglantisi->prepare("SELECT  Count(*) as sayisi FROM urun WHERE kategori_id=$id");
                                $kategorisorgusu->execute();
                                $kategorikayitlari = $kategorisorgusu->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <tr height="30">
                                    <td><a href="index.php?SK=85&MenuID=<?php echo $Menu["id"]; ?>"
                                           style="text-decoration: none; <?php if ($GelenMenuId == $Menu["id"]) { ?>color: #FF9900;<? } else { ?>color: #646464;<?php } ?> font-weight: bold;">&nbsp;<?php echo DonusumleriGeriDondur($Menu["kategori_adi"]); ?>
                                            (<?php echo DonusumleriGeriDondur($kategorikayitlari["sayisi"]); ?>)</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr height="50">
                                <td bgcolor="#F1F1F1"><b>&nbsp;REKLAMLAR</b></td>
                            </tr>
                            <?php
                            $BannerSorgusu = $VeritabaniBaglantisi->prepare("SELECT * FROM bannerlar WHERE BannerAlani = 'Menu Altı' ORDER BY GosterimSayisi ASC LIMIT 1");
                            $BannerSorgusu->execute();
                            $BannerSayisi = $BannerSorgusu->rowCount();
                            $BannerKaydi = $BannerSorgusu->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <tr height="250">
                                <td><img src="Resimler/<?php echo $BannerKaydi["BannerResmi"]; ?>" border="0"></td>
                            </tr>
                            <?php
                            $BannerGuncelle = $VeritabaniBaglantisi->prepare("UPDATE bannerlar SET GosterimSayisi=GosterimSayisi+1 WHERE id = ? LIMIT 1");
                            $BannerGuncelle->execute([$BannerKaydi["id"]]);
                            ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>

        <td width="11" align="left">&nbsp;</td>

        <td width="795" align="left" valign="top">
            <table width="795" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div class="AramaAlani">
                            <form action="index.php?SK=85" method="post">
                                <?php
                                if ($GelenMenuId != "") {
                                    ?>
                                    <input type="hidden" name="MenuID" value="<?php echo $GelenMenuId; ?>">
                                    <?php
                                }
                                ?>
                                <div class="AramaAlaniButonKapsamaAlani">
                                    <input type="submit" value="" class="AramaAlaniButonu">
                                </div>
                                <div class="AramaAlaniInputKapsamaAlani">
                                    <input type="text" name="AramaIcerigi" class="AramaAlaniInputu">
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="795" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr><?php
                                if ($GelenMenuId != "") {
                                    $ResimlerSorgusu = $VeritabaniBaglantisi->prepare("SELECT kategori_adi FROM kategori WHERE id=$GelenMenuId ");
                                    $ResimlerSorgusu->execute();
                                    $ResimlerSayisi = $ResimlerSorgusu->rowCount();
                                    $ResimlerKayitlari = $ResimlerSorgusu->fetch(PDO::FETCH_ASSOC);
                                    $kategoriadi = $ResimlerKayitlari["kategori_adi"];
                                    $UrunlerSorgusu = $VeritabaniBaglantisi->prepare("SELECT * FROM urun WHERE kategori_id=$GelenMenuId AND Durumu = '0'  $AramaKosulu ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
                                    $UrunlerSorgusu->execute();
                                    $UrunSayisi = $UrunlerSorgusu->rowCount();
                                    $UrunKayitlari = $UrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
                                    $DonguSayisi = 1;
                                    $SutunAdetSayisi = 4;
                                } else {
                                    $UrunlerSorgusu = $VeritabaniBaglantisi->prepare("SELECT *,urun.id as ID,kategori.kategori_adi as kategori FROM urun,kategori WHERE urun.kategori_id=kategori.id And kategori.ust_id=8 AND Durumu = '0'  $AramaKosulu ORDER BY kategori.id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
                                    $UrunlerSorgusu->execute();
                                    $UrunSayisi = $UrunlerSorgusu->rowCount();
                                    $UrunKayitlari = $UrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
                                    $DonguSayisi = 1;
                                    $SutunAdetSayisi = 4;
                                }
                                foreach ($UrunKayitlari as $Kayit) {
                                    $UrununFiyati = DonusumleriGeriDondur($Kayit["fiyat"]);
                                    $UrununParaBirimi = 'TL';
                                    if ($UrununParaBirimi == "USD") {
                                        $UrunFiyatiHesapla = $UrununFiyati * $DolarKuru;
                                    } elseif ($UrununParaBirimi == "EUR") {
                                        $UrunFiyatiHesapla = $UrununFiyati * $EuroKuru;
                                    } else {
                                        $UrunFiyatiHesapla = $UrununFiyati;
                                    }

                                    $UrununToplamYorumSayisi = DonusumleriGeriDondur($Kayit["YorumSayisi"]);
                                    $UrununToplamYorumPuani = DonusumleriGeriDondur($Kayit["ToplamYorumPuani"]);

                                    if ($UrununToplamYorumSayisi > 0) {
                                        $PuanHesapla = number_format($UrununToplamYorumPuani / $UrununToplamYorumSayisi, 2, ".", "");
                                    } else {
                                        $PuanHesapla = 0;
                                    }

                                    if ($PuanHesapla == 0) {
                                        $PuanResmi = "YildizCizgiliBos.png";
                                    } elseif (($PuanHesapla > 0) and ($PuanHesapla <= 1)) {
                                        $PuanResmi = "YildizCizgiliBirDolu.png";
                                    } elseif (($PuanHesapla > 1) and ($PuanHesapla <= 2)) {
                                        $PuanResmi = "YildizCizgiliIkiDolu.png";
                                    } elseif (($PuanHesapla > 2) and ($PuanHesapla <= 3)) {
                                        $PuanResmi = "YildizCizgiliUcDolu.png";
                                    } elseif (($PuanHesapla > 3) and ($PuanHesapla <= 4)) {
                                        $PuanResmi = "YildizCizgiliDortDolu.png";
                                    } elseif ($PuanHesapla > 4) {
                                        $PuanResmi = "YildizCizgiliBesDolu.png";
                                    }
                                    ?>
                                    <td width="191" valign="top">
                                        <table width="191" align="left" border="0" cellpadding="0" cellspacing="0"
                                               style="margin-bottom: 10px; border: 1px solid #CCCCCC; ">
                                            <?php
                                            if ($GelenMenuId == "") {
                                                $kategoriadi = $Kayit["kategori"];
                                                $id=$Kayit["ID"];
                                            }
                                            else{
                                                $id=$Kayit["id"];
                                            }
                                            ?>
                                            <tr height="40">
                                                <td align="center"><a
                                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($id); ?>">
                                                        <img
                                                                src="Resimler/UrunResimleri/<?php echo DonusumleriGeriDondur($kategoriadi); ?>/<?php echo DonusumleriGeriDondur($Kayit["UrunResmiBir"]); ?>"
                                                                border="0" width="185" height="247"></a></td>
                                            </tr>

                                            <tr height="25">
                                                <td width="191" align="center"><a
                                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($id); ?>"
                                                            style="color: #FF9900; font-weight: bold; text-decoration: none;"><?php echo DonusumleriGeriDondur($kategoriadi); ?></a>
                                                </td>
                                            </tr>

                                            <tr height="25">
                                                <td width="191" align="center"><a
                                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($id); ?>"
                                                            style="color: #646464; font-weight: bold; text-decoration: none;">
                                                        <div style="width: 191px; max-width: 191px; height: 20px; overflow: hidden; line-height: 20px;"><?php echo DonusumleriGeriDondur($Kayit["urun_adi"]); ?></div>
                                                    </a></td>
                                            </tr>
                                            <tr height="25">
                                                <td width="191" align="center"><a
                                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($id); ?>"><img
                                                                src="Resimler/<?php echo $PuanResmi; ?>" border="0"></a>
                                                </td>
                                            </tr>
                                            <tr height="25">
                                                <td width="191" align="center"><a
                                                            href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($id); ?>"
                                                            style="color: #0000FF; font-weight: bold; text-decoration: none;"><?php echo FiyatBicimlendir($UrunFiyatiHesapla); ?>
                                                        TL</a></td>
                                            </tr>

                                            <tr height="25">
                                                <td width="191" align="center">&nbsp;</td>
                                            </tr>

                                        </table>
                                    </td>
                                    <?php
                                    if ($DonguSayisi < $SutunAdetSayisi) {
                                        ?>
                                        <td width="10">&nbsp;</td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    $DonguSayisi++;

                                    if ($DonguSayisi > $SutunAdetSayisi) {
                                        echo "</tr><tr>";
                                        $DonguSayisi = 1;
                                    }
                                }
                                ?></tr>
                        </table>
                    </td>
                </tr>
                <?php
                if ($BulunanSayfaSayisi > 1) {
                    ?>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr height="50">
                        <td align="center">
                            <div class="SayfalamaAlaniKapsayicisi">
                                <div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
                                    Toplam <?php echo $BulunanSayfaSayisi; ?>
                                    sayfada, <?php echo $ToplamKayitSayisiSorgusu; ?> adet kayıt bulunmaktadır.
                                </div>

                                <div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
                                    <?php
                                    if ($Sayfalama > 1) {
                                        echo "<span class='SayfalamaPasif'><a href='index.php?SK=85" . $SayfalamaKosulu . "&SYF=1'><<</a></span>";
                                        $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama - 1;
                                        echo "<span class='SayfalamaPasif'><a href='index.php?SK=85" . $SayfalamaKosulu . "&SYF=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span>";
                                    }

                                    for ($SayfalamaIcinSayfaIndexDegeri = $Sayfalama - $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri <= $Sayfalama + $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++) {
                                        if (($SayfalamaIcinSayfaIndexDegeri > 0) and ($SayfalamaIcinSayfaIndexDegeri <= $BulunanSayfaSayisi)) {
                                            if ($Sayfalama == $SayfalamaIcinSayfaIndexDegeri) {
                                                echo "<span class='SayfalamaAktif'>" . $SayfalamaIcinSayfaIndexDegeri . "</span>";
                                            } else {
                                                echo "<span class='SayfalamaPasif'><a href='index.php?SK=85" . $SayfalamaKosulu . "&SYF=" . $SayfalamaIcinSayfaIndexDegeri . "'> " . $SayfalamaIcinSayfaIndexDegeri . "</a></span>";
                                            }
                                        }
                                    }

                                    if ($Sayfalama != $BulunanSayfaSayisi) {
                                        $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama + 1;
                                        echo "<span class='SayfalamaPasif'><a href='index.php?SK=85" . $SayfalamaKosulu . "&SYF=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
                                        echo "<span class='SayfalamaPasif'><a href='index.php?SK=85" . $SayfalamaKosulu . "&SYF=" . $BulunanSayfaSayisi . "'>>></a></span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </td>

    </tr>
</table>