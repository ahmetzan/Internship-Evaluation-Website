<?php
session_start();
ob_start();
include("databaseconnection.php");
include("Logging.php");

// Login page'den gelen kullanici adi ve sifre dataları bu değişkenlere atanıp sql işlemleri yapılmaktadır.
$kadi = $_POST["kadi"];
$sifre = $_POST["sifre"];

$sql_check = $baglan->prepare("select * from admin where kullanici_adi= '".$kadi."'");
$sql_check->execute();
$sonuc= $sql_check->fetch(PDO::FETCH_ASSOC);

//Sifre ve kullanici adi sql sorgusu ile uyuşursa ajax'a başarılı bilgisi gönderilir
if(password_verify($sifre, $sonuc['sifre']))  {
    $_SESSION["kadi"] =$kadi;
    $_SESSION["sifre"] = $verifySifre;
    LogKaydet($kadi,'login');
    exit ("ok");

}
//sifre ya da kullanici adi hatali ise ekrana ajax' hatalı bilgisi gönderilir
else {
    exit('failed');
}
ob_end_flush();
?>