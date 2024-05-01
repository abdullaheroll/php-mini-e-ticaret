<?php
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';

if ($_POST && isset($_POST['id'])) {
    $kategoriID = $_POST['id'];
    mysqli_query($bag, "DELETE FROM kategorilert WHERE KategoriID = $kategoriID");
    echo "Kategori Silindi.";
} else {
    echo "Kategori Silinemedi.";
}
?>

