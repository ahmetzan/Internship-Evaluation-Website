<?php
session_start();
//session unset edilir ve loginpage.php sayfasına yönlendirilir.
unset($_SESSION["kadi"]);
unset($_SESSION["sifre"]);
echo "<script type='text/javascript'>window.location='loginpage.php';</script>"; exit();
?>

