<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_POST["EmailAdresi"])){
        $GelenEmailAdresi		=	Guvenlik($_POST["EmailAdresi"]);
    }else{
        $GelenEmailAdresi		=	"";
    }
    if(isset($_POST["Sifre"])){
        $GelenSifre				=	Guvenlik($_POST["Sifre"]);
    }else{
        $GelenSifre				=	"";
    }
    if(isset($_POST["SifreTekrar"])){
        $GelenSifreTekrar		=	Guvenlik($_POST["SifreTekrar"]);
    }else{
        $GelenSifreTekrar		=	"";
    }
    if(isset($_POST["IsimSoyisim"])){
        $GelenIsimSoyisim		=	Guvenlik($_POST["IsimSoyisim"]);
    }else{
        $GelenIsimSoyisim		=	"";
    }
    if(isset($_POST["TelefonNumarasi"])){
        $GelenTelefonNumarasi	=	Guvenlik($_POST["TelefonNumarasi"]);
    }else{
        $GelenTelefonNumarasi	=	"";
    }


    $MD5liSifre					=	md5($GelenSifre);

    if(($GelenEmailAdresi!="") and ($GelenSifre!="") and ($GelenSifreTekrar!="") and ($GelenIsimSoyisim!="") and ($GelenTelefonNumarasi!="") ){
        if($GelenSifre!=$GelenSifreTekrar){
            header("Location:index.php?SK=57");
            exit();
        }else{
            if($GelenSifre == "EskiSifre"){
                $SifreDegistirmeDurumu			=	0;
            }else{
                $SifreDegistirmeDurumu			=	1;
                $MD5liSifre=md5($GelenSifre);
            }

            if($EmailAdresi != $GelenEmailAdresi){
                $KontrolSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler WHERE email = ?");
                $KontrolSorgusu->execute([$GelenEmailAdresi]);
                $KullaniciSayisi	=	$KontrolSorgusu->rowCount();

                if($KullaniciSayisi>0){
                    header("Location:index.php?SK=55");
                    exit();
                }
            }

            if($SifreDegistirmeDurumu == 1){
                $KullaniciGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE uyeler SET email = ?, sifre= ?, ad_soyad = ?, TelNo = ?,guncelleme_tarihi=? WHERE uyeID = ? LIMIT 1");
                $KullaniciGuncellemeSorgusu->execute([$GelenEmailAdresi, $MD5liSifre, $GelenIsimSoyisim, $GelenTelefonNumarasi,$ZamanDamgasi,$KullaniciID]);
            }else{
                $KullaniciGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE uyeler SET email = ?, ad_soyad = ?,TelNo  = ? WHERE uyeID = ? LIMIT 1");
                $KullaniciGuncellemeSorgusu->execute([$GelenEmailAdresi, $GelenIsimSoyisim, $GelenTelefonNumarasi, $KullaniciID]);
            }

            $KayitKontrol		=	$KullaniciGuncellemeSorgusu->rowCount();

            if($KayitKontrol>0){
                $_SESSION["Kullanici"]	=	$GelenEmailAdresi;

                header("Location:index.php?SK=53");
                exit();
            }else{
                header("Location:index.php?SK=54");
                exit();
            }
        }
    }else{
        header("Location:index.php?SK=56");
        exit();
    }
}else{
    header("Location:index.php");
    exit();
}
?>