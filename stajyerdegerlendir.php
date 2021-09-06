<?php
session_start();
require_once 'header.php';
include("databaseconnection.php");
include("Logging.php");

$student_id = $_POST['degerlendir'];

$kriterQuery = $baglan->prepare("SELECT degerlendirme_kriterleri.kriterler from degerlendirme_kriterleri LEFT JOIN ogrenci_degerlendirme ON degerlendirme_kriterleri.kriter_id = ogrenci_degerlendirme.kriter_id WHERE student_id ='" . $student_id . "'");
$kriterQuery->execute();
$kriter = $kriterQuery->fetchAll(PDO::FETCH_OBJ);
for ($i = 0; $i < count($kriter); $i++) {
    $kriterAdları[$i] = $kriter[$i]->kriterler;

}
$columns = implode(", ", $kriterAdları);


////$ogrenciKriterQuery = $baglan->prepare("SELECT degerlendirilen_kriterler from ogrenci where student_id = '" . $student_id . "'");
////$ogrenciKriterQuery->execute();
////$degerlendirilmisKriterler = $ogrenciKriterQuery->fetchAll(PDO::FETCH_OBJ);
////$kriterIdler = explode(",", $degerlendirilmisKriterler[0]->degerlendirilen_kriterler);
////
////$kriterAdları = array();
////$i=0 ;
////while($i < count($kriterIdler))
////{
////
////    $kriterAdQuery = $baglan->prepare("SELECT kriterler from degerlendirme_kriterleri where kriter_id ='".$kriterIdler[$i]."'");
////
////    $kriterAdQuery->execute();
////    $sqlKriterAdları = $kriterAdQuery->fetchAll(PDO::FETCH_OBJ);
////
////
////    $i++;
////
////
////}
//
//$columns = implode(", ", $kriterAdları);


//veritabanından kriterler çekilir
$kriterQuery = $baglan->prepare('SELECT * from degerlendirme_kriterleri');
$kriterQuery->execute();
$kriterler = $kriterQuery->fetchAll(PDO::FETCH_OBJ);


?>

<style>
    .select2-container--open {
        z-index: 9999999
    }
</style>

