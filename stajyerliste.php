<?php
session_start();
require_once 'header.php';
include("databaseconnection.php");
include("stajyerlistedb.php");
$toplamDegerlendirilen = 0;


$kriterQuery = $baglan->prepare('SELECT * from degerlendirme_kriterleri');//toplam puanı gösterebilmek için sql sorgusu
$kriterQuery->execute();
$kriter = $kriterQuery->fetchAll(PDO::FETCH_OBJ);


$basari = "";
$kriterQuery = $baglan->prepare('SELECT * from degerlendirme_kriterleri');
$kriterQuery->execute();
$kriter = $kriterQuery->fetchAll(PDO::FETCH_OBJ);

$basariQuery = $baglan->prepare("SELECT student_id,puan FROM ogrenci");
$basariQuery->execute();
$stajyerDurum = $basariQuery->fetchAll(PDO::FETCH_OBJ);

//var_dump((int)$stajyerDurum[0]->puan);
//var_dump(count($kriter) * 10); exit();


foreach ($stajyerDurum as $durum) {

    if ((int)$durum->puan >= (count($kriter) * 10) / 2 && $durum->puan != null) {
        $basari = 1;
    }else if ((int)$durum->puan < (count($kriter) * 10) / 2 && $durum->puan != null ) {
        $basari = 2;
    }
    else
    {
        $basari= 0;
    }

    $ogrenciBasariQuery = $baglan->prepare("UPDATE ogrenci SET  durum ='" . $basari . "' WHERE student_id = $durum->student_id");
    $ogrenciBasariQuery->execute();
}

?>

<style>
    .select2-container--open {
        z-index: 9999999
    }
</style>

