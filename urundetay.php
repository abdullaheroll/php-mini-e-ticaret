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

$urundetayi = mysqli_query($bag,"select*from urunlert where UrunID=$detayID"); //ürün detayını çağır
$urunkategorisi=mysqli_query($bag,"select KategoriAdi,u.KategoriID from urunlert u INNER JOIN kategorilert k on u.KategoriID=k.KategoriID where u.UrunID=$detayID");
$listUrun=mysqli_fetch_assoc($urundetayi);
$listKat=mysqli_fetch_assoc($urunkategorisi);

?>

<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="./<?php echo $listUrun['UrunGorselURL'] ?>" alt="..." style="box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);" /></div>
            <div class="col-md-6">
                <div class="small mb-1">SKU: BST-498 | <a href="kategoridetay.php?id=<?php echo $listKat['KategoriID'] ?>"><?php echo $listKat['KategoriAdi'] ?></a> Kategorisinde</div>
                <h1 class="display-5 fw-bolder"><?php echo $listUrun['UrunAdi'] ?></h1>
                <div class="fs-5 mb-5">
                    <span class="text-decoration-line-through">Fiyat: <?php echo $listUrun['Fiyat'] ?>₺</span>
                    <br>
                    <span class="text-decoration-line-through">Stokta Kalan:</span>
                    <span><?php echo $listUrun['StokAdet'] ?></span>
                </div>
                <p class="lead"><?php echo $listUrun['UrunAciklamasi'] ?></p>
                <?php 
                
                
                
                if (@$_SESSION["kullaniciId"] != null)
                {
                    echo "
                    <div class='d-flex'>
                        <a href='siparisolusturma.php?id=$detayID' class='btn btn-outline-dark flex-shrink-1'>
                            Satın Al
                        </a>
                    </div>";
                }
                else
                {
                    echo "
                    <div class='d-flex'>
                        <span class='text-danger h5'>Satın Alım için önce giriş yapmanız lazım.</span>
                    </div>";
                }
                
                ?>
          
        

            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Vitrindeki Diğer Ürünler</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    <?php
    $digerUrunler=mysqli_query($bag,"select*from urunlert") ;
    while($list=mysqli_fetch_array($digerUrunler)){
        echo " <div class='col mb-5' >
        <div class='card h-100' style='width:14rem;'>
            <!-- Product image-->
            <img class='card-img-top rounded' src='./$list[UrunGorselURL]' alt='...' />
            <!-- Product details-->
            <div class='card-body p-4'>
                <div class='text-center'>
                    <!-- Product name-->
                    <h5 class='fw-bolder'>$list[UrunAdi]</h5>
                    <!-- Product price-->
                    $list[Fiyat]₺
                </div>
            </div>
            <!-- Product actions-->
            <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                <div class='text-center'><a class='btn btn-outline-dark mt-auto' href='urundetay.php?id=$list[UrunID]'>Ürüne Git</a></div>
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