<!-- BEGIN Page Content -->
<!-- the #js-page-content id is needed for some plugins to initialize -->
<main id="js-page-content" role="main" class="page-content">
    <link rel="stylesheet" media="screen, print" href="css/formplugins/select2/select2.bundle.css">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="anaSayfa.php">Ana Sayfa</a></li>
        <li class="breadcrumb-item"><a href="stajyerliste.php">Stajyer Listesi</a></li>
        <li class="breadcrumb-item">Stajyer Değerlendirme</li>
    </ol>

    <div class="col-xl-12">
        <div id="panel-3" class="panel">

            <div class="modal-body">
                <div class="panel-content">

                    <!-- datatable start -->

                    <table id="dt-basic-example"
                           class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline"
                           role="grid"
                           aria-describedby="dt-basic-example_info" style="width: 1162px;">

                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 280px;" aria-label="Position: activate to sort column ascending">
                                Staj Durumu
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 280px;" aria-label="Position: activate to sort column ascending">
                                Ad
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 138px;" aria-label="Office: activate to sort column ascending">
                                Soyad
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 138px;" aria-label="Office: activate to sort column ascending">
                                Okul
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 69px;" aria-label="Age: activate to sort column ascending">Başlama
                                Tarihi
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 125px;"
                                aria-label="Start date: activate to sort column ascending">Bitirme Tarihi
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 106px;" aria-label="Salary: activate to sort column ascending">
                                E-posta
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 106px;" aria-label="Salary: activate to sort column ascending">
                                Telefon
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 106px;" aria-label="Salary: activate to sort column ascending">
                                Proje Adı
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 106px;" aria-label="Salary: activate to sort column ascending">
                                Puan
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 106px;" aria-label="Salary: activate to sort column ascending">
                                Değerlendirilen Kriterler

                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 106px;" aria-label="Salary: activate to sort column ascending">
                                Yorum

                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dt-basic-example" rowspan="1"
                                colspan="1"
                                style="width: 106px;" aria-label="Salary: activate to sort column ascending">
                                Değerlendiren

                            </th>


                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        //stajyerin bilgileri student_id ile çekilerek datatable' yazdırılır
                        $sql_check = $baglan->prepare("SELECT * from ogrenci where student_id = '" . $student_id . "'");
                        $sql_check->execute();
                        $student = $sql_check->fetchAll(PDO::FETCH_OBJ);

                        foreach ($student

                        as $key => $user) { ?>
                        <tr>

                            <td><?php if ($user->durum == 1) {
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
                                ?></td>
                            <td><?php echo ucfirst($user->ad) ?></td>
                            <td><?php echo ucfirst($user->soyad) ?></td>
                            <td><?php echo ucfirst($user->okul) ?></td>
                            <td><?php echo date('d/m/Y', strtotime($user->baslama_tarihi)); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($user->bitirme_tarihi)); ?></td>
                            <td><?= $user->mail ?></td>
                            <td><?= $user->tel ?></td>
                            <td><?php echo ucfirst($user->yaptigi_proje) ?></td>
                            <td><?= $user->puan
                                ?> / <?php echo count($kriterler) * 10 ?> </td>

                            <td><?= $columns
                                ?></td>
                            <td>
                                <?php echo ucfirst($user->yorum) ?>
                            </td>
                            <td>
                                <?= $user->degerlendiren ?>
                            </td>


                        </tr>


                </div>
            </div>


            <?php } ?>
            </tbody>

            </table>
            <!-- datatable end -->

        </div>

        <label class="form-label" for="example-textarea">Stajyer Değerlendirme Kriterleri</label>
        <div class="form-group">
            <!-- stajyer değerlendirme kriterleri select2 ile yazdırılmaktadır.
             -->
            <form id="degerlendirFrm" method="POST">
                <select class="js-example-basic-multiple" id="kriterler" name="kriterler[]" multiple>
                    <optgroup>
                        <?php

                        //kriterler o stajyer için değerlendirmede kullanılıp kullanılmadığına göre selected olarak select2 ya yazdırılır
                        foreach ($kriterler as $kriter) {

                            //var_dump($sonuc["student_id"]);
                            $sql_check = $baglan->prepare("SELECT * from ogrenci_degerlendirme where student_id = '" . $student_id . "' and kriter_id = '" . $kriter->kriter_id . "'");
                            $sql_check->execute();
                            $sonuclar = $sql_check->fetch(PDO::FETCH_ASSOC);

                            if (count($sonuclar) != 1) {    // Eğer öğrencinin daha önceden değerlendirilmiş kriterleri varsa bunlar selected olarak sayfa yüklenince gelmektedir.
                                ?>
                                <option value="<?php echo $kriter->kriter_id; ?>"
                                        selected=""><?php echo $kriter->kriterler ?></option>
                                <?php
                            } else {// öğrencinin değerlendirilmemiş kriterleri burada yazdırılır.
                                ?>
                                <option value="<?php echo $kriter->kriter_id; ?>"><?php echo $kriter->kriterler ?></option>
                                <?php
                            }


                        }

                        ?>
                    </optgroup>

                </select>


                <div class="form-group">
                    <!-- stajyeri değerlendiren mühendis burada yorumlarını belirtebilmektedir. -->
                    <label class="form-label" for="example-textarea">Mühendis Yorumu</label>
                    <textarea class="form-control" id="yorum" rows="5"
                              maxlength="500"><?php echo $student[0]->yorum ?></textarea>
                </div>


                <button type="submit" class="btn btn-success waves-effect waves-themed" id="degerlendirBtn"
                        name="student_id"
                        value="<?php echo $student_id ?>">Değerlendir
                </button>
                <button type="button" class="btn btn-info waves-effect waves-themed" name="student_id"
                        data-toggle="modal"
                        data-target="#default-example-modal-center-ekle">
                    Kriter Ekle
                </button>
                <button type="button" class="btn btn-danger waves-effect waves-themed" name="student_id"
                        data-toggle="modal"
                        data-target="#default-example-modal-center-sil">
                    Kriter Sil
                </button>
            </form>
        </div>

    </div>


    <!-- Kriter ekle Modal Begin  -->
    <div class="modal fade" id="default-example-modal-center-ekle" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Kriter Ekle

                    </h4>
                </div>


                <div class="modal-body">

                    <label class="form-label" for="simpleinput">Kriter Adı</label>
                    <!-- Eklenen kriter kriter id'li label ile javascript fonksiyonuna gönderilir -->
                    <input type="text" name="kriter" id="kriter" class="form-control">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-themed" data-dismiss="modal">
                        Kapat
                    </button>
                    <form id="kriterEkle" method="POST">
                        <button type="submit" class="btn btn-success waves-effect waves-themed" id="kriterDegerlendir"
                                name="student_id" value=""
                        ">Kriter Ekle</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal end -->

    <!-- Kriter sil Modal Begin  -->
    <div class="modal fade" id="default-example-modal-center-sil" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Kriter Sil

                    </h4>
                </div>


                <div class="modal-body">

                    <label class="form-label" for="single-default">
                        Silinecek Kriter Seçiniz!
                    </label>

                    <select class="js-example-basic-single" id="kriterSil" tabindex="2">
                        <optgroup>

                            <?php

                            //kriterler o stajyer için değerlendirmede kullanılıp kullanılmadığına göre selected olarak select2 ya yazdırılır
                            foreach ($kriterler as $kriter) {

                                //var_dump($sonuc["student_id"]);


                                ?>
                                <option value="<?php echo $kriter->kriter_id; ?>"><?php echo $kriter->kriterler ?></option>
                                <?php


                            }
                            ?>


                        </optgroup>

                    </select>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-themed" data-dismiss="modal">
                        Kapat

                    </button>
                    <form id="kriterSilFrm" method="POST">
                        <button type="submit" class="btn btn-success waves-effect waves-themed" id="kriterSilBtn"
                                name="student_id" value=""
                        ">Kriter Sil</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal end -->

