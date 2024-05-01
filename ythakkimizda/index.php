<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}


?> 


<div class="container-fluid ">

    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
            <h4>Hakkımızda</h4>
            <hr />
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-body">

                    <?php 
                    include "../db_config/database.php";
                    $hakkimizda=mysqli_query($bag,"select*from hakkimizdat");
                    while($list = mysqli_fetch_assoc($hakkimizda))

                   echo "  <center class='col-lg-12'>
                            
                            <img src='../$list[GorselURL]' class='rounded pb-2 text-center' width='350' style='box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);' />

                            <h4 class='card-title mt-3' style='text-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);'>$list[Baslik]</h4>
                            <hr />

                            <p class='card-subtitle pb-3'>$list[Icerik]</p>
                            <a href='../ythakkimizda/duzenle.php?id=$list[HakkimizdaID]' class='btn btn-info'>Düzenle</a>
                        </center>";
                    


                    ?> 
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include '../resoruces/_PanelLayout.php';
?>