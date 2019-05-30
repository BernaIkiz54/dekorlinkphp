<?php
if(isset($_SESSION["Kullanici"])){
	if(isset($_GET["ID"])){
		$GelenID		=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID		=	"";
	}
	if($GelenID!=""){
		$KullanicininSepetKontrolSorgu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepetweb WHERE UyeId = ? ORDER BY id DESC LIMIT 1");
		$KullanicininSepetKontrolSorgu->execute([$KullaniciID]);
		$KullanicininSepetSayisi		=	$KullanicininSepetKontrolSorgu->rowCount();
		if($KullanicininSepetSayisi>0){
			$UrunSepetKontrolSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepetweb WHERE UyeId = ? AND UrunId = ? AND  LIMIT 1");
			$UrunSepetKontrolSorgusu->execute([$KullaniciID, $GelenID]);
			$UrunSepetSayisi			=	$UrunSepetKontrolSorgusu->rowCount();
			$UrunSepetKaydi				=	$UrunSepetKontrolSorgusu->fetch(PDO::FETCH_ASSOC);
			if($UrunSepetSayisi>0){
				$UrununIDsi						=	$UrunSepetKaydi["id"];
				$UrununSepettekiMevcutAdedi		=	$UrunSepetKaydi["UrunAdedi"];
				$UrununYeniAdedi				=	$UrununSepettekiMevcutAdedi+1;
				$UrunGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE sepetweb SET UrunAdedi = ? WHERE id = ? AND UyeId = ? AND UrunId = ? LIMIT 1");
				$UrunGuncellemeSorgusu->execute([$UrununYeniAdedi, $UrununIDsi, $KullaniciID, $GelenID]);
				$UrunGuncellemeSayisi		=	$UrunGuncellemeSorgusu->rowCount();

					if($UrunGuncellemeSayisi>0){
						header("Location:index.php?SK=94");
						exit();
					}else{
						header("Location:index.php?SK=92");
						exit();
					}
			}else{
				$UrunEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO sepetweb (UyeId, UrunId, VaryantId, UrunAdedi) values (?, ?, ?, ?)");
				$UrunEklemeSorgusu->execute([$KullaniciID, $GelenID, 0, 1]);
				$UrunEklemeSayisi		=	$UrunEklemeSorgusu->rowCount();
				$SonIdDegeri			=	$VeritabaniBaglantisi->lastInsertId();

					if($UrunEklemeSayisi>0){
						$SiparisNumarasiniGuncelleSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE sepetweb SET SepetNumarasi = ? WHERE UyeId = ?");
						$SiparisNumarasiniGuncelleSorgusu->execute([$SonIdDegeri, $KullaniciID]);
						$SiparisNumarasiniGuncelleSayisi		=	$SiparisNumarasiniGuncelleSorgusu->rowCount();
							if($SiparisNumarasiniGuncelleSayisi>0){
								header("Location:index.php?SK=94");
								exit();
							}else{
								header("Location:index.php?SK=92");
								exit();
							}
					}else{
						header("Location:index.php?SK=92");
						exit();
					}
			}
		}else{
			$UrunEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO sepetweb (UyeId, UrunId, UrunAdedi) values (?, ?, ?)");
			$UrunEklemeSorgusu->execute([$KullaniciID, $GelenID, 1]);
			$UrunEklemeSayisi		=	$UrunEklemeSorgusu->rowCount();
            $UrunEklemeKayit		=	$UrunEklemeSorgusu->fetch(PDO::FETCH_ASSOC);
			$SonIdDegeri			=	$VeritabaniBaglantisi->lastInsertId();
				if($UrunEklemeSayisi>0){
					$SiparisNumarasiniGuncelleSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE sepetweb SET SepetNumarasi = ? WHERE UyeId = ?");
					$SiparisNumarasiniGuncelleSorgusu->execute([$SonIdDegeri, $KullaniciID]);
					$SiparisNumarasiniGuncelleSayisi		=	$SiparisNumarasiniGuncelleSorgusu->rowCount();

						if($SiparisNumarasiniGuncelleSayisi>0){
							header("Location:index.php?SK=94");
							exit();
						}else{
							header("Location:index.php?SK=92");
							exit();
						}
				}else{
					header("Location:index.php?SK=92");
					exit();
				}
		}
	}else{
		header("Location:index.php");
		exit();
	}
}else{
	header("Location:index.php?SK=93");
	exit();
}
?>