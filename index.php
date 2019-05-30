<?php
session_start(); ob_start();
require_once("Ayarlar/ayar.php");
require_once("Ayarlar/fonksiyonlar.php");
require_once("Ayarlar/sitesayfalari.php");
if (isset($_REQUEST["SK"])) {
    $SayfaKoduDegeri = SayiliIcerikleriFiltrele($_REQUEST["SK"]);
} else {
    $SayfaKoduDegeri = 0;
}
if(isset($_REQUEST["SYF"])){
	$Sayfalama			=	SayiliIcerikleriFiltrele($_REQUEST["SYF"]);
}else{
	$Sayfalama			=	1;
}
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="revisit-after" content="7 Days">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo DonusumleriGeriDondur($SiteTitle); ?></title>
        <link type="text/css" rel="icon" href="Resimler/Favicon.png">
        <meta name="description" content="<?php echo DonusumleriGeriDondur($SiteDescription); ?>">
        <meta name="keywords" content="<?php echo DonusumleriGeriDondur($SiteKeywords); ?>">
        <script type="text/javascript" src="Frameworks/JQuery/jquery-3.3.1.min.js" language="javascript"></script>
        <link type="text/css" rel="stylesheet" href="Ayarlar/stil.css">
        <script type="text/javascript" src="Ayarlar/fonksiyonlar.js" language="javascript"></script>
    </head>
    <body>
    <table width="1065" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="40px" bgcolor="353745">
            <td><img src="Resimler/HeaderMesajResmi.png" border="0"></td>
        </tr>
        <tr height="110">
            <td>
                <table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr bgcolor="#0088CC">
                        <td>&nbsp;</td>
                        <?php
                        if(isset($_SESSION["Kullanici"])){
                            ?>
                            <td width="20"><a href="index.php?SK=50"><img src="Resimler/KullaniciBeyaz16x16.png" border="0" style="margin-top: 5px;"></a></td>
                            <td width="70" class="MaviAlanMenusu"><a href="index.php?SK=50">Hesabım</a></td>
                            <td width="20"><a href="index.php?SK=49"><img src="Resimler/CikisBeyaz16x16.png" border="0" style="margin-top: 5px;"></a></td>
                            <td width="85" class="MaviAlanMenusu"><a href="index.php?SK=49">Çıkış Yap</a></td>
                            <?php
                        }else{
                            ?>
                            <td width="20"><a href="index.php?SK=31"><img src="Resimler/KullaniciBeyaz16x16.png" border="0" style="margin-top: 5px;"></a></td>
                            <td width="70" class="MaviAlanMenusu"><a href="index.php?SK=31">Giriş Yap</a></td>
                            <td width="20"><a href="index.php?SK=22"><img src="Resimler/KullaniciEkleBeyaz16x16.png" border="0" style="margin-top: 5px;"></a></td>
                            <td width="85" class="MaviAlanMenusu"><a href="index.php?SK=22">Yeni Üye Ol</a></td>
                            <?php
                        }
                        ?>
                        <td width="20"><?php if(isset($_SESSION["Kullanici"])){ ?><a href="index.php?SK=94"><img src="Resimler/SepetBeyaz16x16.png" border="0" style="margin-top: 5px;"></a><?php }else{ ?><img src="Resimler/SepetBeyaz16x16.png" border="0" style="margin-top: 5px;"><?php } ?></td>
                        <td width="103" class="MaviAlanMenusu"><?php if(isset($_SESSION["Kullanici"])){ ?><a href="index.php?SK=94">Alışveriş Sepeti</a><?php }else{ ?>Alışveriş Sepeti<?php } ?></td>
                    </tr>
                </table>
                <table width="1065" height="80" align="center" border="0" bgcolor="white" cellpadding="0"
                       cellspacing="0">
                    <tr>
                        <td width="208" class="AnaMenu" style="padding-left: 120px;"><a href="index.php?SK=0">Anasayfa</a></td>
                        <td width="207" class="AnaMenu"><a href="index.php?SK=84">Mobilya</a></td>
                        <td width="200" class="AnaMenu"><a href="index.php?SK=85">Mutfak</a></td>
                        <td width="203" class="AnaMenu"><a href="index.php?SK=86">Ev Dekorasyon</a></td>
                        <td width="213" class="AnaMenu"><a href="index.php?SK=107">Aydınlatma</a></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <?php
                            if((!$SayfaKoduDegeri) or ($SayfaKoduDegeri == "") or ($SayfaKoduDegeri == 0)){
                                include($Sayfa[0]);
                            }else {
                                include($Sayfa[$SayfaKoduDegeri]);
                            }
                            ?>
                            </br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr height="210">
            <td>

                <table width="1065" align="center" border="0" bgcolor="F9F9F9" cellpadding="0" cellspacing="0">
                    <tr height="30">
                        <td width="250" style="border-bottom: 1px solid #CCCCCC;">&nbsp;<b>Kurumsal</b></td>
                        <td width="22">&nbsp</td>
                        <td width="250" style="border-bottom: 1px solid #CCCCCC;"><b>Üyelik Ve Hizmetler</b></td>
                        <td width="22">&nbsp</td>
                        <td width="250" style="border-bottom: 1px solid #CCCCCC;"><b>Sözleşmeler</b></td>
                        <td width="21">&nbsp</td>
                        <td width="250" style="border-bottom: 1px solid #CCCCCC;"><b>Bizi Takip Edin</b></td>
                    </tr>

                    <tr height="30">
                        <td class="AltMenusu">&nbsp;<a href="index.php?SK=1">Hakkımızda</a></td>
                        <td>&nbsp;</td>
                        <?php
                        if(isset($_SESSION["Kullanici"])){
                            ?>
                            <td class="AltMenusu"><a href="index.php?SK=50">Hesabım</a></td>
                            <?php
                        }else{
                            ?>
                            <td class="AltMenusu"><a href="index.php?SK=31">Giriş Yap</a></td>
                            <?php
                        }
                        ?>
                        <td>&nbsp;</td>
                        <td class="AltMenusu"><a href="index.php?SK=2">Üyelik Sözleşmesi</a></td>
                        <td>&nbsp;</td>
                        <td>
                            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20"><a href="xxxxxx"><img src="Resimler/Facebook16x16.png" border="0"
                                                                         style="margin-top: 5px;"></a></td>
                                    <td width="230" class="AltMenusu"><a href="<?php echo DonusumleriGeriDondur($SosyalLinkFacebook); ?>">Facebook</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="30">
                        <td class="AltMenusu">&nbsp;<a href="index.php?SK=8">Banka Hesaplarımız</a></td>
                        <td>&nbsp;</td>
                        <?php
                        if(isset($_SESSION["Kullanici"])){
                            ?>
                            <td class="AltMenusu"><a href="index.php?SK=49">Çıkış Yap</a></td>
                            <?php
                        }else{
                            ?>
                            <td class="AltMenusu"><a href="index.php?SK=22">Yeni Üye Ol</a></td>
                            <?php
                        }
                        ?>
                        <td>&nbsp;</td>
                        <td class="AltMenusu"><a href="index.php?SK=3">Kullanım Koşulları</a></td>
                        <td>&nbsp;</td>
                        <td>
                            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20"><a href="xxxxxx"><img src="Resimler/Twitter16x16.png" border="0"
                                                                         style="margin-top: 5px;"></a></td>
                                    <td class="AltMenusu" width="230"><a href="<?php echo DonusumleriGeriDondur($SosyalLinkTwitter); ?>">Twitter</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr height="30">
                        <td class="AltMenusu">&nbsp;<a href="index.php?SK=9">Havale Bildirim Formu</a></td>
                        <td>&nbsp;</td>
                        <td class="AltMenusu"><a href="xxxxxx">Sık Sorulan Sorular</a></td>
                        <td>&nbsp;</td>
                        <td class="AltMenusu"><a href="index.php?SK=4">Gizlilik Sözleşmesi</a></td>
                        <td>&nbsp;</td>
                        <td>
                            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20"><a href="xxxxxx"><img src="Resimler/LinkedIn16x16.png" border="0"
                                                                         style="margin-top: 5px;"></a></td>
                                    <td class="AltMenusu" width="230"><a href="<?php echo DonusumleriGeriDondur($SosyalLinkLinkedin); ?>">Linkedin</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="30">
                        <td class="AltMenusu">&nbsp;<a href="index.php?SK=14">Kargom Nerede</a></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="AltMenusu"><a href="index.php?SK=5">Mesafeli Satış Sözleşmesi</a></td>
                        <td>&nbsp;</td>
                        <td>
                            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20"><a href="xxxxxx"><img src="Resimler/Instagram16x16.png" border="0"
                                                                         style="margin-top: 5px;"></a></td>
                                    <td width="230" class="AltMenusu"><a href="<?php echo DonusumleriGeriDondur($SosyalLinkInstagram); ?>">Instagram</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="30">
                        <td class="AltMenusu">&nbsp;<a href="index.php?SK=16">İletişim<a></a></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="AltMenusu"><a href="index.php?SK=6">Teslimat</a></td>
                        <td>&nbsp;</td>
                        <td>
                            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20"><a href="xxxxxx"><img src="Resimler/YouTube16x16.png" border="0"
                                                                         style="margin-top: 5px;"></a></td>
                                    <td width="230" class="AltMenusu"><a href="<?php echo DonusumleriGeriDondur($SosyalLinkYouTube); ?>">Youtube</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="30">
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="AltMenusu"><a href="index.php?SK=7">İptal & İade & Değişim</a></td>
                        <td>&nbsp;</td>
                        <td>
                            <table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20"><a href="xxxxxx"><img src="Resimler/Pinterest16x16.png" border="0"
                                                                         style="margin-top: 5px;"></a></td>
                                    <td width="230" class="AltMenusu"><a href="<?php echo DonusumleriGeriDondur($SosyalLinkPinterest); ?>">Pinterest</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>


        <tr height="30">
            <td>
                <table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center"><?php echo DonusumleriGeriDondur($SiteCopyrightMetni); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr height="30">
            <td>
                <table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <img src="Resimler/BonusCard41x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/MaximumCard46x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/WorldCard48x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/CardFinans78x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/AxessCard46x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/ParafCard19x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/VisaCard37x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/MasterCard21x12.png" border="0" style="margin-right: 5px;">
                            <img src="Resimler/AmericanExpiress20x12.png" border="0" style="margin-right: 5px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>
<?php
$VeritabaniBaglantisi = null;
ob_end_flush();
?>