<?php

include("databaseconnection.php");

$query = $baglan->prepare('SELECT * from ogrenci where silindi_mi=0 ');//silinmemiş olan stajyerler sql ile çekilir
$query->execute();
$userList = $query->fetchAll(PDO::FETCH_OBJ);

?>