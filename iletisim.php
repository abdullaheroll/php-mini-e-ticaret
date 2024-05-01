<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Alışverişin Tadını Çıkarın</h1>
                <p class="lead fw-normal text-white-50 mb-0"></p>
            </div>
</div>
</header>

<?php 
 @session_start();
$anlikTarih=date("Y/m/d"); //Anlık tarih yyy/MM/dd
$ipAdresi = $_SERVER['REMOTE_ADDR'];// Kullanıcının IP adresini al

include 'db_config/database.php';
if($_POST){
   
    $ipadres=
    $isim=$_POST["Isim"];
    $eposta=$_POST["Eposta"];
    $mesajicerik=$_POST["MesajIcerik"];
    $kaydet=mysqli_query($bag,"insert into iletisimt(Isim,Eposta,MesajIcerik,OlusturmaTarihi,IpAdresi) 
    values('$isim','$eposta','$mesajicerik','$anlikTarih','$ipAdresi')");
    if($kaydet){
        $msg="<p class='alert alert-success'>Mesajınız Gönderilmiştir.</p>";
    }
    else{
        $msg="<p class='alert alert-danger'>Mesajınız Gönderilmedi.</p>";
    }
}
?>


<style>
    .contact-form {
        border-right: 1px solid black;
        height:400px;
    }

    .iletisim-foto {
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        margin-top:-4px;
    }
    .label {
        text-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        font-style:oblique;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 contact-form">
            <img src="./Gorsel/iletisim.png" alt="Görsel" class="img-fluid iletisim-foto">
        </div>
        <div class="col-md-6">

            <h2 class="text-info label">İLETİŞİME GEÇİN</h2>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
              <?php echo @$msg ?>
                <div class="form-group">
                    <label for="name" class="label">isim:</label>
                    <input type="text" class="form-control" name="Isim" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="email" class="label">E-posta:</label>
                    <input type="email" class="form-control" name="Eposta" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="message" class="label">Mesajınız:</label>
                    <textarea class="form-control" name="MesajIcerik" rows="3" required maxlength="1000"></textarea>
                </div>

                <button type="submit" class="btn btn-outline-dark">GÖNDER</button>

            </form>
        </div>
    </div>
</div>


<?php

include 'resoruces/_SiteLayout.php';
?>