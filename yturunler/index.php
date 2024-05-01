<?php 
@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}
include "../db_config/database.php";


?>
<div class="container-fluid ">

    <div class="py-5"></div>
    <!-- Content Row -->
    <div class="row">
        <div class="form-horizontal">
            <h4>Ürünler</h4>

            <hr />

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mevcut Tüm Ürünler</h6>
                </div>
                <a href="../yturunler/ekle.php" class="btn btn-success">Ürün Ekle</a>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped-columns" id="myTable" border="1">
                            <thead>
                                <tr>
                                    <th class="text-center">Ürün ID</th>
                                    <th class="text-center">Ürün Adı</th>
                                    <th class="text-center">Ürün Fiyatı</th>
                                    <th class="text-center">Stok Adeti</th>
                                    <th class="text-center">Kategorisi</th>
                                    <th class="text-center">Görsel</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Ürün ID</th>
                                    <th class="text-center">Ürün Adı</th>
                                    <th class="text-center">Ürün Fiyatı</th>
                                    <th class="text-center">Stok Adeti</th>
                                    <th class="text-center">Kategorisi</th>
                                    <th class="text-center">Görsel</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <?php 
                                
                                include '../db_config/database.php';
                                $urunlist=mysqli_query($bag,"SELECT u.UrunID,u.UrunAdi,u.UrunAciklamasi,u.Fiyat,u.StokAdet,u.UrunGorselURL,k.KategoriAdi from urunlert u inner JOIN kategorilert k on u.KategoriID=k.KategoriID");

                                while($list=mysqli_fetch_array($urunlist)){
                                  echo " <tr>
                                    <td class='text-center'>$list[UrunID]</td>
                                    <td class='text-center'>$list[UrunAdi]</td>
                                    <td class='text-center'>$list[Fiyat]</td>
                                    <td class='text-center'>$list[StokAdet]</td>
                                    <td class='text-center'>$list[KategoriAdi]</td>
                                    <td class='text-center'><img src='../$list[UrunGorselURL]' alt='$list[UrunAdi]' width='50' /> </td>
                                    <td class='text-center'>
                                        <a href='../yturunler/duzenle.php?id=$list[UrunID]' class='btn btn-info'>Düzenle</a> |
                                        <button id='silid' onclick='sil($list[UrunID])' class='btn btn-danger'>Sil</button>
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
      if (confirm("Ürünü Silmek İstediğinizden Emin Misiniz?")) {

          $.ajax({
              url: '../yturunler/sil.php',
              type: 'POST',
              data: { id: id },
              success: function () {
                  alert('Ürün Silindi.');
                  window.location.reload();
              },
              error: function () {
                  alert('Ürün Silinemedi.');
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

include '../resoruces/_PanelLayout.php';
?>