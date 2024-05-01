
<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}

include "../db_config/database.php";
$id = $_GET["id"]; //id değerini çağırma

//value değerleri 

$iceriksorgu=mysqli_query($bag,"select UrunID,UrunAdi,UrunAciklamasi,Fiyat,StokAdet,u.KategoriID,UrunGorselURL, k.KategoriAdi
 from urunlert u inner join kategorilert k on u.KategoriID=k.KategoriID where UrunID=$id");
while($icerik=mysqli_fetch_assoc($iceriksorgu)){
    $UrunID = $icerik['UrunID']; 
    $UrunAdi = $icerik['UrunAdi']; 
    $UrunAciklamasi = $icerik['UrunAciklamasi']; 
    $Fiyat = $icerik['Fiyat']; 
    $StokAdet = $icerik['StokAdet']; 
    $KategoriID = $icerik['KategoriID']; 
    $KategoriID = $icerik['KategoriID']; 
    $KategoriAdi = $icerik['KategoriAdi']; 
}

if($_POST){
    if($_FILES['Gorsel']['size'] > 0){
        $urunAdi = $_POST["UrunAdi"];
        $urunAciklamasi = $_POST["UrunAciklamasi"];
        $fiyat = $_POST["Fiyat"];
        $stokAdet = $_POST["StokAdet"];
        $kategoriID = $_POST["KategoriID"];
        
        $dosyaAdi = uniqid() . '_' . time() . '.' . pathinfo($_FILES["Gorsel"]["name"], PATHINFO_EXTENSION);
        $yuklemeYeri = __DIR__ . DIRECTORY_SEPARATOR . "../Gorsel" . DIRECTORY_SEPARATOR . $dosyaAdi;
    
        // Dosya yükleme işlemi
        if (move_uploaded_file($_FILES["Gorsel"]["tmp_name"], $yuklemeYeri)) {
            $guncelle = mysqli_query($bag, "UPDATE urunlert 
                                            SET UrunAdi='$urunAdi', UrunAciklamasi='$urunAciklamasi', 
                                                Fiyat='$fiyat', StokAdet='$stokAdet', KategoriID='$kategoriID', 
                                                UrunGorselURL='/Gorsel/$dosyaAdi' 
                                            WHERE UrunID=$id");
            if ($guncelle) {
                $msg = "<p class='alert alert-success'>Ürün Güncellendi</p>";
            } else {
                $msg = "<p class='alert alert-danger'>Ürün Güncellenmedi</p>";
            }
        } else {
            $msg = "<p class='alert alert-danger'>Dosya yüklenemedi.</p>";
        }
    
        header('refresh: 2');
    } else {
        $urunAdi = $_POST["UrunAdi"];
        $urunAciklamasi = $_POST["UrunAciklamasi"];
        $fiyat = $_POST["Fiyat"];
        $stokAdet = $_POST["StokAdet"];
        $kategoriID = $_POST["KategoriID"];
        
        $guncelle = mysqli_query($bag, "UPDATE urunlert 
                                        SET UrunAdi='$urunAdi', UrunAciklamasi='$urunAciklamasi', 
                                            Fiyat='$fiyat', StokAdet='$stokAdet', KategoriID='$kategoriID' 
                                        WHERE UrunID=$id");
        if ($guncelle) {
            $msg = "<p class='alert alert-success'>Ürün Güncellendi</p>";
        } else {
            $msg = "<p class='alert alert-danger'>Ürün Güncellenmedi</p>";
        }
    
        header('refresh: 1');
    }
    
}

?>
<div class="container-fluid ">

    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
            <h4>Ürün Düzenle</h4>
            <hr />
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <?php echo @$msg ?>
                <div class="form-group">
                    <label class="col-md-2 form-label">Ürün Adı</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="UrunAdi" value="<?php echo $UrunAdi ?>" maxlength="500" />
                    </div>
                </div>

                <div class="form-group">
                    <label class=" form-label col-md-2">Ürün Açıklaması</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="UrunAciklamasi" value="<?php echo $UrunAciklamasi ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-10">
                        <label class="form-label col-md-2">Ürün Fiyatı</label>
                        <input type="text" class="form-control" name="Fiyat" value="<?php echo $Fiyat ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-10">
                        <label class="control-label col-md-3">Stok Adeti</label>
                        <input type="text" class="form-control" name="StokAdet" value="<?php echo $StokAdet ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label col-md-2">Ürün Görseli</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control" name="Gorsel"  />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label col-md-2">Kategori</label>
                    <div class="col-md-10">
                       <select name="KategoriID" class="form-control" >
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