<?php
require_once 'header.php';

include("databaseconnection.php");

?>


<!-- BEGIN Page Content -->
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">

    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item">Anasayfa</li>

        <li class="position-absolute pos-top pos-right d-none d-sm-block" id="tarih"><span id="tarih"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-chart-area"></i> Stajyer Değerlendirme <span
                    class="fw-300">İstatistikler</span>
            <small>
            </small>
        </h1>

    </div>
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <?php $query = $baglan->prepare('SELECT * from ogrenci where silindi_mi=0 ORDER BY student_id DESC');
                        $query->execute();
                        $userList = $query->fetchAll(PDO::FETCH_OBJ); echo count($userList) ?>
                        <small class="m-0 l-h-n">Toplam Stajyer</small>
                    </h3>
                </div>
                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                   style="font-size:6rem"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <?php $query = $baglan->prepare('SELECT * from ogrenci where puan != -1 and silindi_mi = 0 ');
                        $query->execute();
                        $userList = $query->fetchAll(PDO::FETCH_OBJ);
                        echo count($userList) ?>
                        <small class="m-0 l-h-n">Toplam Değerlendirilen Stajyer</small>
                    </h3>
                </div>
                <i class="fal fa-list position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                   style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <?php $query = $baglan->prepare('SELECT * from degerlendirme_kriterleri');
                        $query->execute();
                        $userList = $query->fetchAll(PDO::FETCH_OBJ);
                        echo count($userList) ?>
                        <small class="m-0 l-h-n">Değerlendirme Kriter Sayısı</small>
                    </h3>
                </div>
                <i class="fal fa-check-square position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6"
                   style="font-size: 8rem;"></i>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        <?php $query = $baglan->prepare('SELECT * from admin');
                        $query->execute();
                        $userList = $query->fetchAll(PDO::FETCH_OBJ);
                        echo count($userList) ?>
                        <small class="m-0 l-h-n">Değerlendirebilecek Mühendis</small>
                    </h3>
                </div>
                <i class="fal fa-calculator position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                   style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6"  id="degerlendirilenStajyerChart" style="width: 585px; height: 400px;"></div>
        <div class="col-sm-12 col-xl-6"  id="stajyerBasariChart" style="width: 585px; height: 400px;"></div>

    </div>




    <script type="text/javascript" src="piechart.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Stajyer', 'Dağılım'],
                ['Toplam Stajyer',     <?php $query = $baglan->prepare('SELECT * from ogrenci where silindi_mi=0');
                    $query->execute();
                    $userList = $query->fetchAll(PDO::FETCH_OBJ); echo count($userList) ?>],
                ['Değerlendirilen Stajyer',      <?php $query = $baglan->prepare('SELECT * from ogrenci where puan is not null and silindi_mi = 0');
                    $query->execute();
                    $userList = $query->fetchAll(PDO::FETCH_OBJ);
                    echo count($userList) ?>],

            ]);

            var options = {
                title: 'Toplam Stajyer / Değerlendirilen Stajyer Dağılımı',
                colors: ['#a38cc6', '#ffca5b']
            };

            var chart = new google.visualization.PieChart(document.getElementById('degerlendirilenStajyerChart'));

            chart.draw(data, options);
        }
    </script>

<?php $query = $baglan->prepare('SELECT * from ogrenci where silindi_mi=0');
$query->execute();
$userList = $query->fetchAll(PDO::FETCH_OBJ);

$kriterQuery = $baglan->prepare('SELECT * from degerlendirme_kriterleri');
$kriterQuery->execute();
$kriter = $kriterQuery->fetchAll(PDO::FETCH_OBJ);
$basarili = 0;
$basarisiz = 0;

foreach ($userList as $user)
{
    if($user->puan < (count($kriter)*10)/2 && $user->puan != "")
    {
        $basarisiz++;
    }
    else if ($user->puan >= (count($kriter)*10)/2 && $user->puan != "" )
    {
        $basarili++;
    }
}




?>

<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['', ''],
                ['Başarılı', <?php echo $basarili?>],
                ['Başarısız',<?php echo $basarisiz?>],

            ]);

            var options = {
                title: 'Stajyer Başarı Dağılımı',
                colors: ['#51ffb3', '#93a39e']
            };

            var chart = new google.visualization.PieChart(document.getElementById('stajyerBasariChart'));

            chart.draw(data, options);
        }
    </script>


</main>


<?php

require_once 'footer.php';

?>
