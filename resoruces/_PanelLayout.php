
  

<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}

?>

<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bizim Plak | Yönetim Paneli</title>
    <link href="../content/yonetim/lib/bootstrap.min.css" rel="stylesheet">
    <link href="../content/yonetim/lib/docs.css" rel="stylesheet">
    <link rel="icon" href="Gorsel/favcion.jpeg" type="image/x-icon">
</head>
<body>
    <!--Nav Menü-->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../ytpanel">Bizim Plak | E-Ticaret Yönetim Paneli</a>
          
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menüler</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                   <?php 
                    include 'header.php';
                   ?>
                </div>
                <div class="text-center">
                    <a href="../index.php" class="btn btn-outline-light">Anasayfaya Git</a>
                </div>
                
                <hr />
                <h6 class="text-center"> Abdullah EROL</h6>
            </div>
        </div>
    </nav>

    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <?php 
             echo @$content;
            ?>
           
        </div>
        <!--Footer-->
        <footer class="sticky-footer bg-dark py-5">
            <?php 
             include 'footer.php';
            ?>
          
        </footer>
    </div>


</body>
</html>
<script src="../content/yonetim/lib/bootstrap.bundle.min.js"></script>
<script>
    var tarih = new Date(); // Tarih nesnesi oluştur
    var yil = tarih.getFullYear(); // Yıl bilgisini al
    document.getElementById('yil').textContent = "Copyright © Abdullah EROL 2023 - " + yil;
</script>