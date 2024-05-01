

<?php

@session_start();


if (@$_SESSION["rolid"] == 2 || @$_SESSION["rolid"] == null)
{
    header("location: ../index.php");
}

include '../db_config/database.php';

//toplam siparişler
$toplamSiparis=mysqli_query($bag,"select count(SiparisID) as SiparisID from siparislert");
$topSiparis=mysqli_fetch_assoc($toplamSiparis);

//toplam ürünler
$toplamUrunler=mysqli_query($bag,"select count(UrunID) as UrunID from urunlert");
$topUrun=mysqli_fetch_assoc($toplamUrunler);

//toplam kullanıcılar
$toplamKullanicilar=mysqli_query($bag,"select count(KullaniciID) as KullaniciID from kullanicilart");
$topKullanici=mysqli_fetch_assoc($toplamKullanicilar);

//Toplam Satış turatı
$toplamSatis=mysqli_query($bag,"select SUM(SatisFiyati) as SatisFiyati from siparisdetayt");
$topSatis=mysqli_fetch_assoc($toplamSatis);

echo "
    <div class='container-fluid'>
    <div class='py-5'></div>
    <!-- Content Row -->
    <div class='row'>
        <!-- Siparişler -->
        <div class='col-xl-3 col-md-5 mb-4'>
            <div class='card border-left-primary shadow h-100 py-2'>
                <div class='card-body'>
                    <div class='row no-gutters align-items-center'>
                        <div class='col mr-2'>
                            <div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>
                                Siparişler
                            </div>
                            <div class='h5 mb-0 font-weight-bold text-gray-800'>$topSiparis[SiparisID]</div>
                        </div>
                        <div class='col-auto'>
                            <i class='fas fa-calendar fa-2x text-gray-300'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ürünler -->
        <div class='col-xl-3 col-md-6 mb-4'>
            <div class='card border-left-success shadow h-100 py-2'>
                <div class='card-body'>
                    <div class='row no-gutters align-items-center'>
                        <div class='col mr-2'>
                            <div class='text-xs font-weight-bold text-success text-uppercase mb-1'>
                                Ürünler
                            </div>
                            <div class='h5 mb-0 font-weight-bold text-gray-800'>$topUrun[UrunID]</div>
                        </div>
                        <div class='col-auto'>
                            <i class='fas fa-dollar-sign fa-2x text-gray-300'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kullanıcılar -->
        <div class='col-xl-3 col-md-6 mb-4'>
            <div class='card border-left-info shadow h-100 py-2'>
                <div class='card-body'>
                    <div class='row no-gutters align-items-center'>
                        <div class='col mr-2'>
                            <div class='text-xs font-weight-bold text-info text-uppercase mb-1'>
                                Kullanıcılar
                            </div>
                            <div class='row no-gutters align-items-center'>
                                <div class='col-auto'>
                                    <div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>$topKullanici[KullaniciID]</div>
                                </div>
                            </div>
                        </div>
                        <div class='col-auto'>
                            <i class='fas fa-clipboard-list fa-2x text-gray-300'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toplam Satış -->
        <div class='col-xl-3 col-md-6 mb-4'>
            <div class='card border-left-warning shadow h-100 py-2'>
                <div class='card-body'>
                    <div class='row no-gutters align-items-center'>
                        <div class='col mr-2'>
                            <div class='text-xs font-weight-bold text-warning text-uppercase mb-1'>
                                Toplam Satış
                            </div>
                            <div class='h5 mb-0 font-weight-bold text-gray-800'>$topSatis[SatisFiyati]₺</div>
                        </div>
                        <div class='col-auto'>
                            <i class='fas fa-comments fa-2x text-gray-300'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>";


echo "


