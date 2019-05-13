<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';

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
$MD5liSifre					=	md5($GelenSifre);
if(($GelenEmailAdresi!="") and ($GelenSifre!="")){

}else{
    header("Location:index.php?SK=35");
    exit();
}
?>