<?php 
 @session_start();
?>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bizim Plak</title>
    <link rel="stylesheet" href="content/webtema/lib/bootstrap.min.css">
    <script src="content/webtema/lib/jquery-3.2.1.slim.min.js"></script>
    <script src="content/webtema/lib/popper.min.js"></script>
    <script src="content/webtema/lib/bootstrap.min.js"></script>
    <link rel="stylesheet" href="content/webtema/css/style.css">
    <link rel="icon" href="Gorsel/favcion.jpeg" type="image/x-icon">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="./">
            <img src="Gorsel/logo.png" width="30" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./">Anasayfa <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kategoriler
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php 
                        include 'db_config/database.php';
                         $kategoriler=mysqli_query($bag,"select*from kategorilert");
                         while($list=mysqli_fetch_array($kategoriler)){
                            echo " <a class='dropdown-item' href='kategoridetay.php?id=$list[KategoriID]'>$list[KategoriAdi]</a>";
                         }
                        ?>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="./hakkimizda.php">Hakkımızda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./iletisim.php">İletişim</a>

                </li>
                <?php
                
              
                 if (@$_SESSION["kullaniciId"] != null) {
                    echo 
                    "<li class='nav-item'>
                    <a class='nav-link' href='./hesabim.php'>Hesabım</a>
                    </li>";
                }
                if (@$_SESSION["rolid"] == 1 || @$_SESSION["rolid"] == 3) {
                    echo 
                    "<li class='nav-item'>
                    <a class='nav-link' href='./ytpanel'>Yönetim Paneli</a>
                    </li>";
                }
                ?>
            </ul>
            <div class="form-inline my-2 my-lg-0">
                <?php 
                   if (@$_SESSION["kullaniciId"] != null)
                   {
                    echo "   <a class='btn btn-outline-danger my-2 my-sm-0' href='./cikis.php'>Çıkış Yap</a>";
                   }
                   else
                   {
                     echo "  <a class='btn btn-outline-success my-2 my-sm-0' href='./giris.php'>Giriş Yap</a>";
   
                   }
                
                ?>
            </div>
        </div>
    </nav>

    <!-- Header-->

    <!--Section-->


    <!--Footer-->

    <footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white" id="yil">Copyright © Abdullah EROL 2023-</p></div>
    </footer>
</body>
</html>

<script>
    var tarih = new Date(); // Tarih nesnesi oluştur
    var yil = tarih.getFullYear(); // Yıl bilgisini al
    document.getElementById('yil').textContent = "Copyright © Abdullah EROL 2023 - " + yil;
</script>