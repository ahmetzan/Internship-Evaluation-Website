<?php
session_start();
ob_start();

include("databaseconnection.php");//Bağlantıyı dahil ediyoruz.
include ("Logging.php");

$ID =$_POST["sil"];//silinecek öğrenci id si set edilir

if(isset($_POST["sil"]))
{
	
	$query = $baglan ->prepare("UPDATE ogrenci SET silindi_mi=1 WHERE student_id='".$ID."'");//o id deki öğrencinin silinme durumu 1 olur
	$query->execute();
    LogKaydet($_SESSION["kadi"],'stajyer_sil');
	exit("ok");




}
ob_end_flush();
?>