</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>


<script src="js/jquery.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

    $(document).ready(function () {

        $(".js-example-basic-multiple").select2({
            placeholder: "Kriterler",
            allowClear: true
        });
    });
</script>
<script>

    $(document).ready(function () {

        $(".js-example-basic-single").select2({
            placeholder: "Kriterler",
            allowClear: true,
            minimumResultsForSearch: -1
        });
    });
</script>

<script>
    //stajyer degerlendirme fonksiyonu ile. seçilen veriler stajyerdegerlendirdb.php dosyasına gönderililr.
    $(document).ready(function () {

        $("form#degerlendirFrm").submit(function (event) {
            event.preventDefault();
            var student_id = $("#degerlendirBtn").val();
            var kriterler = $("#kriterler").val();
            var yorum = $("#yorum").val();

            $.ajax({

                url: 'stajyerdegerlendirdb.php',
                type: 'POST',
                data: {
                    student_id: student_id,
                    kriterler: kriterler,
                    yorum: yorum,
                },
                success: function (data) {
                    swal({
                        text: "Başarılı! Stajyer Değerlendirildi!",
                        icon: 'success',
                        button: false
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000);


                }

            });
        });
    });

    //kriter ekleme fonksiyonu ile veritabanına kriter eklenir.
    $(document).ready(function () {

        $("form#kriterEkle").submit(function (event) {
            event.preventDefault();
            var kriter = $("#kriter").val();


            $.ajax({

                type: 'POST',
                data: {
                    kriter: kriter,
                },
                success: function (repsonse) {


                    swal({
                        text: "Başarılı! Kriter Eklendi!",
                        icon: 'success',
                        button: false
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
            });
        });
    });


    $(document).ready(function () {

        $("form#kriterSilFrm").submit(function (event) {
            event.preventDefault();
            var kriterSil = $("#kriterSil option:selected").val();

            $.ajax({
                url: 'kriterSil.php',
                type: 'POST',
                data: {
                    kriterSil: kriterSil,
                },
                success: function (repsonse) {


                    swal({
                        text: "Başarılı! Kriter Silindi!",
                        icon: 'success',
                        button: false
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
            });


        });
    });


</script>
<script src="js/jquery.js"></script>
<script src="sweetalert.min.js"></script>

<?php
require_once 'footer.php';

header('Content-type: application/json');

//kriter eklemek için veritabanı sorgusu
$eklenenKriter = $_POST["kriter"];
$query = $baglan->prepare("INSERT INTO degerlendirme_kriterleri(kriterler) values(?)");
$query->bindParam(1, $eklenenKriter, PDO::PARAM_STR);
$query->execute();
LogKaydet($_SESSION["kadi"], 'kriter_ekle');


$basari = ""; //kriterlere göre öğrenci başarısını atıyoruz
$kriterQuery = $baglan->prepare('SELECT * from degerlendirme_kriterleri');
$kriterQuery->execute();
$kriter = $kriterQuery->fetchAll(PDO::FETCH_OBJ);

$basariQuery = $baglan->prepare("SELECT student_id,puan FROM ogrenci");
$basariQuery->execute();
$stajyerDurum = $basariQuery->fetchAll(PDO::FETCH_OBJ);


foreach ($stajyerDurum as $durum) {

    if ((int)$durum->puan >= (count($kriter) * 10) / 2) {
        $basari = 'başarılı';
    } else if ((int)$durum->puan < (count($kriter) * 10) / 2) {
        $basari = 'başarısız';
    }

    $ogrenciBasariQuery = $baglan->prepare("UPDATE ogrenci SET  durum ='" . $basari . "' WHERE student_id = $durum->student_id");
    $ogrenciBasariQuery->execute();
}


?>
