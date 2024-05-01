<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
?>
<div class="container-fluid">
    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
            <h4>Kategori Ekle</h4>
            <hr />
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label class="col-md-2 form-label">Kategori Adı</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="Baslik" required maxlength="500"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class=" form-label col-md-2">Kategori Açıklaması</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="KategoriAciklamasi" required maxlength="1000"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10 pt-3">
                        <button type="submit" class="btn btn-success">Kategoriyi Ekle</button> |
                        <a href="../ytkategori" class="btn btn-light">Geri Dön</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "../db_config/database.php";
if($_POST){
    $katadi=$_POST["Baslik"];
    $kataciklama=$_POST["KategoriAciklamasi"];
    $kaydet=mysqli_query($bag,"insert into kategorilert(KategoriAdi,KategoriAciklamasi) values('$katadi','$kataciklama')");
    if($kaydet){
        echo "<div class='container-fluid col-md-2 text-center'><p class='alert alert-success'>Kategori Eklendi</p></div>";
    }
    else{
        echo "<div class='container-fluid col-md-2 text-center'><p class='alert alert-danger'>Kategori Eklenmedi</p></div>";
    }
}

include '../resoruces/_PanelLayout.php';

?>