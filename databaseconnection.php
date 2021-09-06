<?php
$vt_sunucu= "localhost";
$vt_kullanici= "root";
$vt_sifre= "123456789";
$vt_adi= "stajdegerlendirme";

// PDO ile daha güvenli bir bağlantı oluşturulur.
try {
    $baglan = new PDO("mysql:host=$vt_sunucu;dbname=stajdegerlendirme;charset=utf8", $vt_kullanici, $vt_sifre);
    $baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Bağlantı başarılı"; 
   
    }
catch(PDOException $e)
    {
        var_dump($e->getMessage());
    }
?>


