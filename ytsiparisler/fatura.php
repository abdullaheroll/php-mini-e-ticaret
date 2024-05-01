<?php
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';
$id = $_GET["id"]; //id değerini çağırma
$SipSahip=mysqli_query($bag,"select SiparisID,Durum,Isim from siparislert s inner join kullanicilart k on s.KullaniciID=k.KullaniciID where SiparisID='$id'");
while($listSahip=mysqli_fetch_assoc($SipSahip)){
    $kisi=$listSahip["Isim"];
    $sipDurum=$listSahip["Durum"];
}


//Kişiye ait fatura yükleme
if($_FILES){
    $dosyaAdi = uniqid() . '_' . time() . '.' . pathinfo($_FILES["Fatura"]["name"], PATHINFO_EXTENSION);
    $yuklemeYeri = __DIR__ . DIRECTORY_SEPARATOR . "../Fatura/" . DIRECTORY_SEPARATOR . $dosyaAdi;
    if (move_uploaded_file($_FILES["Fatura"]["tmp_name"], $yuklemeYeri)) {
        $kaydet = mysqli_query($bag,"update siparislert set FaturaURL='/Fatura/$dosyaAdi' where SiparisID='$id'");
        if ($kaydet) {
            $msg = "<p class='alert alert-success'>Siparişe fatura tanımlanmıştır.</p>";
        } else {
            $msg = "<p class='alert alert-danger'>Fatura Oluşturulamadı</p>";
        }
    }else {
        $msg = "<p class='alert alert-danger'>Dosya yüklenemedi.</p>";
    }
 header("refresh: 2");


}





?>

<div class="container-fluid ">

    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
        <h4><?php echo $kisi; ?> Kişisine Ait Sipariş</h4>
            <hr />
           <?php echo @$msg; ?>

           <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-md-12 form-label h6">Fatura Yükle:</label>
                    <div class="col-md-12">
                        <input type="file" name="Fatura" class="form-control" accept=".pdf,.jpg,.jpeg,.png" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10 pt-3">
                        <button type="submit" class="btn btn-success">Kaydet</button> |
                        <a href="../ytsiparisler" class="btn btn-light">Geri Dön</a>
                    </div>

                </div>
            </form>

        </div>

    </div>
</div>

<?php 
require '../resoruces/_PanelLayout.php';
?>