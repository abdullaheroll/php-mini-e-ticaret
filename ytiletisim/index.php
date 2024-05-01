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
            <h4>Gelen Kutusu</h4>

            <hr />

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mevcut Tüm Mesajlar</h6>
                </div>
            
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped-columns" id="myTable" border="1">
                            <thead>
                                <tr>
                                    <th class="text-center">İsim</th>
                                    <th class="text-center">Eposta</th>
                                    <th class="text-center">Tarih</th>
                                    <th class="text-center">İp Adresi</th>
                                    <th class="text-center">Mesaj İceriği</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">İsim</th>
                                    <th class="text-center">Eposta</th>
                                    <th class="text-center">Tarih</th>
                                    <th class="text-center">İp Adresi</th>
                                    <th class="text-center">Mesaj İceriği</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                include "../db_config/database.php";
                                $mesajlar=mysqli_query($bag,"select*from iletisimt");
                                while($list=mysqli_fetch_array($mesajlar)){
                                    echo "
                                    <tr>
                                        <td class='text-center'>$list[Isim]</td>
                                        <td class='text-center'>$list[Eposta]</td>
                                        <td class='text-center'>" . date('d/m/Y', strtotime($list['OlusturmaTarihi'])) . "</td>
                                        <td class='text-center'>$list[IpAdresi]</td>
                                        <td class='text-center'>$list[MesajIcerik]</td>
                                        <td class='text-center'>
                                        <button type='button' data-id='$list[MesajID]' onclick='sil($list[MesajID])' class='btn btn-danger'>Sil</button>
                                        </td>
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
        if (confirm("Mesaj silinsin mi?")) {

            $.ajax({
                url: '../ytiletisim/sil.php',
                type: 'POST',
                data: { id: id },
                success: function () {
                    alert('Mesaj Silindi.');
                    window.location.reload();
                },
                error: function () {
                    alert('Mesaj Silinemedi.');
                    window.location.reload();
                }
            });
        }
        else {
            alert("İşlem İptal Edildi.");
        }
    }
 
</script>

<link rel="stylesheet" type="text/css" href="~/content/yonetim/lib/dataTable/dataTables.bootstrap4.min.css" />
<script type="text/javascript" src="~/content/yonetim/lib/dataTable/datatables.min.js"></script>
<script type="text/javascript" src="~/content/yonetim/lib/dataTable/dataTables.bootstrap4.min.js"></script>
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
include '../resoruces/_PanelLayout.php';
?>