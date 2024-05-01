<?php 
  @session_start();
  include 'db_config/database.php';
  $urunId=$_GET["id"];
  
  $kullaniciId =  $_SESSION["kullaniciId"];
  if($kullaniciId == 0){
      header("location:giris.php");
  }

  $satinAlinanUrun=mysqli_query($bag,"select UrunID,UrunAdi,UrunGorselURL,Fiyat,UrunAciklamasi from urunlert where UrunID=$urunId");

  $satinAlmakIsteyenKullanici=mysqli_query($bag,"select KullaniciID,FaturaAdresi,TeslimatAdresi from kullanicilart where KullaniciID=$kullaniciId");
  //satın alınmak istenen ürün bilgilerini çağır

  $urunList=mysqli_fetch_assoc($satinAlinanUrun);

  //ürünü almak isteyen kullanıcı bilgilerini çağır
  $kullaniciList=mysqli_fetch_assoc($satinAlmakIsteyenKullanici);

  //Satın Alma İşlemi

  if ($_POST) {
      $urinIdF = $_POST["UrunID"];
      $fiyatF = $_POST["Fiyat"];
      $faturaAdresiF = $_POST["FaturaAdresi"];
      $teslimatAdresiF = $_POST["TeslimatAdresi"];
  
      $siparisId = 0;
      $anlikTarih = date("Y/m/d"); // Anlık tarih yyy/MM/dd
      $siparisOlustur = mysqli_query($bag, "insert into siparislert(UrunID,KullaniciID,OlusturmaTarihi,Durum) 
          values('$urinIdF','$kullaniciId','$anlikTarih','1')");
  
      if ($siparisOlustur) {
          $siparisId = mysqli_insert_id($bag); // Son eklenen siparişin ID'sini al
          if ($siparisId > 0) {
              $siparisDetayOlustur = mysqli_query($bag, "insert into siparisdetayt(SiparisID,SatisFiyati,FaturaAdresi,TeslimatAdresi) 
                  values('$siparisId','$fiyatF','$faturaAdresiF','$teslimatAdresiF')");
  
              if ($siparisDetayOlustur) {
                  $stokDusur = "update urunlert set StokAdet=StokAdet-1 where UrunID='$urinIdF'";
                  $durum = mysqli_query($bag, $stokDusur);
                  if ($durum) {
                      $msg = "<div class='text-center mt-4'><p class='alert alert-success'>Siparişiniz başarıyla oluşturuldu!</p></div>";
                      header('refresh:3; url=hesabim.php');
                  } else {
                      $msg = "<div class='text-center mt-4'><p class='alert alert-danger'>Stok azaltma hatası!</p></div>";
                      header('refresh:3');
                  }
              } else {
                  $msg = "<div class='text-center mt-4'><p class='alert alert-danger'>Sipariş detayı oluşturma hatası!</p></div>";
                  header('refresh:3');
              }
          } else {
              $msg = "<div class='text-center mt-4'><p class='alert alert-danger'>Sipariş oluşturma hatası!</p></div>";
              header('refresh:3');
          }
      } else {
          $msg = "<div class='text-center mt-4'><p class='alert alert-danger'>Sipariş oluşturma hatası!</p></div>";
          header('refresh:3');
      }
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

<section class="py-5">
    <div class="container px-4 card pt-2 pb-2">
        <div class="row">
            <div class="col-md-6">
                <div class="text-center">
                    <img src="./<?php echo $urunList["UrunGorselURL"]; ?>" alt="Ürün İkonu" class="mb-3 rounded" width="100" style="box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
                    <h5><?php echo $urunList["UrunAdi"]; ?></h5>
                    <p><?php echo $urunList["UrunAciklamasi"]; ?></p>
                    <span><?php echo $urunList["Fiyat"]; ?>₺</span>
                </div>
            </div>
            <div class="col-md-6 card" style="box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
                <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <input type="hidden" value="<?php echo $urunList["UrunID"]; ?>" name="UrunID" id="urunID" />
                    <input type="hidden" value="<?php echo $urunList["Fiyat"]; ?>" name="Fiyat" id="fiyat" />
                    <div class="form-group">
                        <label for="billingAddress">Fatura Adresi</label>
                        <input type="text" class="form-control" id="faturaAdresi" name="FaturaAdresi" value="<?php echo $kullaniciList["FaturaAdresi"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="deliveryAddress">Teslimat Adresi</label>
                        <input type="text" class="form-control" id="teslimatAdresi" name="TeslimatAdresi" value="<?php echo $kullaniciList["TeslimatAdresi"]; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-outline-danger btn-block">Satın AL</button>
                </form>
            </div>
        </div>
        <?php echo @$msg; ?>
    </div>
</section>

<?php

include 'resoruces/_SiteLayout.php';
?>