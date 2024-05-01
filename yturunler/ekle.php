<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';

if ($_POST) {
    $urunAdi = $_POST["UrunAdi"];
    $urunAciklama = $_POST["UrunAciklamasi"]; 
    $fiyat = $_POST["Fiyat"];
    $stokAdet = $_POST["StokAdet"];
    $kategoriId = $_POST["KategoriID"];
    
    $dosyaAdi = $_FILES["Gorsel"]["name"];
    $yuklemeYeri = __DIR__ . DIRECTORY_SEPARATOR . "../Gorsel/" . DIRECTORY_SEPARATOR . $dosyaAdi;

    if (move_uploaded_file($_FILES["Gorsel"]["tmp_name"], $yuklemeYeri)) {
        $kaydet = mysqli_query($bag, "INSERT INTO urunlert(UrunAdi, UrunAciklamasi, Fiyat, StokAdet, KategoriID, UrunGorselURL) 
                                       VALUES ('$urunAdi', '$urunAciklama', '$fiyat', '$stokAdet', '$kategoriId', '/Gorsel/$dosyaAdi')");
        if ($kaydet) {
            $msg = "<p class='alert alert-success'>Ürün Eklendi</p>";
        } else {
            $msg = "<p class='alert alert-danger'>Ürün Eklenemedi</p>";
        }
    } else {
        $msg = "<p class='alert alert-danger'>Dosya yüklenemedi.</p>";
    }
       header('refresh: 3');
}




?>
<div class="container-fluid ">

    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
            <h4>Ürün Ekle</h4>
            <hr />
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <?php echo @$msg ?>
                <div class="form-group">
                    <label class="col-md-2 form-label">Ürün Adı</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="UrunAdi" maxlength="500" />
                    </div>
                </div>

                <div class="form-group">
                    <label class=" form-label col-md-2">Ürün Açıklaması</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="UrunAciklamasi" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-10">
                        <label class="form-label col-md-2">Ürün Fiyatı</label>
                        <input type="text" class="form-control" name="Fiyat"  />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-10">
                        <label class="control-label col-md-3">Stok Adeti</label>
                        <input type="text" class="form-control" name="StokAdet" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label col-md-2">Ürün Görseli</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control" name="Gorsel" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label col-md-2">Kategori</label>
                    <div class="col-md-10">
                       <select name="KategoriID" class="form-control">
                        <?php 
                        
                        $kategorilist=mysqli_query($bag,"select KategoriID,KategoriAdi from kategorilert");
                        while($list=mysqli_fetch_array($kategorilist)){
                            echo "<option value='$list[KategoriID]'>$list[KategoriAdi]</option>";
                        }
                        ?>
                       </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10 pt-3">
                        <button type="submit" class="btn btn-success">Ürünü Ekle</button> |
                        <a href="../yturunler" class="btn btn-light">Geri Dön</a>
                    </div>

                </div>
            </form>

        </div>

    </div>
</div>

<?php

include '../resoruces/_PanelLayout.php';
?>