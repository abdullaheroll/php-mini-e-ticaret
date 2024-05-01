
<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include '../db_config/database.php';
$kategorilist=mysqli_query($bag,"select*from kategorilert");

echo "

<div class='container-fluid '>

    <div class='py-5'></div>
    <!-- Content Row -->
    <div class='row'>
        <div class='form-horizontal'>
            <h4>Ürünler</h4>

            <hr />

            <div class='card shadow mb-4'>
                <div class='card-header py-3'>
                    <h6 class='m-0 font-weight-bold text-primary'>Mevcut Tüm Ürünler</h6>
                </div>
                <a href='../ytkategori/ekle.php' class='btn btn-success'>Kategori Ekle</a>
                <div class='card-body'>
                    <div class='table-responsive'>

                        <table class='table table-striped-columns' id='myTable' border='1'>
                            <thead>
                                <tr>
                                    <th class='text-center'>Kategori ID</th>
                                    <th class='text-center'>Kategori Başlığı</th>
                                    <th class='text-center'>Kategori Açıklaması</th>
                                    <th class='text-center'>#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class='text-center'>Kategori ID</th>
                                    <th class='text-center'>Kategori Başlığı</th>
                                    <th class='text-center'>Kategori Açıklaması</th>
                                    <th class='text-center'>#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                              ";
                               while($list=mysqli_fetch_array($kategorilist))
                                 echo"   <tr>
                                        <td class='text-center'>$list[KategoriID]</td>
                                        <td class='text-center'>$list[KategoriAdi]</td>
                                        <td class='text-center'>$list[KategoriAciklamasi]</td>
                                        <td class='text-center'>
                                            <a href='../ytkategori/duzenle.php?id=$list[KategoriID]' class='btn btn-info'>Düzenle</a> |
                                            <button type='button' data-id='$list[KategoriID]' onclick='sil($list[KategoriID])' class='btn btn-danger'>Sil</button>
                                        </td>
                                    </tr>
                                ";

echo "
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

";
include '../resoruces/_PanelLayout.php';
?>
<script src="../content/jquery.min.js"></script>
<script>
    function sil(id) {
        if (confirm("Bu kategoriyi silerseniz, kategoriye bağlı ürünler görünmez. Onun için önce ürünlerin kategori bilgisini güncellemeniz gerekir!")) {

            $.ajax({
                url: '../ytkategori/sil.php',
                type: 'POST',
                data: { id: id },
                success: function () {
                    alert('Kategori Silindi.');
                    window.location.reload();
                },
                error: function () {
                    alert('Kategori Silinemedi.');
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

