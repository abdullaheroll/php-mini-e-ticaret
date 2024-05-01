<?php
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';
$id = $_GET["id"]; //id değerini çağırma
$SipSahip=mysqli_query($bag,"select SiparisID,Durum,Isim from siparislert s inner join kullanicilart k on s.KullaniciID=k.KullaniciID where SiparisID=$id");
while($listSahip=mysqli_fetch_assoc($SipSahip)){
    $kisi=$listSahip["Isim"];
    $sipDurum=$listSahip["Durum"];
}


//Sipariş Durumu Belirleme
if($_POST){
    $gelenSipDurum=$_POST["Durum"];
    $kaydet=mysqli_query($bag,"update siparislert set Durum=$gelenSipDurum where SiparisID=$id");
    if($kaydet){
        $msg = "<p class='alert alert-success'>Sipariş Durumu Güncellendi</p>";
    }
    else{
        $msg = "<p class='alert alert-danger'>Sipariş Durumu Güncellenemedi</p>";
    }
    header('refresh: 2');
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
            
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <label class="col-md-2 form-label">Sipariş Durumu:</label>
                    <?php 
                    if ($sipDurum == "1")
                    {
                      echo "<p class='h6 text-info'>Sipariş Alındı</p>";
                      echo "<hr style='width:500px' />";
                    }

                    else if ($sipDurum == "2")
                    {
                        echo " <p class='h6 text-primary'>Sipariş Hazırlanıyor</p>";
                        echo "<hr style='width:500px' />";
                    }
                    else if ($sipDurum == "3")
                    {
                        echo " <p class='h6 text-warning'>Kargoya Verildi</p>";
                        echo "<hr style='width:500px' />";
                    }
                    else if ($sipDurum == "4")
                    {
                        echo " <p class='h6 text-success'>Teslim Edildi</p>";
                        echo " <hr style='width:500px' />";
                    }
                    else
                    {
                        echo "<p class='h6 text-danger'>İptal Edildi</p>";
                        echo "<hr style='width:500px' />";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label class="col-md-2 form-label">Sipariş Durumu Seç:</label>
                    <div class="col-md-4">

                        <select name="Durum" class="form-control">
                            <option value="1">
                                Sipariş Alındı
                            </option>
                            <option value="2">
                                Sipariş Hazırlanıyor
                            </option>
                            <option value="3">
                                Kargoya Verildi
                            </option>
                            <option value="4">
                                Teslim Edildi
                            </option>
                            <option value="5">
                                İptal Edildi
                            </option>
                        </select>
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