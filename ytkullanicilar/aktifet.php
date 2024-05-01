<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';
$id = $_GET["id"]; //id değerini çağırma

$aktiflik=mysqli_query($bag,"update kullanicilart set Aktiflik=1 where KullaniciID=$id");
header("location: ../ytkullanicilar/index.php");
?>