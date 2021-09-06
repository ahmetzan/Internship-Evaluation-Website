<?php
require_once 'header.php';
include ('stajyerlistedb.php');
$key = $_POST["guncelle"];
?>
<main id="js-page-content" role="main" class="page-content">
    <link rel="stylesheet" media="screen, print" href="register.css">

    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="anaSayfa.php">Ana Sayfa</a></li>
        <li class="breadcrumb-item"><a href="stajyerliste.php">Stajyer Liste</a></li>
        <li class="breadcrumb-item active">Stajyer Güncelle</li>

    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-edit'></i> Stajyer Güncelle

        </h1>
    </div>
    <div class="row">
        <div class="container">
            <div class="title">Stajyer Güncelle</div>
            <div class="content">
                <form id="guncelle" >
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Ad</span>
                            <input type="text" id="ad" placeholder="Adınızı Giriniz" value="<?php echo $userList[$key]->ad ?>" maxlength="255" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Soyad</span>
                            <input type="text" id="soyad" placeholder="Soyadınızı Giriniz" value="<?php echo $userList[$key]->soyad ?>" maxlength="255" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Okul</span>
                            <input type="text" id="okul" placeholder="Okulunuzu Giriniz" value="<?php echo $userList[$key]->okul ?>" maxlength="255" required>
                        </div>
                        <div class="input-box">
                            <span class="details">E-posta</span>
                            <input type="text" id="mail"  data-inputmask="'alias': 'email'" class="form-control" im-insert="true" value="<?php echo $userList[$key]->mail ?>" maxlength="255" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Başlama Tarihi</span>
                            <input type="date"  id="baslama_tarihi"
                                   name="date" value="<?php echo $userList[$key]->baslama_tarihi ?>" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Bitirme Tarihi</span>
                            <input type="date" id="bitirme_tarihi" value="<?php echo $userList[$key]->bitirme_tarihi ?>" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Telefon Numarası</span>
                            <input type="text" id="tel" placeholder="(555) 555-5555" data-inputmask="'mask': '(999) 999-9999'" value="<?php echo $userList[$key]->tel ?>" maxlength="15" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Proje Adı</span>
                            <input type="text" id="yaptigi_proje" placeholder="Proje Adını Giriniz" value="<?php echo $userList[$key]->yaptigi_proje ?>" maxlength="255" required>
                        </div>

                    </div>

                    <div class="button">
                        <input type="submit" id="stid" name="Güncelle" value="Güncelle">
                    </div>
                </form>
            </div>
        </div>

    </div>

</main>
<?php
require_once 'footer.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>

<script src="js/formplugins/inputmask/inputmask.bundle.js"></script>
<script>
    //stajyer bilgilerini stajyerguncelle.php dosyasına yollayıp güncelleme işlemi yapılır.
    $(document).ready(function(){
        $(":input").inputmask();
        $("form#guncelle").submit(function(event) {
            event.preventDefault();
            var ad = $("#ad").val();
            var soyad = $("#soyad").val();
            var okul = $("#okul").val();
            var baslama_tarihi = $("#baslama_tarihi").val();
            var bitirme_tarihi = $("#bitirme_tarihi").val();
            var mail = $("#mail").val();
            var tel = $("#tel").val();
            var yaptigi_proje = $("#yaptigi_proje").val();
            var stid = <?php echo $userList[$key]->student_id ?>;

            $.ajax({

                url: 'stajyerguncelledb.php',
                type: 'POST',
                data: {name: ad,
                    lastname: soyad,
                    school: okul,
                    begindate: baslama_tarihi,
                    enddate: bitirme_tarihi,
                    mail: mail,
                    phonenumber: tel,
                    project: yaptigi_proje,
                    stid: stid},
                success: function (response) {
                    if(response.includes("ok")) {
                        swal({
                            text: "Başarılı! Stajyer Güncellendi!",
                            icon: 'success',
                            button: false,

                        });
                        setTimeout(function () {
                            window.location = 'stajyerliste.php';
                        }, 1000);
                    }

                    else if(response.includes("tarih"))
                    {
                        swal({
                            text: "Başarısız! Bitiş Tarihi Başlangıçtan Önce Olamaz!",
                            icon: 'error',
                            button: false,
                            timer: 1000

                        });

                    }else if(response.includes("aynı"))
                    {
                        swal({
                            text: "Başarısız! Bitiş Tarihi Başlangıçla Aynı Olamaz!",
                            icon: 'error',
                            button: false,
                            timer: 1000

                        });

                    }
                    else if(response.includes("telefon"))
                    {
                        swal({
                            text: "Başarısız! Bu Numara Kullanılmış!",
                            icon: 'error',
                            button: false,
                            timer: 1000

                        });

                    }

                    else if(response.includes("mail"))
                    {
                        swal({
                            text: "Başarısız! Bu Mail Kullanılmış!",
                            icon: 'error',
                            button: false,
                            timer: 1000

                        });

                    }
                }

            });
        });
    });





</script>
<script src="js/jquery.js"></script>
<script src="sweetalert.min.js"></script>


