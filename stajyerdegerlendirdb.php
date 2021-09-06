<?php

session_start();
ob_start();
include("databaseconnection.php");
include ("Logging.php");
$key = $_POST["student_id"];
$kriterler = $_POST["kriterler"];
$yorum = $_POST["yorum"];
$puan = count($kriterler) * 10;
$basari="";





$kriterQuery = $baglan->prepare('SELECT * from degerlendirme_kriterleri');// veritabanından bütün kriterler toplam kriter sayısı ile toplam puan belirlenir ve öğrencinin başarılı olup olmadığı belirlenir
$kriterQuery->execute();
$kriter = $kriterQuery->fetchAll(PDO::FETCH_OBJ);


$basariQuery = $baglan->prepare("SELECT puan FROM ogrenci WHERE student_id='" . $key . "'");//ogrencinin puanına göre başarılı olup olmadığı belirlenir
$basariQuery->execute();
$databasePuan = $basariQuery->fetchAll(PDO::FETCH_OBJ);

if(count($kriterler)*10 >= (count($kriter)*10)/2 )//öğrencinin başarı durumu toplam kriter * 10 / 2 yani toplam puanının yarısına eşit veya fazla olmasına göre belirlenir
{
    $basari = 1;
}

else if(count($kriterler)*10 < (count($kriter)*10)/2 )
{
    $basari = 2;
}



$silQuery = $baglan->prepare("DELETE FROM ogrenci_degerlendirme WHERE student_id='" . $key . "'");// değerlendirme kriterleri tablosunda kayıt tekrarını engellemek için her değerlendir butonuna basıldığında önceki veriler silinir
$silQuery->execute();


if (count($kriterler) == 0) {//eğer hiçbir kriter seçilmediyse öğrenci de  0 puan ile değerlendirilmiş olmakta
    $ogrenciQuery = $baglan->prepare("UPDATE ogrenci SET  puan = '" . $puan . "' , yorum ='" . $yorum . "', degerlendiren='".$_SESSION['kadi']."' , durum ='".$basari."' WHERE student_id='" . $key . "'");
    $ogrenciQuery->execute();



} else {// eğer kriter seçildiyse öğrenciye bu seçilen kriterler eklenir
    foreach ($kriterler as $kriter) {

        $sorgu = $baglan->prepare("SELECT * from ogrenci_degerlendirme where student_id= '" . $key . "' and kriter_id='" . $kriter . "'");
        $sorgu->execute();
        $list = $sorgu->fetchAll(PDO::FETCH_OBJ);



            $ogrenciQuery = $baglan->prepare("UPDATE ogrenci SET  puan = '" . $puan . "' , yorum ='" . $yorum . "' , degerlendiren='".$_SESSION['kadi']."', durum ='".$basari."' WHERE student_id='" . $key . "'");
            $ogrenciQuery->execute();

            $query = $baglan->prepare("INSERT INTO ogrenci_degerlendirme(student_id, kriter_id) values(?,?)");
            $query->bindParam(1, $key, PDO::PARAM_STR);
            $query->bindParam(2, $kriter, PDO::PARAM_STR);
            $query->execute();



    }
}

LogKaydet($_SESSION["kadi"],'stajyer_degerlendirme');
ob_end_flush();
?>