<div class='container-fluid '>

    <!-- Content Row -->
    <div class='row'>
        <div class='form-horizontal'>

            <div class='card shadow mb-4'>
                <div class='card-header py-3'>
                    <h6 class='m-0 font-weight-bold text-danger'>Son Siparişler</h6>
                </div>
                <div class='card-body'>
                    <div class='table-responsive'>

                        <table class='table table-striped-columns' id='myTable' border='1'>
                            <thead>
                                <tr>
                                    <th class='text-center'>Sipariş ID</th>
                                    <th class='text-center'>İsim</th>
                                    <th class='text-center'>E-posta</th>
                                    <th class='text-center'>Ürün</th>
                                    <th class='text-center'>Fiyat</th>
                                    <th class='text-center'>Teslimat Adresi</th>
                                    <th class='text-center'>Fatura Adresi</th>
                                    <th class='text-center'>Sipariş Tarihi</th>
                                    <th class='text-center'>Sipariş Durumu</th>
                                    <th class='text-center'>#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class='text-center'>Sipariş ID</th>
                                    <th class='text-center'>İsim</th>
                                    <th class='text-center'>E-posta</th>
                                    <th class='text-center'>Ürün</th>
                                    <th class='text-center'>Fiyat</th>
                                    <th class='text-center'>Teslimat Adresi</th>
                                    <th class='text-center'>Fatura Adresi</th>
                                    <th class='text-center'>Sipariş Tarihi</th>
                                    <th class='text-center'>Sipariş Durumu</th>
                                    <th class='text-center'>#</th>
                                </tr>
                            </tfoot>
                            <tbody>";
                            // Sipariş sorgusu
                            $siparisSorgu = mysqli_query($bag,"SELECT s.SiparisID, u.UrunAdi, d.SatisFiyati, s.OlusturmaTarihi, d.TeslimatAdresi, d.FaturaAdresi, s.Durum, k.Isim, k.Eposta 
                            FROM siparislert s 
                            INNER JOIN siparisdetayt d ON s.SiparisID = d.SiparisID 
                            INNER JOIN urunlert u ON u.UrunID = s.UrunID 
                            INNER JOIN kullanicilart k ON k.KullaniciID = s.KullaniciID 
                            ORDER BY s.OlusturmaTarihi DESC");
                            while($list=mysqli_fetch_assoc($siparisSorgu)){
                                echo "
                                <tr>
                                <td class='text-center'>$list[SiparisID]</td>
                                <td class='text-center'>$list[Isim]</td>
                                <td class='text-center'>$list[Eposta]</td>
                                <td class='text-center'>$list[UrunAdi]</td>
                                <td class='text-center'>$list[SatisFiyati]</td>
                                <td class='text-center'>$list[TeslimatAdresi]</td>
                                <td class='text-center'>$list[FaturaAdresi]</td>
                                <td class='text-center'>" . date('d/m/Y', strtotime($list['OlusturmaTarihi'])) . "</td>
                                <td class='text-center'>";
                                    if ($list['Durum'] == 1)
                                    {
                                     echo "   <p class='text-info'>Sipariş Alındı</p>";
                                    }
                            
                                    else if ($list['Durum'] == '2')
                                    {
                                        echo "    <p class='text-primary'>Sipariş Hazırlanıyor</p>";
                                    }
                                    else if ($list['Durum'] == '3')
                                    {
                                        echo "    <p class='text-warning'>Kargoya Verildi</p>";
                                    }
                                    else if ($list['Durum'] == '4')
                                    {
                                        echo "   <p class='text-success'>Teslim Edildi</p>";
                                    }
                                    else
                                    {
                                        echo "    <p class='text-danger'>İptal Edildi</p>";
                                    }
                               echo " </td>
                                <td class='text-center'>
                                    <a href='../ytsiparisler/sipdurum.php?id=$list[SiparisID]' class='btn btn-success'>Durum Belirle</a>
                                    <a href='../ytsiparisler/fatura.php?id=$list[SiparisID]' class='btn btn-warning'>Fatura Oluştur</a>
                                </td>
                            </tr>";
                            }
                           

                        echo"

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>


";


require '../resoruces/_PanelLayout.php';
?>
