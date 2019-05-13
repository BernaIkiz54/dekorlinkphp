<?php
require_once("Ayarlar/ayar.php");
require_once("Ayarlar/fonksiyonlar.php");

if(isset($_GET["AktivasyonKodu"])){
    $GelenAktivasyonKodu	=	Guvenlik($_GET["AktivasyonKodu"]);
}else{
    $GelenAktivasyonKodu	=	"";
}
if(isset($_GET["Email"])){
    $GelenEmail				=	Guvenlik($_GET["Email"]);
}else{
    $GelenEmail				=	"";
}
if(($GelenAktivasyonKodu!="") and ($GelenEmail!="")){
    $KontrolSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler WHERE email = ? AND AktivasyonKodu = ? AND Durumu = ?");
    $KontrolSorgusu->execute([$GelenEmail, $GelenAktivasyonKodu, 0]);
    $KullaniciSayisi	=	$KontrolSorgusu->rowCount();

    if($KullaniciSayisi>0){
        $UyeGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE uyeler SET aktif_mi = ? and  guncelleme_tarihi = ?");
        $UyeGuncellemeSorgusu->execute([1,$ZamanDamgasi]);
        $Kontrol		=	$UyeGuncellemeSorgusu->rowCount();

        if($Kontrol>0){
            header("Location:index.php?SK=30");
            exit();
        }else{
            header("Location:" . $SiteLinki);
            exit();
        }
    }else{
        header("Location:" . $SiteLinki);
        exit();
    }
}else{
    header("Location:" . $SiteLinki);
    exit();
}

$VeritabaniBaglantisi	=	null;
?>