<?php 
 @session_start();
include 'db_config/database.php';

//Kişisel Bilgiler

$kullaniciId =  $_SESSION["kullaniciId"];
if($kullaniciId == 0){
    header("location:giris.php");
}

$hesapayarlari=mysqli_query($bag,"select Isim,Eposta,TeslimatAdresi,FaturaAdresi, KayitTarihi from kullanicilart where KullaniciID = $kullaniciId");
$list=mysqli_fetch_assoc($hesapayarlari);

if($_POST){
    //Kişisel Bilgileri Kaydetme
         $isim=$_POST["Isim"];
        $eposta=$_POST["Eposta"];
        $teslimatAdresi=$_POST["TeslimatAdresi"];
        $faturaAdresi=$_POST["FaturaAdresi"];
        if(empty($isim) || empty($eposta)){
            $msg="<div class='text-center'><p class='alert alert-danger'>isim ve eposta boş geçilemez!</p></div>";
            header('refresh:3');
        }
        else{
            $kaydet=mysqli_query($bag,"update kullanicilart set Isim= '$isim', Eposta='$eposta',TeslimatAdresi='$teslimatAdresi',
            FaturaAdresi='$faturaAdresi' where KullaniciID=$kullaniciId ");
           
            if($kaydet){
                $msg="<div class='text-center'><p class='alert alert-success'>Bilgileriniz Kayıt Edildi!</p></div>";
                header('refresh:3');
            }
            else{
                $msg="<div class='text-center'><p class='alert alert-danger'>Bilgileriniz Kayıt Edilemedi!</p></div>";
                header('refresh:3');
            }
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
    <h3 class="text-center text-danger">Hesabım</h3>
    <div class="container px-4 px-lg-5 mt-5">
    <?php echo @$msg; ?>
        <div class="justify-content-center">
            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'hesap')">Hesap Ayarları</button>
                <button href="sifre.php" class="tablinks" onclick="window.location.href='sifre.php'">Parola İşlemleri</button>
                <button class="tablinks" onclick="openCity(event, 'siparis')">Siparişlerim</button>
            </div>

            <!-- Tab content -->
            <div id="hesap" class="tabcontent">
          
                <h3>Kişisel Bilgiler</h3>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="hesap">
                    <div class="form-group">
                        <label class="form-label">İsim</label>
                        <input type="text" class="form-control" value="<?php echo $list["Isim"] ?>" id="isim" name="Isim" required />
                        <p id="isimalert"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Eposta</label>
                        <input type="text" class="form-control" value="<?php echo $list["Eposta"] ?>" id="eposta" name="Eposta" required />
                        <p id="epostalert"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teslimat Adresi</label>
                        <input type="text" class="form-control" value="<?php echo $list["TeslimatAdresi"] ?>"id="teslimatadresi" name="TeslimatAdresi" maxlength="500  "/>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fatura Adresi</label>
                        <input type="text" class="form-control" value="<?php echo $list["FaturaAdresi"] ?>" id="faturaAdresi" name="FaturaAdresi" maxlength="500" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" onclick="hesapkaydet()">Kaydet</button>
                    </div>
                    
                </form>
            </div>

            <div id="siparis" class="tabcontent">
                <h3>Sipariş Geçmişim</h3>
                <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Siparis ID</th>
                        <th>Ürün</th>
                        <th>Fiyat</th>
                        <th>Tarih</th>
                        <th>Teslimat Adresi Ve Fatura Adresi</th>
                        <th>Durum</th>
                        <th>Fatura</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Siparis ID</th>
                        <th>Ürün</th>
                        <th>Fiyat</th>
                        <th>Tarih</th>
                        <th>Teslimat Adresi Ve Fatura Adresi</th>
                        <th>Durum</th>
                        <th>Fatura</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $siparislerim=mysqli_query($bag,"SELECT s.SiparisID,s.FaturaURL, u.UrunAdi, d.SatisFiyati, s.OlusturmaTarihi, d.TeslimatAdresi, d.FaturaAdresi, s.Durum 
                    FROM siparislert s 
                    INNER JOIN siparisdetayt d ON s.SiparisID = d.SiparisID  
                    INNER JOIN urunlert u ON u.UrunID = s.UrunID
                    WHERE s.KullaniciID = $kullaniciId");
                    $hasOrders = false; // Başlangıçta sipariş yok olarak kabul edelim

                    while ($list = mysqli_fetch_array($siparislerim)) {
                        if ($list['SiparisID'] > 0) {
                            $hasOrders = true; // En az bir sipariş varsa bu değişkeni true yapalım
                    
                            $drm = "";
                            if ($list['Durum'] == 1) {
                                $drm = "<label class='text-info'>Sipariş Alındı</label>";
                            } elseif ($list['Durum'] == 2) {
                                $drm = "<label class='text-primary'>Sipariş Hazırlanıyor</label>";
                            } elseif ($list['Durum'] == 3) {
                                $drm = "<label class='text-warning'>Kargoya Verildi</label>";
                            } elseif ($list['Durum'] == 4) {
                                $drm = "<label class='text-success'>Teslimat Tamamlandı</label>";
                            } else {
                                $drm = "<label class='text-danger'>İptal Edildi</label>";
                            }
                    
                            echo "
                            <tr>
                                <td>{$list['SiparisID']}</td>
                                <td>{$list['UrunAdi']}</td>
                                <td>{$list['SatisFiyati']}₺</td>
                                <td class='text-center'>" . date('d/m/Y', strtotime($list['OlusturmaTarihi'])) . "</td>
                                <td>{$list['TeslimatAdresi']} || {$list['FaturaAdresi']}</td>
                                <td>{$drm}</td>";
                                if($list['FaturaURL']!=null){
                                    echo " <td><a href='./{$list['FaturaURL']}' target='_blank' class='btn btn-warning'>Ürün Faturası</a></td>";
                                }
                                else{
                                    echo "<td class='text-danger'>Fatura Daha Kesilmedi</td>";
                                }
                               
                            echo"</tr>";
                        }
                    }
                    
                    // Eğer hiç sipariş yoksa bu mesajı gösterelim
                    if (!$hasOrders) {
                        echo "<tr><td colspan='6' class='text-center text-danger'>Hiç sipariş vermediniz.</td></tr>";
                    }?>
                  
                </tbody>
                </table>
            </div>
        </div>
    </div>


</section>

<script src="content/jquery-3.3.1.min.js"></script>
<script>
    var isim = document.getElementById('isim'); //isim idli input
    var eposta = document.getElementById('eposta'); //eposta idli input

    var isimalert = document.getElementById('isimalert'); //isimalert idli p etiketi
    var epostalert = document.getElementById('epostalert');//epostalert idli p etiketi

    isim.addEventListener('keyup', isimkontrol);
    eposta.addEventListener('keyup', epostakontrol);
    //isim ve eposta inputlarının boş olup olmadğını kontrol etme
    function isimkontrol(e) {
        if (isim.value == '') {
            isimalert.textContent = 'İsim Boş geçilemez';
            isimalert.style.color = 'red';
        }
        else {
            isimalert.textContent = '';
        }
    }
    function epostakontrol(e) {
        if (eposta.value == '') {
            epostalert.textContent = 'Eposta Boş geçilemez';
            epostalert.style.color = 'red';
        }
        else {
            epostalert.textContent = '';
        }
    }

</script>


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