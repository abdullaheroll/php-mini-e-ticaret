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
            <h4>Siparişler</h4>

            <hr />

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sistemde Kayıtlı Tüm Kullanıcıların Siparişleri</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped-columns" id="myTable" border="1">
                            <thead>
                                <tr>
                                    <th class="text-center">Sipariş ID</th>
                                    <th class="text-center">İsim</th>
                                    <th class="text-center">E-posta</th>
                                    <th class="text-center">Ürün</th>
                                    <th class="text-center">Fiyat</th>
                                    <th class="text-center">Teslimat Adresi</th>
                                    <th class="text-center">Fatura Adresi</th>
                                    <th class="text-center">Sipariş Tarihi</th>
                                    <th class="text-center">Sipariş Durumu</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Sipariş ID</th>
                                    <th class="text-center">İsim</th>
                                    <th class="text-center">E-posta</th>
                                    <th class="text-center">Ürün</th>
                                    <th class="text-center">Fiyat</th>
                                    <th class="text-center">Teslimat Adresi</th>
                                    <th class="text-center">Fatura Adresi</th>
                                    <th class="text-center">Sipariş Tarihi</th>
                                    <th class="text-center">Sipariş Durumu</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                
                                include '../db_config/database.php';
                                $sirpisSorgu=mysqli_query($bag,"SELECT s.SiparisID, u.UrunAdi, d.SatisFiyati, s.OlusturmaTarihi, d.TeslimatAdresi, d.FaturaAdresi, s.Durum,
                                k.Isim,k.Eposta 
                                FROM siparislert s 
                                INNER JOIN siparisdetayt d ON s.SiparisID = d.SiparisID
                                INNER JOIN urunlert u ON u.UrunID = s.UrunID INNER JOIN kullanicilart k on k.KullaniciID=s.KullaniciID");
                                while($list=mysqli_fetch_array($sirpisSorgu)){
                                   echo "<tr>
                                    <td class='text-center'>$list[SiparisID]</td>
                                    <td class='text-center'>$list[Isim]</td>
                                    <td class='text-center'>$list[Eposta]</td>
                                    <td class='text-center'>$list[UrunAdi]</td>
                                    <td class='text-center'>$list[SatisFiyati]</td>
                                    <td class='text-center'>$list[TeslimatAdresi]</td>
                                    <td class='text-center'>$list[FaturaAdresi]</td>
                                    <td class='text-center'>" . date('d/m/Y', strtotime($list['OlusturmaTarihi'])) . "</td>
                                    <td class='text-center'>";
                                        if ($list['Durum'] == "1")
                                        {
                                           echo "<p class='text-info'>Sipariş Alındı</p>";
                                        }

                                        else if ($list["Durum"] == "2")
                                        {
                                            echo "<p class='text-primary'>Sipariş Hazırlanıyor</p>";
                                        }
                                        else if ($list["Durum"] == "3")
                                        {
                                            echo"<p class='text-warning'>Kargoya Verildi</p>";
                                        }
                                        else if ($list["Durum"] == "4")
                                        {
                                            echo "<p class='text-success'>Teslim Edildi</p>";
                                        }
                                        else
                                        {
                                            echo "<p class='text-danger'>İptal Edildi</p>";
                                        }
                                   echo " </td>";

                                    
                                    echo "<td class='text-center'>
                                    <a href='../ytsiparisler/sipdurum.php?id=$list[SiparisID]' class='btn btn-success btn-sm'>Durum Belirle</a>
                                    <a href='../ytsiparisler/fatura.php?id=$list[SiparisID]' class='btn btn-warning btn-sm'>Fatura Oluştur</a>
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