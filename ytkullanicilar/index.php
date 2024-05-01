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
            <h4>Kullanıcılar</h4>

            <hr />

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sistemde Kayıtlı Tüm Kullanıcılar</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped-columns" id="myTable" border="1">
                            <thead>
                                <tr>
                                    <th class="text-center">Kullanıcı ID</th>
                                    <th class="text-center">İsim</th>
                                    <th class="text-center">E-posta</th>
                                    <th class="text-center">Teslimat Adresi</th>
                                    <th class="text-center">Fatura Adresi</th>
                                    <th class="text-center">Kayıt Tarihi</th>
                                    <th class="text-center">Rolü</th>
                                    <th class="text-center">Aktiflik</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Kullanıcı ID</th>
                                    <th class="text-center">İsim</th>
                                    <th class="text-center">E-posta</th>
                                    <th class="text-center">Teslimat Adresi</th>
                                    <th class="text-center">Fatura Adresi</th>
                                    <th class="text-center">Kayıt Tarihi</th>
                                    <th class="text-center">Rolü</th>
                                    <th class="text-center">Aktiflik</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                include '../db_config/database.php';
                                 $kullanicilarList=mysqli_query($bag,"select*from kullanicilart");
                                 while($list=mysqli_fetch_array($kullanicilarList))
                                    {
                                     echo "<tr>
                                            <td class='text-center'>$list[KullaniciID]</td>
                                            <td class='text-center'>$list[Isim]</td>
                                            <td class='text-center'>$list[Eposta]</td>
                                            <td class='text-center'>$list[TeslimatAdresi]</td>
                                            <td class='text-center'>$list[FaturaAdresi]</td>
                                            <td class='text-center'>" . date('d/m/Y', strtotime($list['KayitTarihi'])) . "</td>
                                            <td class='text-center'>";
                                                if ($list["RolID"] == "1")
                                                {
                                               echo "<p>Yönetici</p>";
                                                }
                                                else if ($list["RolID"] == "2")
                                                {
                                                    echo  "<p>Kullanıcı</p>";
                                                }
                                                else
                                                {
                                                   echo " <p id='spr' data-id='3'>Süper Yönetici</p>";
                                                }
                                           echo " </td>
                                            <td class='text-center'>";
                                                if ($list["RolID"] != "3")
                                                {
                                                    if ($list["Aktiflik"] == true)
                                                    {
                                                       echo " <a href='../ytkullanicilar/pasifet.php?id=$list[KullaniciID]' class='btn btn-warning'>Pasif Et</a>";
                                                    }
    
                                                    else
                                                    {
                                                      echo "  <a href='../ytkullanicilar/aktifet.php?id=$list[KullaniciID]' class='btn btn-success'>Aktif Et</a>";
                                                    }
                                                }
                                                else
                                                {
                                                   echo " <p class='text-danger'>Yetki Yok!</p>";
                                                }
    
    
                                           echo " </td>";
    
                                           echo " <td class='text-center'>";
                                                if ($list["RolID"] == "3")
                                                {
                                                echo "    <p class='text-danger'>Yetki Yok!</p>";
                                                }
                                                else
                                                {
                                                  echo "  <button data-id='$list[KullaniciID]' onclick='sil($list[KullaniciID])' class='btn btn-danger'>Sil</button>";
                                                  echo "  <a href='../ytkullanicilar/rolata.php?id=$list[KullaniciID]' class='btn btn-info btn--round'>Rol Ata</a>";
                                                }
    
                                           echo " </td>
                                      </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="../content/jquery.min.js"></script>

<script>
    function sil(id) {
        //const sprid = 3;
        if (confirm("Bu Kullanıyıcı silerseniz, Kullanıcıya bağlı siparişler görünmez!")) {

            $.ajax({
                url: '../ytkullanicilar/sil.php',
                type: 'POST',
                data: { id: id },
                success: function (sonuc) {
                    alert(sonuc.responseText);
                    window.location.reload();
                },
                error: function (sonuc) {
                    alert(sonuc.responseText);
                    window.location.reload();
                   
                }
            });
        }
        else {
            alert("İşlem İptal Edildi.");
        }
    }

</script>

<link rel="stylesheet" type="text/css" href="../content/yonetim/lib/dataTable/dataTables.bootstrap4.min.css" />
<script type="text/javascript" src="../content/yonetim/lib/dataTable/datatables.min.js"></script>
<script type="text/javascript" src="../content/yonetim/lib/dataTable/dataTables.bootstrap4.min.js"></script>
<script>

    $('#myTable').dataTable({
        language: {
            info: "_TOTAL_ kayıttan _START_ - _END_ kayıt gösteriliyor.",
            infoEmpty: "Gösterilecek hiç kayıt yok.",
            loadingRecords: "Kayıtlar yükleniyor.",
            lengthMenu: "Sayfada _MENU_ kayıt göster",
            zeroRecords: "Tablo boş",
            search: "Arama:",
            infoFiltered: "(toplam _MAX_ kayıttan filtrelenenler)",

            paginate: {
                first: "İlk",
                previous: "Önceki",
                next: "Sonraki",
                last: "Son"
            },
        },


    });
</script>

<?php 
require '../resoruces/_PanelLayout.php';
?>