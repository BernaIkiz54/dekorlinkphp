<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_POST["UrunMenusu"])){
		$GelenUrunMenusu			=	Guvenlik($_POST["UrunMenusu"]);
	}else{
		$GelenUrunMenusu			=	"";
	}
	if(isset($_POST["UrunAdi"])){
		$GelenUrunAdi				=	Guvenlik($_POST["UrunAdi"]);
	}else{
		$GelenUrunAdi				=	"";
	}
	if(isset($_POST["UrunFiyati"])){
		$GelenUrunFiyati			=	Guvenlik($_POST["UrunFiyati"]);
	}else{
		$GelenUrunFiyati			=	"";
	}
	if(isset($_POST["KargoUcreti"])){
		$GelenKargoUcreti			=	Guvenlik($_POST["KargoUcreti"]);
	}else{
		$GelenKargoUcreti			=	"";
	}
	if(isset($_POST["UrunAciklamasi"])){
		$GelenUrunAciklamasi		=	Guvenlik($_POST["UrunAciklamasi"]);
	}else{
		$GelenUrunAciklamasi		=	"";
	}


    if(isset($_POST["CokSatan"])){
        $GelenCokSatan		=	Guvenlik($_POST["CokSatan"]);
    }else{
        $GelenCokSatan		=	"";
    }



    if(isset($_POST["OneCikan"])){
        $GelenOneCikan		=	Guvenlik($_POST["OneCikan"]);
    }else{
        $GelenOneCikan		=	"";
    }




    if(isset($_POST["Indirimli"])){
        $GelenIndirimli		=	Guvenlik($_POST["Indirimli"]);
    }else{
        $GelenIndirimli		=	"";
    }



	$GelenResim1					=	$_FILES["Resim1"];
	$GelenResim2					=	$_FILES["Resim2"];
	$GelenResim3					=	$_FILES["Resim3"];
	$GelenResim4					=	$_FILES["Resim4"];
	
	if(($GelenUrunMenusu!="") and ($GelenUrunAdi!="") and ($GelenUrunFiyati!="") and ($GelenKargoUcreti!="") and ($GelenUrunAciklamasi!="")and ($GelenResim1["name"]!="") and ($GelenResim1["type"]!="") and ($GelenResim1["tmp_name"]!="") and ($GelenResim1["error"]==0) and ($GelenResim1["size"]>0)){
		$MenuTuruSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM kategori WHERE id = ? LIMIT 1");
		$MenuTuruSorgusu->execute([$GelenUrunMenusu]);
		$MenuTuruKontrol		=	$MenuTuruSorgusu->rowCount();
		$MenuTuruKaydi			=	$MenuTuruSorgusu->fetch(PDO::FETCH_ASSOC);
			$ResimKlasoru	=	"UrunResimleri/ürünler/";

		if($MenuTuruKontrol>0){
			$BirinciResimIcinDosyaAdi		=	ResimAdiOlustur();
			$GelenBirinciResminUzantisi		=	substr($GelenResim1["name"], -4);
				if($GelenBirinciResminUzantisi=="jpeg"){
					$GelenBirinciResminUzantisi		=	".".$GelenBirinciResminUzantisi;
				}
			$BirinciResimIcinYeniDosyaAdi		=	$BirinciResimIcinDosyaAdi.$GelenBirinciResminUzantisi;

			$UrunEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO urun ( urun_adi,aciklama, kategori_id,fiyat,  UrunResmiBir,  KargoUcreti, Durumu) values (?, ?, ?, ?, ?, ?, ?)");
			$UrunEklemeSorgusu->execute([$GelenUrunAdi, $GelenUrunAciklamasi, $GelenUrunMenusu,$GelenUrunFiyati, $BirinciResimIcinYeniDosyaAdi,$GelenKargoUcreti, 1]);
			$UrunEklemeKontrol		=	$UrunEklemeSorgusu->rowCount();
		
			if($UrunEklemeKontrol>0){
				$SonEklenenUrununIDsi		=	$VeritabaniBaglantisi->lastInsertId();

                $UrunDetayEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO urun_detay ( urun_id,goster_one_cikan, goster_cok_satan,goster_indirimli,  urunresmi) values (?, ?, ?, ?, ?)");
                $UrunDetayEklemeSorgusu->execute([$SonEklenenUrununIDsi, $GelenOneCikan, $GelenCokSatan,$GelenIndirimli, $BirinciResimIcinYeniDosyaAdi]);
                $UrunDetayEklemeKontrol		=	$UrunDetayEklemeSorgusu->rowCount();









				$BirinciResimYukle	=	new upload($GelenResim1, "tr-TR");
					if($BirinciResimYukle->uploaded){
					   $BirinciResimYukle->mime_magic_check			=	true;
					   $BirinciResimYukle->allowed					=	array("image/*");
					   $BirinciResimYukle->file_new_name_body		=	$BirinciResimIcinDosyaAdi;
					   $BirinciResimYukle->file_overwrite			=	true;
					   //$BirinciResimYukle->image_convert			=	"png";
					   $BirinciResimYukle->image_quality			=	100;
					   $BirinciResimYukle->image_background_color	=	"#FFFFFF";
					   $BirinciResimYukle->image_resize				=	true;
					   $BirinciResimYukle->image_x					=	600;
					   $BirinciResimYukle->image_y					=	800;
					   $BirinciResimYukle->process($VerotIcinKlasorYolu.$ResimKlasoru);

						if($BirinciResimYukle->processed){
							$BirinciResimYukle->clean();
						}else{
							header("Location:index.php?SKD=0&SKI=98");
							exit();
						} 
					}		
			
				$MenuUrunSayisiGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE kategori SET UrunSayisi=UrunSayisi+1 WHERE id = ? LIMIT 1");
				$MenuUrunSayisiGuncellemeSorgusu->execute([$GelenUrunMenusu]);
				$MenuUrunSayisiGuncellemeKontrol	=	$MenuUrunSayisiGuncellemeSorgusu->rowCount();
		
				if($MenuUrunSayisiGuncellemeKontrol>0){
						if(($GelenResim2["name"]!="") and ($GelenResim2["type"]!="") and ($GelenResim2["tmp_name"]!="") and ($GelenResim2["error"]==0) and ($GelenResim2["size"]>0)){
							$IkinciResimIcinDosyaAdi		=	ResimAdiOlustur();
							$GelenIkinciResminUzantisi		=	substr($GelenResim2["name"], -4);
								if($GelenIkinciResminUzantisi=="jpeg"){
									$GelenIkinciResminUzantisi		=	".".$GelenIkinciResminUzantisi;
								}
							$IkinciResimIcinYeniDosyaAdi	=	$IkinciResimIcinDosyaAdi.$GelenIkinciResminUzantisi;

							$IkinciResimYukle	=	new upload($GelenResim2, "tr-TR");
								if($IkinciResimYukle->uploaded){
								   $IkinciResimYukle->mime_magic_check			=	true;
								   $IkinciResimYukle->allowed					=	array("image/*");
								   $IkinciResimYukle->file_new_name_body		=	$IkinciResimIcinDosyaAdi;
								   $IkinciResimYukle->file_overwrite			=	true;
								   //$IkinciResimYukle->image_convert			=	"png";
								   $IkinciResimYukle->image_quality				=	100;
								   $IkinciResimYukle->image_background_color	=	"#FFFFFF";
								   $IkinciResimYukle->image_resize				=	true;
								   $IkinciResimYukle->image_x					=	600;
								   $IkinciResimYukle->image_y					=	800;
								   $IkinciResimYukle->process($VerotIcinKlasorYolu.$ResimKlasoru);

									if($IkinciResimYukle->processed){
										$IkinciResimGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urun SET UrunResmiIki = ? WHERE id = ? LIMIT 1");
										$IkinciResimGuncellemeSorgusu->execute([$IkinciResimIcinYeniDosyaAdi, $SonEklenenUrununIDsi]);
										$IkinciResimGuncellemeKontrol	=	$IkinciResimGuncellemeSorgusu->rowCount();
										
										if($IkinciResimGuncellemeKontrol<1){
											header("Location:index.php?SKD=0&SKI=98");
											exit();
										}
										
										$IkinciResimYukle->clean();
									}else{
										header("Location:index.php?SKD=0&SKI=98");
										exit();
									} 
								}									
						}
		
						if(($GelenResim3["name"]!="") and ($GelenResim3["type"]!="") and ($GelenResim3["tmp_name"]!="") and ($GelenResim3["error"]==0) and ($GelenResim3["size"]>0)){
							$UcuncuResimIcinDosyaAdi		=	ResimAdiOlustur();
							$GelenUcuncuResminUzantisi		=	substr($GelenResim3["name"], -4);
								if($GelenUcuncuResminUzantisi=="jpeg"){
									$GelenUcuncuResminUzantisi		=	".".$GelenUcuncuResminUzantisi;
								}
							$UcuncuResimIcinYeniDosyaAdi	=	$UcuncuResimIcinDosyaAdi.$GelenUcuncuResminUzantisi;

							$UcuncuResimYukle	=	new upload($GelenResim3, "tr-TR");
								if($UcuncuResimYukle->uploaded){
								   $UcuncuResimYukle->mime_magic_check			=	true;
								   $UcuncuResimYukle->allowed					=	array("image/*");
								   $UcuncuResimYukle->file_new_name_body		=	$UcuncuResimIcinDosyaAdi;
								   $UcuncuResimYukle->file_overwrite			=	true;
								   //$UcuncuResimYukle->image_convert			=	"png";
								   $UcuncuResimYukle->image_quality				=	100;
								   $UcuncuResimYukle->image_background_color	=	"#FFFFFF";
								   $UcuncuResimYukle->image_resize				=	true;
								   $UcuncuResimYukle->image_x					=	600;
								   $UcuncuResimYukle->image_y					=	800;
								   $UcuncuResimYukle->process($VerotIcinKlasorYolu.$ResimKlasoru);

									if($UcuncuResimYukle->processed){
										$UcuncuResimGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urun SET UrunResmiUc = ? WHERE id = ? LIMIT 1");
										$UcuncuResimGuncellemeSorgusu->execute([$UcuncuResimIcinYeniDosyaAdi, $SonEklenenUrununIDsi]);
										$UcuncuResimGuncellemeKontrol	=	$UcuncuResimGuncellemeSorgusu->rowCount();
										
										if($UcuncuResimGuncellemeKontrol<1){
											header("Location:index.php?SKD=0&SKI=98");
											exit();
										}
										
										$UcuncuResimYukle->clean();
									}else{
										header("Location:index.php?SKD=0&SKI=98");
										exit();
									} 
								}									
						}		

						if(($GelenResim4["name"]!="") and ($GelenResim4["type"]!="") and ($GelenResim4["tmp_name"]!="") and ($GelenResim4["error"]==0) and ($GelenResim4["size"]>0)){
							$DorduncuResimIcinDosyaAdi		=	ResimAdiOlustur();
							$GelenDorduncuResminUzantisi	=	substr($GelenResim4["name"], -4);
								if($GelenDorduncuResminUzantisi=="jpeg"){
									$GelenDorduncuResminUzantisi		=	".".$GelenDorduncuResminUzantisi;
								}
							$DorduncuResimIcinYeniDosyaAdi	=	$DorduncuResimIcinDosyaAdi.$GelenDorduncuResminUzantisi;

							$DorduncuResimYukle	=	new upload($GelenResim4, "tr-TR");
								if($DorduncuResimYukle->uploaded){
								   $DorduncuResimYukle->mime_magic_check			=	true;
								   $DorduncuResimYukle->allowed						=	array("image/*");
								   $DorduncuResimYukle->file_new_name_body			=	$DorduncuResimIcinDosyaAdi;
								   $DorduncuResimYukle->file_overwrite				=	true;
								   //$DorduncuResimYukle->image_convert				=	"png";
								   $DorduncuResimYukle->image_quality				=	100;
								   $DorduncuResimYukle->image_background_color		=	"#FFFFFF";
								   $DorduncuResimYukle->image_resize				=	true;
								   $DorduncuResimYukle->image_x						=	600;
								   $DorduncuResimYukle->image_y						=	800;
								   $DorduncuResimYukle->process($VerotIcinKlasorYolu.$ResimKlasoru);

									if($DorduncuResimYukle->processed){
										$DorduncuResimGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urun SET UrunResmiDort = ? WHERE id = ? LIMIT 1");
										$DorduncuResimGuncellemeSorgusu->execute([$DorduncuResimIcinYeniDosyaAdi, $SonEklenenUrununIDsi]);
										$DorduncuResimGuncellemeKontrol	=	$DorduncuResimGuncellemeSorgusu->rowCount();
										
										if($DorduncuResimGuncellemeKontrol<1){
											header("Location:index.php?SKD=0&SKI=98");
											exit();
										}
										
										$DorduncuResimYukle->clean();
									}else{
										header("Location:index.php?SKD=0&SKI=98");
										exit();
									} 
								}									
						}	
	
						header("Location:index.php?SKD=0&SKI=97");
						exit();
				}else{
					header("Location:index.php?SKD=0&SKI=98");
					exit();
				}
			}else{
				header("Location:index.php?SKD=0&SKI=98");
				exit();
			}
		}else{
			header("Location:index.php?SKD=0&SKI=98");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=98");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>