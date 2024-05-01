<?php
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';

if ($_POST && isset($_POST['id'])) {
    $urunID = $_POST['id'];

    // Ürüne ait görselin yolunu bulma
    $query = "select UrunGorselURL from urunlert where UrunID = $urunID";
    $result = mysqli_query($bag, $query);
    $row = mysqli_fetch_assoc($result);
    $urunGorselURL = $row['UrunGorselURL'];

    // Görseli silme işlemi
    if ($urunGorselURL != null) {
        if (unlink($urunGorselURL)) {
            echo "Ürün görseli silindi.";
        } else {
            echo "Ürün görseli silinemedi.";
        }
    }

    // Ürünü silme işlemi
    $deleteQuery = "delete from urunlert where UrunID = $urunID";
    if (mysqli_query($bag, $deleteQuery)) {
        echo "Ürün Silindi.";
    } else {
        echo "Ürün Silinemedi.";
    }
} else {
    echo "Ürün Silinemedi.";
}
?>
