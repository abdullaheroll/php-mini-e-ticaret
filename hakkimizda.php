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
$hakkimizda=mysqli_query($bag,"select*from hakkimizdat");
$list=mysqli_fetch_assoc($hakkimizda);
?>

<section class="py-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <img src="./<?php echo $list["GorselURL"] ?>" alt="Görsel" class="img-fluid rounded" width="500" style="box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
            </div>
            <div class="col-12 mb-3">
                <h2 class="text-center" style="text-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);"><?php echo $list["Baslik"] ?></h2>
                <hr />
            </div>

            <div class="col-12">
                <p class="text-center"><?php echo $list["Icerik"] ?></p>
            </div>


        </div>
    </div>
</section>

<?php
include 'resoruces/_SiteLayout.php';
?>