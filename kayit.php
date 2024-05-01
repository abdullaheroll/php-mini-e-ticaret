<?php
include 'db_config/database.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $isim = $_POST["Isim"];
    $eposta = $_POST["Eposta"];
    $parola = $_POST["Parola"];

    $kullaniciKayitSorgusu = "INSERT INTO kullanicilart (Isim, Eposta, Parola, Aktiflik, KayitTarihi, RolID) " .
        "VALUES ('$isim', '$eposta', '$parola', '0', '" . date('Y-m-d') . "', '1')";
    $kayitSonuc = mysqli_query($bag, $kullaniciKayitSorgusu);
    if ($kayitSonuc) {
        $response = ["result" => "Kayıt başarılı. Hesabınız onaylandıktan sonra alışverişe başlayabilirsiniz!"];
    } else {
        $response = ["result" => "Kayıt Başarısız!"];
    }
    // İşlem sonucunu JSON formatında döndürme
    echo json_encode($response);
}



?>
