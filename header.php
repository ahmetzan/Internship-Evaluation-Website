<?php
session_start(); ?>
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
        Stajyer Değerlendirme
    </title>
    <meta name="description" content="Input Mask">
    <meta name="description" content="Page Titile">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->

    <link rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">

    <link rel="stylesheet" media="screen, print" href="css/app.bundle.css">

    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="css/datagrid/datatables/datatables.bundle.css">
    <!--<link rel="stylesheet" media="screen, print" href="css/your_styles.css">-->
</head>
<body class="mod-bg-1">
<!-- DOC: script to save and load page settings -->
<script>
    /**
     *	This script should be placed right after the body tag for fast execution
     *	Note: the script is written in pure javascript and does not depend on thirdparty library
     **/
    'use strict';

    var classHolder = document.getElementsByTagName("BODY")[0],
        /**
         * Load from localstorage
         **/
        themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
        themeURL = themeSettings.themeURL || '',
        themeOptions = themeSettings.themeOptions || '';
    /**
     * Load theme options
     **/
    if (themeSettings.themeOptions)
    {
        classHolder.className = themeSettings.themeOptions;
        console.log("%c✔ Theme settings loaded", "color: #148f32");
    }
    else
    {
        console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
    }
    if (themeSettings.themeURL && !document.getElementById('mytheme'))
    {
        var cssfile = document.createElement('link');
        cssfile.id = 'mytheme';
        cssfile.rel = 'stylesheet';
        cssfile.href = themeURL;
        document.getElementsByTagName('head')[0].appendChild(cssfile);
    }
    /**
     * Save to localstorage
     **/
    var saveSettings = function()
    {
        themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
        {
            return /^(nav|header|mod|display)-/i.test(item);
        }).join(' ');
        if (document.getElementById('mytheme'))
        {
            themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
        };
        localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
    }
    /**
     * Reset settings
     **/
    var resetSettings = function()
    {
        localStorage.setItem("themeSettings", "");
    }

</script>
<!-- BEGIN Page Wrapper -->
<div class="page-wrapper">
    <div class="page-inner">
        <!-- BEGIN Left Aside -->
        <aside class="page-sidebar">
            <div class="page-logo">
                <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">

                    <span class="page-logo-text mr-1">Stajyer Değerlendirme</span>
                    <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                    <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                </a>
            </div>
            <!-- BEGIN PRIMARY NAVIGATION -->
            <nav id="js-primary-nav" class="primary-nav" role="navigation">
                <div class="nav-filter">
                    <div class="position-relative">
                        <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                        <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                            <i class="fal fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="info-card">

                    <div class="info-card-text">

                                    <span >
                                      T.C. Diyanet İşleri Başkanlığı
                                    </span>



                    </div>
                    <img src="img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">

                </div>
                <ul id="js-nav-menu" class="nav-menu">



                            <li>
                            <a href="anaSayfa.php" title="Ana Sayfa" data-filter-tags="Ana Sayfa">
                                <i class="fal fa-home"></i>
                                <span class="nav-link-text" data-i18n="nav.application_intel">Ana Sayfa</span>
                            </a>
                            </li>

                            <li>
                                <a href="stajyerliste.php" title="Stajyer Listesi" data-filter-tags="Stajyer Listesi">
                                    <i class="fal fa-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Stajyer Listesi</span>

                                </a>
                            </li>
                            <li>
                                <a href="stajyerkayit.php" title="Stajyer Kayıt" data-filter-tags="Stajyer Kayıt">
                                    <i class="fal fa-save"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel_marketing_dashboard">Stajyer Kayıt</span>
                                </a>
                            </li>





                </ul>
                <div class="filter-message js-filter-message bg-success-600"></div>
            </nav>
            <!-- END PRIMARY NAVIGATION -->
            <!-- NAV FOOTER -->

        </aside>
        <!-- END Left Aside -->
        <div class="page-content-wrapper">
            <!-- BEGIN Page Header -->
            <header class="page-header" role="banner">
                <!-- we need this logo when user switches to nav-function-top -->
                <div class="page-logo">
                    <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                        <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                        <span class="page-logo-text mr-1">SmartAdmin WebApp</span>
                        <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                        <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                    </a>
                </div>
                <!-- DOC: nav menu layout change shortcut -->

                <!-- DOC: mobile button appears during mobile width -->
                <div class="hidden-lg-up">
                    <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                        <i class="ni ni-menu"></i>
                    </a>
                </div>

                <div class="ml-auto d-flex">
                    <!-- activate app search icon (mobile) -->
                    <div class="hidden-sm-up">
                        <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on" data-focus="search-field" title="Search">
                            <i class="fal fa-search"></i>
                        </a>
                    </div>



                    <!-- app user menu -->
                    <div>
                        <a href="#" data-toggle="dropdown" title="<?php echo $_SESSION["kadi"];?>" class="header-icon d-flex align-items-center justify-content-center ml-2">
                            <img src="img/demo/avatars/user.png" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
                            <span><?php echo $_SESSION["kadi"];?></span>
                            <!-- you can also add username next to the avatar with the codes below:
                            <span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
                            <i class="ni ni-chevron-down hidden-xs-down"></i> -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                            <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                                <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">

                                    <div class="info-card-text">
                                        <div class="fs-lg text-truncate text-truncate-lg">Stajyer Değerlendirme</div>

                                    </div>
                                </div>
                            </div>

                            <a href="#" class="dropdown-item" data-action="app-fullscreen">
                                <span data-i18n="drpdwn.fullscreen">Tam Ekran</span>
                                <i class="float-right text-muted fw-n">F11</i>
                            </a>
                            <a href="#" class="dropdown-item" data-action="app-print">
                                <span data-i18n="drpdwn.print">Yazdır</span>
                                <i class="float-right text-muted fw-n">Ctrl + P</i>
                            </a>
                            <div class="dropdown-divider m-0"></div>
                            <a class="dropdown-item fw-500 pt-3 pb-3" href="logOut.php">
                                <span data-i18n="drpdwn.page-logout">Güvenli Çıkış</span>
                                <span class="float-right fw-n"><?php echo $_SESSION["kadi"] ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>