<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="anaSayfa.php">Anasayfa</a></li>
        <li class="breadcrumb-item">Stajyer Listesi</a></li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block" id="tarih"><span id="tarih"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-edit'></i> Stajyer Listesi
        </h1>

    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">

                <div class="panel-container show">

                    <div class="panel-content">

                        <!-- datatable start -->
                        <div id="dt-basic-example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row mb-3">

                                <div class="col-sm-12 col-md-6 d-flex align-items-center justify-content-end">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="dt-basic-example"
                                           class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline"
                                           role="grid" aria-describedby="dt-basic-example_info" style="width: 1160px;">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 250px;"
                                                aria-label="Name: activate to sort column descending"
                                                aria-sort="ascending">Staj Durumu
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 240px;"
                                                aria-label="Position: activate to sort column ascending">
                                                Ad
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 138px;"
                                                aria-label="Office: activate to sort column ascending">
                                                Soyad
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 100px;"
                                                aria-label="Office: activate to sort column ascending">
                                                Okul
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 69px;"
                                                aria-label="Age: activate to sort column ascending">Başlama
                                                Tarihi
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 125px;"
                                                aria-label="Start date: activate to sort column ascending">Bitirme
                                                Tarihi
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 106px;"
                                                aria-label="Salary: activate to sort column ascending">
                                                E-posta
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 106px;"
                                                aria-label="Salary: activate to sort column ascending">
                                                Telefon
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 106px;"
                                                aria-label="Salary: activate to sort column ascending">
                                                Proje Adı
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 106px;"
                                                aria-label="Salary: activate to sort column ascending">
                                                Puan
                                            </th>

                                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example"
                                                rowspan="1"
                                                colspan="1"
                                                style="width: 106px;"
                                                aria-label="Salary: activate to sort column ascending">
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Stajyer bilglerini userList isimli listeye atıp foreach ile tabloya yazdırma -->
                                        <?php foreach ($userList

                                        as $key => $user) { ?>

                                        <tr>
                                            <td><?php


                                                if ($user->durum == 1) {
                                                    echo "Başarılı"; ?>
                                                    <img src="ok_icon.png"/>


                                                    <?php
                                                } else if ($user->durum == 2) {
                                                    echo "Başarısız"; ?>
                                                    <img src="cross_icon.png"/>
                                                    <?php
                                                } else if ($user->durum == 0) {
                                                    ?>Degerlendir<img src="bos_icon.png"/>
                                                <?php }

                                                ?>
                                            </td>
                                            <td><?php echo ucfirst($user->ad) ?></td>
                                            <td><?php echo ucfirst($user->soyad) ?></td>
                                            <td><?php echo ucfirst($user->okul) ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($user->baslama_tarihi)); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($user->bitirme_tarihi)); ?></td>
                                            <td><?php echo $user->mail ?></td>
                                            <td><?php echo $user->tel ?></td>
                                            <td><?php echo ucfirst($user->yaptigi_proje) ?></td>
                                            <td><?php echo $toplamnot = $user->puan;
                                                if ($toplamnot >= 0) {
                                                    ++$toplamDegerlendirilen;
                                                }
                                                ?>  <?php if ($user->puan != null) {
                                                    ?>/ <?php echo count($kriter) * 10;
                                                } ?>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    <button type="button"
                                                            class="btn btn-success dropdown-toggle waves-effect waves-themed"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        İşlemler
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start"
                                                         style="position: absolute; will-change: top, left; top: 35px; left: 0px;">
                                                        <!-- Stajyer silme işlemini yapan buton -->
                                                        <form method="POST">
                                                            <button type="button" onclick="VeriSil(this)"
                                                                    class="dropdown-item deleted" name="sil"
                                                                    data-id="<?php echo $user->student_id ?>">sil
                                                            </button>
                                                        </form>
                                                        <!-- Stajyer bilglerini güncelleme sayfasına yönlendiren buton -->
                                                        <form action="stajyerguncelle.php" method="POST">
                                                            <button type="submit" class="dropdown-item"
                                                                    name="guncelle" value="<?php echo $key ?>"

                                                            >Güncelle
                                                            </button>
                                                        </form>

                                                        <!-- Stajyer değerlendirme sayfasına yönlendiren buton -->
                                                        <form action="stajyerdegerlendir.php" method="POST">
                                                            <button type="submit" name="degerlendir"
                                                                    class="dropdown-item"
                                                                    value="<?php echo $user->student_id ?>"
                                                            >Değerlendir
                                                            </button>

                                                        </form>
                                            </td>

                                        </tr>


                                </div>
                            </div>


                            <?php } ?>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">Staj Durumu</th>
                                <th rowspan="1" colspan="1">Ad</th>
                                <th rowspan="1" colspan="1">Soyad</th>
                                <th rowspan="1" colspan="1">Okul</th>
                                <th rowspan="1" colspan="1">Baslama Tarihi</th>
                                <th rowspan="1" colspan="1">Bitirme Tarihi</th>
                                <th rowspan="1" colspan="1">E-posta</th>
                                <th rowspan="1" colspan="1">Telefon</th>
                                <th rowspan="1" colspan="1">Proje Adı</th>
                                <th rowspan="1" colspan="1">Puan</th>

                                <th rowspan="1" colspan="1"></th>


                            </tr>
                            </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- datatable end -->


            </div>
        </div>
    </div>

    <div class="text-center">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>


        <script>

            //stajyer silme fonksiyonu
            function VeriSil(elem) {
                var studentId = $(elem).data("id");

                $.ajax({
                    url: 'stajyersil.php',
                    type: 'POST',
                    data: {sil: studentId},
                    success: function (response) {
                        if (response.includes("ok")) {
                            swal({
                                text: "Başarılı! Stajyer Silindi!",
                                icon: 'success',
                                button: false
                            });

                            setTimeout(function () {
                                window.location = 'stajyerliste.php';
                            }, 1000);

                        }
                    }
                });
            }
        </script>


        <script src="myscripts.js"></script>
        <script src="sweetalert.min.js"></script>
        <script src="bg.js"></script>
        <script src="moment.js"></script>
</main>


<?php
/*session_start();
ob_start();
include("databaseconnection.php");
$id =$_GET['guncelle'];
sql_check = $baglan->query("select * from ogrenci where studentID= 'guncelle'");
$sonuc= $sql_check->fetch(PDO::FETCH_ASSOC);
ob_end_flush();
*/
?>


<?php require_once('footer.php'); ?>


<script>
    //select2 fonksiyonu
    $(document).ready(function () {

        $(".js-example-basic-multiple").select2({
            placeholder: "Kriterler",
            allowClear: true
        });
    });
</script>

