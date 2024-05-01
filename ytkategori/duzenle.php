

<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include "../db_config/database.php";

$id = $_GET["id"]; //id değerini çağırma

//value değerleri 

$iceriksorgu=mysqli_query($bag,"select*from kategorilert where KategoriID=$id");
while($icerik=mysqli_fetch_assoc($iceriksorgu)){
    $KategoriID = $icerik['KategoriID']; 
    $KategoriAdi = $icerik['KategoriAdi']; 
    $KategoriAciklamasi = $icerik['KategoriAciklamasi']; 
}

//güncelleme işlemi

if($_POST){
    $katadi=$_POST["KategoriAdi"];
    $kataciklama=$_POST["KategoriAciklamasi"];
    
    $guncelle=mysqli_query($bag,"update kategorilert set KategoriAdi='$katadi', KategoriAciklamasi='$kataciklama' where KategoriID=$id ");
    if($guncelle){
        $msg= "<p class='alert alert-success'>Kategori Güncellendi</p>";
        header('refresh: 1');
    }
    else{
        echo "<div class='container-fluid col-md-2 text-center'><p class='alert alert-danger'>Kategori Güncellenmedi</p></div>";
        header('refresh: 1');
    }
}

?>

<div class="container-fluid ">

    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
            <h4> Kategorisini Düzenle</h4>
            <hr />
            <form action="<?php  $_SERVER['PHP_SELF']; ?>" method="post">
            <?php echo @$msg ?>
                <div class="form-group">
                    <label class="col-md-2 form-label">Ürün Adı</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="KategoriAdi" value="<?php echo $KategoriAdi; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class=" form-label col-md-2">Ürün Açıklaması</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="KategoriAciklamasi" value="<?php echo $KategoriAciklamasi; ?>" />
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10 pt-3">
                        <button type="submit" class="btn btn-success">Kaydet</button> |
                        <a href="../ytkategori" class="btn btn-light">Geri Dön</a>
                    </div>

                </div>
            </form>

        </div>

    </div>
</div>

<?php 



include '../resoruces/_PanelLayout.php';
?>