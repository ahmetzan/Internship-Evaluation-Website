<?php
session_start();
ob_start();
include("databaseconnection.php");



if (isset($_POST['username'], $_POST['password'])) {//verilerin boş olup olmadığı kontrol edildikten sonra atama işlemleri yapılır

    $name = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
    $password = password_hash($password, PASSWORD_DEFAULT);
    try {


        $sql_check = $baglan->prepare("SELECT * from admin where kullanici_adi = '" . $name . "' "); //sql sorgusu ile kullanıcı adının alınıp alınmadığı kontrol edilir
        $sql_check->execute();
        $sonuc = $sql_check->fetch(PDO::FETCH_ASSOC);
        if ($sonuc["kullanici_adi"] == $name) {// kullanıcı adı alınmışsa failed döner ve hata alert'i çıkar
            exit ("failed");
        } else {
            $sorgu = $baglan->prepare("INSERT INTO admin(kullanici_adi, sifre) VALUES(?, ?)");//kullanici adi alinmamış ise başarılı sonuçlanır ve kayıt yapılır
            $sorgu->bindParam(1, $name, PDO::PARAM_STR);
            $sorgu->bindParam(2, $password, PDO::PARAM_STR);
            $sorgu->execute();
            exit ("ok");
        }


    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $baglan = null;
    ob_end_flush();
}
?>