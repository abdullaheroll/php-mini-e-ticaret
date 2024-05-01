<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';

if ($_POST && isset($_POST['id'])) {
    $KUllaniciID = $_POST["id"]; //id değerini çağırma
    $superAdmin=0;
     $suparadminrolid = mysqli_query($bag,"select RolID from kullanicilart where KullaniciID=$KUllaniciID");

     while($rolList=mysqli_fetch_assoc($suparadminrolid)){
        $superAdmin=$rolList["RolID"];
    }
    
    if($superAdmin==3){
       echo "hatalı istek";
    }
    else{
        mysqli_query($bag,"delete from kullanicilart where KullaniciID=$KUllaniciID");
        echo "ok";
    }

}

?>