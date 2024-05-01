
<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include "../db_config/database.php";
$id = $_GET["id"]; //id değerini çağırma

//value değerleri 

$iceriksorgu=mysqli_query($bag,"select*from hakkimizdat where HakkimizdaID=$id");
while($icerik=mysqli_fetch_assoc($iceriksorgu)){
    $Baslik=$icerik["Baslik"];
    $Icerik=$icerik["Icerik"];
    
}


if($_POST){
    if($_FILES['Gorsel']['size'] > 0){
        $Baslik = $_POST["Baslik"];
        $Icerik = $_POST["Icerik"];
        
        // Eski resmin yolunu al
        $query = "SELECT GorselURL FROM hakkimizdat WHERE HakkimizdaID = $id";
        $result = mysqli_query($bag, $query);
        $row = mysqli_fetch_assoc($result);
        $eskiGorsel = $row['GorselURL'];
        
        $dosyaAdi = uniqid() . '_' . time() . '.' . pathinfo($_FILES["Gorsel"]["name"], PATHINFO_EXTENSION);
        $yuklemeYeri = __DIR__ . DIRECTORY_SEPARATOR . "../Gorsel" . DIRECTORY_SEPARATOR . $dosyaAdi;
    
        // Dosya yükleme işlemi
        if (move_uploaded_file($_FILES["Gorsel"]["tmp_name"], $yuklemeYeri)) {
            // Eski resmi sil
            if (!empty($eskiGorsel) && file_exists($eskiGorsel)) {
                unlink($eskiGorsel);
            }
            
            // Yeni resmi güncelle
            $guncelle = mysqli_query($bag, "UPDATE hakkimizdat 
                                            SET Baslik='$Baslik', Icerik='$Icerik', GorselURL='/Gorsel/$dosyaAdi' 
                                            WHERE HakkimizdaID=$id");
            if ($guncelle) {
                $msg = "<p class='alert alert-success'>Hakkımızda Alanı Güncellendi</p>";
            } else {
                $msg = "<p class='alert alert-danger'>Hakkımızda Alanı Güncellenmedi</p>";
            }
        } else {
            $msg = "<p class='alert alert-danger'>Dosya yüklenemedi.</p>";
        }
    
        header('refresh: 2');
    } else {
        $Baslik=$_POST["Baslik"];
        $Icerik=$_POST["Icerik"];
        
        $guncelle = mysqli_query($bag, "UPDATE hakkimizdat SET Baslik='$Baslik', Icerik='$Icerik' WHERE HakkimizdaID=$id");
        if ($guncelle) {
            $msg = "<p class='alert alert-success'>Hakkımızda Alanı Güncellendi</p>";
        } else {
            $msg = "<p class='alert alert-danger'>Hakkımızda Alanı Güncellenmedi</p>";
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
            <h4>Hakkımızda Alanını Düzenle</h4>
            <hr />

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <?php echo @$msg ?>
            <div class="form-group">
                <label class="col-md-2 form-label">Başlık</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="Baslik" value="<?php echo $Baslik ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class=" form-label col-md-2">İçerik</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="Icerik" rows="10"><?php echo $Icerik ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class=" form-label col-md-2">Görsel</label>
                <div class="col-md-10">
                    <input type="file" class="form-control" name="Gorsel" accept=".jpg,.jpeg,.png"/>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-offset-2 col-md-10 pt-3">
                    <button type="submit" class="btn btn-success">Kaydet</button> |
                    <a href="../ythakkimizda" class="btn btn-light">Geri Dön</a>
                </div>

            </div>
        </form>

        </div>

    </div>
</div>

<?php 

include '../resoruces/_PanelLayout.php';
?>