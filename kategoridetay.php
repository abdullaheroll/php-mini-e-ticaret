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
include 'db_config/database.php';
$detayID = $_GET["id"];

$listKat=mysqli_query($bag,"select*from kategorilert where KategoriID=$detayID");
$listKatIcr=mysqli_fetch_assoc($listKat);

/*


*/

?>

<section class="py-5">
    <h3 class="text-center text-danger"><b class="text-dark"><?php echo $listKatIcr["KategoriAdi"] ?> </b>Kategorisindeki Ürünler</h3>
    <p class="text-center h6"><?php echo $listKatIcr["KategoriAciklamasi"] ?></p>
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
            $KatDetay=mysqli_query($bag,"select k.KategoriID,k.KategoriAdi,k.KategoriAciklamasi,UrunID, UrunAdi, UrunAciklamasi,Fiyat,UrunGorselURL
             from urunlert u INNER JOIN kategorilert k on u.KategoriID=k.KategoriID where k.KategoriID=$detayID");
            while($list=mysqli_fetch_array($KatDetay))
            {
                $aciklama = strlen($list['UrunAciklamasi']) > 50 ? substr($list['UrunAciklamasi'], 0, 50) . "..." : $list['UrunAciklamasi'];
               echo "  <div class='col mb-5'>
               <div class='card' style='width: 18rem;'>
                   <a href='urundetay.php?id=$list[UrunID]'>
                       <img class='card-img-top' src='./$list[UrunGorselURL]' alt='Card image cap' height='250'>
                   </a>
                   <div class='card-body'>
                       <h5 class='card-title'>$list[UrunAdi]</h5>
                       <p class='card-text'>$aciklama</p>
                       <h5 class='card-title text-info'>$list[Fiyat]₺</h5>
                       <a href='urundetay.php?id=$list[UrunID]' class='btn btn-outline-success'>Ürüne Git</a>
                   </div>
               </div>
           </div>";
            }
            
            ?>
          


        </div>
    </div>
</section>
<?php

include 'resoruces/_SiteLayout.php';
?>
