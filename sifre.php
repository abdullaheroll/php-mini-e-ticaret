<?php 
 @session_start();
 include 'db_config/database.php';

 $kullaniciId =  $_SESSION["kullaniciId"];
if($kullaniciId == 0){
    header("location:giris.php");
}
?>
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Alışverişin Tadını Çıkarın</h1>
            <p class="lead fw-normal text-white-50 mb-0"></p>
        </div>
</div>
</header>
<?php 
    //parola değiştirme
    if($_POST){
        $eskiP=$_POST['EskiParola'];
        $yeniP=$_POST['YeniParola'];
        if(empty($eskiP) || empty($yeniP)){
            $msg="<div class='text-center'><p class='alert alert-danger'>Boş geçilemez!</p></div>";
            header('refresh:3');
        }
        else{
            $eskisif=mysqli_query($bag,"select Parola from kullanicilart where KullaniciID=$kullaniciId");
            $eskisifList=mysqli_fetch_assoc($eskisif);

            if($eskisifList['Parola']==$eskiP){
                $sifrekaydet=mysqli_query($bag,"update kullanicilart set Parola='$yeniP' where KullaniciID=$kullaniciId");
                if($sifrekaydet){
                    $msg="<div class='text-center'><p class='alert alert-success'>Parolanız Değiştirildi!</p></div>";
                    header('refresh:3');
                }
                else{
                    $msg="<div class='text-center'><p class='alert alert-danger'>Parolanız Değiştirilemedi!</p></div>";
                    header('refresh:3');
                }
            }
            else{
                $msg="<div class='text-center'><p class='alert alert-danger'>Eski Parolanız Hatalı!</p></div>";
                header('refresh:3');
            }
        }
    }

?>
<section class="py-5">
    <h3 class="text-center text-danger">Hesabım</h3>
    <h3 class="text-center text-info">Parola Ayarları</h3>
    <div class="container px-4 px-lg-5 mt-5">
    <?php echo @$msg; ?>   
    <div class="justify-content-center">

            <!-- Tab links -->
            <div class="tab">
                <button class="" onclick="window.location.href='hesabim.php'">Hesap Ayarları</button>
                <button class="tablinks" onclick="openCity(event, 'parola')">Parola İşlemleri</button>
                <button class="tablinks" onclick="window.location.href='hesabim.php'">Siparişlerim</button>
            </div>

            <!-- Tab content -->

            <div id="parola" class="tabcontent">
                <h3>Parola Değiştirme</h3>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="form-group">
                        <label class="form-label">Eski Parolanız</label>
                        <input type="text" class="form-control" id="eskiParola" name="EskiParola" required />
                        <p id="eskiParolaAlert"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Yeni Parolanız</label>
                        <input type="text" class="form-control" id="yeniParola" name="YeniParola" required />
                        <p id="yeniParolaAlert"></p>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>



<script>

    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    var tarih = new Date(); // Tarih nesnesi oluştur
    var yil = tarih.getFullYear(); // Yıl bilgisini al
    document.getElementById('yil').textContent = "Copyright © Abdullah EROL 2023 - " + yil;
</script>



<?php
include 'resoruces/_SiteLayout.php';
?>