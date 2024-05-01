<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
 include '../db_config/database.php';
$kullaniciID=$_GET["id"];
$kisi=mysqli_query($bag,"select Eposta,RolID from kullanicilart where KullaniciID=$kullaniciID");
$listKisi=mysqli_fetch_assoc($kisi);

if($_POST){
    $rolid=$_POST["RolID"];
    $rolGuncelle=mysqli_query($bag,"update kullanicilart set RolID=$rolid where KullaniciID=$kullaniciID");
    if($rolGuncelle){
        $msg = "<p class='alert alert-success'>Kullanıcının Rolü Güncellendi</p>";
    }
    else{
        $msg = "<p class='alert alert-danger'>Kullanıcının Rolö Güncellenmedi</p>";
    }
    header("refresh: 2");
}

?>

<div class="container-fluid ">

    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
            <h4><?php echo $listKisi["Eposta"]; ?> Kişisine Rol Ata</h4>
            <hr />
           <?php echo @$msg; ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <label class="col-md-2 form-label">Rolü:</label>
                    <?php 
                    
                    if ($listKisi["RolID"] == 1)
                    {
                      echo "<p class='h6 text-danger'>Yönetici</p>";
                       echo " <hr style='width:500px' />";
                    }

                    else if ($listKisi["RolID"] == 2)
                    {
                       echo" <p class='h6 text-info'>Kullanıcı</p>";
                    }
                    else
                    {
                        echo "<p>Hata!</p>";
                    }
                    
                    ?>
                   
                </div>
                <div class="form-group">
                    <label class="col-md-2 form-label">Rol Seç:</label>
                    <div class="col-md-4">

                        <select name="RolID" class="form-control">
                            <option value="1">
                                Yönetici
                            </option>
                            <option value="2">
                                Kullanıcı
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10 pt-3">
                        <button type="submit" class="btn btn-success">Kaydet</button> |
                        <a href="../ytkullanicilar" class="btn btn-light">Geri Dön</a>
                    </div>

                </div>
            </form>

        </div>

    </div>
</div>
<?php 
require '../resoruces/_PanelLayout.php';
?>