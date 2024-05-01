<?php
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';

if ($_POST && isset($_POST['id'])) {
    $MesajID = $_POST['id'];
    mysqli_query($bag, "DELETE FROM iletisimt WHERE MesajID = $MesajID");
    echo "Mesaj Silindi.";
} else {
    echo "Mesaj Silinemedi.";
}
?>

