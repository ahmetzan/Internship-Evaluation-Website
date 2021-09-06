<?php
session_start();
ob_start();
include("databaseconnection.php");
include ("Logging.php");
$kriterSil = $_POST["kriterSil"];
//Kriter Silmek İçin veritabanı Sorgusu
$silQuery = $baglan->prepare("DELETE FROM degerlendirme_kriterleri WHERE kriter_id='".$kriterSil."'");
$silQuery->execute();

$ogrencidenSilQuery = $baglan->prepare("DELETE FROM ogrenci_degerlendirme WHERE kriter_id='".$kriterSil."'");
$ogrencidenSilQuery->execute();
LogKaydet($_SESSION["kadi"],'kriter_sil');

ob_end_flush();


?>

