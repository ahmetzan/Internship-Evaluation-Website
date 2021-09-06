<?php

session_start();
ob_start();
include("databaseconnection.php");
include ("Logging.php");
//bütün veriler set edildi mi diye kontrol edilir
 if (isset($_POST['stid'], $_POST['name'], $_POST['lastname'], $_POST['school'], $_POST['begindate'], $_POST['enddate'], $_POST['mail'], $_POST['phonenumber'], $_POST['project'])) {
    $stid = trim(filter_input(INPUT_POST, 'stid', FILTER_SANITIZE_STRING));
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
    $school = trim(filter_input(INPUT_POST, 'school', FILTER_SANITIZE_STRING));
    $begindate = trim(filter_input(INPUT_POST, 'begindate', FILTER_SANITIZE_STRING));
    $enddate = trim(filter_input(INPUT_POST, 'enddate', FILTER_SANITIZE_STRING));
    $mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_STRING));
    $phonenumber = trim(filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING));
    $project = trim(filter_input(INPUT_POST, 'project', FILTER_SANITIZE_STRING));


    try {


        $sql_check = $baglan->prepare("select mail from ogrenci where mail = '".$mail."'  and student_id !='".$stid."' ");
        $sql_check->execute();
        $sonuc1= $sql_check->fetch(PDO::FETCH_ASSOC);

        $sql_check = $baglan->prepare("select tel from ogrenci where tel = '".$phonenumber."'  and student_id !='".$stid."' ");
        $sql_check->execute();
        $sonuc= $sql_check->fetch(PDO::FETCH_ASSOC);

        if($begindate > $enddate)//başlangıç tarihinin bitişten sonra olmaması için kontrol
        {
            exit("tarih");
        }
        if($begindate == $enddate)//başlangıç tarihinin bitişle aynı olmaması için kontrol
        {
            exit("aynı");
        }

        if($sonuc1)// maillerin unique olması için kontrol
        {
            exit ("mail");

        }
        if($sonuc)// telefon numaralının unique olması için kontrol
        {
            exit ("telefon");
        }


        if($sonuc == false   && $sonuc1 == false)// tüm koşullar sağlandığında pdo ile update yapılır
        {
            $sorgu = $baglan->prepare("UPDATE ogrenci  SET ad='".$name."', soyad='".$lastname."', okul= '".$school."' , baslama_tarihi='".$begindate."', bitirme_tarihi='".$enddate."', mail='".$mail."', tel='".$phonenumber."', yaptigi_proje='".$project."' WHERE student_id='".$stid."'");
            $sorgu->bindParam(1, $name, PDO::PARAM_STR);
            $sorgu->bindParam(2, $lastname, PDO::PARAM_STR);
            $sorgu->bindParam(3, $school, PDO::PARAM_STR);
            $sorgu->bindParam(4, $begindate, PDO::PARAM_STR);
            $sorgu->bindParam(5, $enddate, PDO::PARAM_STR);
            $sorgu->bindParam(6, $mail, PDO::PARAM_STR);
            $sorgu->bindParam(7, $phonenumber, PDO::PARAM_STR);
            $sorgu->bindParam(8, $project, PDO::PARAM_STR);
            $sorgu->execute();


            LogKaydet($_SESSION["kadi"],'stajyer_guncelleme');
            exit("ok");

        }
    
  }catch (PDOException $e) {
        die($e->getMessage());
   }



}
?>