<!DOCTYPE html>
<!--
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.0.0
Author: Sunnyat Ahmmed
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>
        Giriş
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <!-- Optional: page related CSS-->
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="loginBg.css">

</head>
<body>
<div id="bg1"></div>
<div id="bg2"></div>

<div id="particleGenerator"></div>

            <div class="card">

                <form onsubmit="event.preventDefault()" class="box" id="login">
                    <h1>Stajyer Değerlendirme</h1>
                    <p class="text-muted">Lütfen kullanıcı adı ve şifrenizi giriniz!</p>
                    <input type="text" id="username" required="" placeholder="Kullanıcı Adı">
                    <input type="password" id="password" placeholder="Şifre" required="">
                    <input type="submit" name="" value="Giriş Yap">
                    <a class="forgot text-muted" href="register.php"><b>Hesap Oluştur</b></a>

                </form>
            </div>

<!-- base vendor bundle:
     DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations
                + pace.js (recommended)
                + jquery.js (core)
                + jquery-ui-cust.js (core)
                + popper.js (core)
                + bootstrap.js (core)
                + slimscroll.js (extension)
                + app.navigation.js (core)
                + ba-throttle-debounce.js (core)
                + waves.js (extension)
                + smartpanels.js (extension)
                + src/../jquery-snippets.js (core) -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>
    // formdaki kullanici adi ve şifre bilgileri çekilerek logindb.php ye bu bilgiler gönderilir. dönen sonuca göre giriş yapılır ya da hatalı giriş alerti çıkar
    $(document).ready(function () {
        $("form#login").submit(function (event) {
            event.preventDefault();
            var username = $("#username").val();
            var password = $("#password").val();
            $.ajax({

                url: 'logindb.php',
                type: 'POST',
                data: {
                    kadi: username,
                    sifre: password
                },
                success: function (response) {
                    if (response.includes("ok")) {
                        setTimeout(function () {
                            window.location = 'anaSayfa.php';
                        }, 1000);

                    } else {
                        swal({
                            text: "Hata! Kullanıcı Adı Veya Şifre Hatalı!",
                            icon: 'error',
                            button: false,
                            timer: 1000,
                        });

                    }
                },
                dataType: "text"
            });
        });
    });

</script>
<script src="sweetalert.min.js"></script>
<script src="loginBg.js"></script>

</body>
</html>
