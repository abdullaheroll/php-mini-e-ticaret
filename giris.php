<?php 
  session_start(); 

?>
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Alışverişin Tadını Çıkarın</h1>
                <p class="lead fw-normal text-white-50 mb-0"></p>
            </div>
</div>
</header>

<section class="py-3">
    <h3 class="text-center text-danger">Giriş Yap</h3>
    <p class="text-center text-danger">Satın Alma İşlemleri Ve Daha Fazlası İçin Giriş Yapınız.</p>

    <?php

include 'db_config/database.php';

if ($_POST) {
    $epostaG = $_POST["EpostaG"];
    $sifreG = $_POST["ParolaG"];
   
    $kullaniciId = null;
    $email = "";
    $sifre = "";
    $aktiflik = false;

    $giris = mysqli_query($bag, "SELECT * FROM kullanicilart WHERE Eposta='$epostaG'");
    if(mysqli_num_rows($giris) > 0){
        while ($list = mysqli_fetch_assoc($giris)) {
            $kullaniciId = $list["KullaniciID"];
            $email = $list["Eposta"];
            $sifre = $list["Parola"];
            $rolId = $list["RolID"];
            $aktiflik = $list["Aktiflik"];
        }
        if ($aktiflik == false) {
            $msg = "<div class='alert alert-danger'>Aktifleştirilmemiş hesap.</div>";
        } 
        else{
            if ($email == $epostaG && $sifre == $sifreG) {
          
                $_SESSION["kullaniciId"] = $kullaniciId;
                $_SESSION["email"] = $email;
                $_SESSION["rolid"] = $rolId;
                header("location: ./index.php");
                exit(); // header'dan sonra kodun çalışmasını durdurmak için
            }
             else {
                $msg = "<div class='alert alert-danger'>Giriş bilgilerinizi kontrol ediniz.</div>";
            }
        }
       
    }
    
    else {
        $msg = "<div class='alert alert-danger'>Böyle bir hesap bulunmamaktadır.</div>";
    }
}
?>


    <div id="logreg-forms">
        <div id="mesajdiv">
        </div>
        <form class="form-signin" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <?php echo @$msg; ?>
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">Giriş Yap</h1>
            <input type="text" name="EpostaG" id="inputEmail" class="form-control" placeholder="Eposta Adresi" required="" autofocus="">
            <input type="password" name="ParolaG" id="inputPassword" class="form-control" placeholder="Parola" required="">

            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i>Giriş Yap</button>
            <a href="#" id="forgot_pswd">Şifrenimi Unuttun?</a>
            <hr>
            <!-- <p>Don't have an account!</p>  -->
            <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i>Yeni Hesap İçin Kayıt Ol</button>
        </form>

        <form action="/reset/password/" class="form-reset">
            <input type="email" id="resetEmail" class="form-control" placeholder="Eposta Adresi" required="" autofocus="">
            <button class="btn btn-primary btn-block" type="submit">Sıfırla</button>
            <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Gerİ Dön</a>
        </form>

        <form action="#" class="form-signup" method="post">
            <p style="text-align:center">Veya</p>
            <input type="text" id="isim" class="form-control" placeholder="İsim" name="Isim" required="" autofocus="" maxlength="100">
            <input type="email" id="eposta" class="form-control" placeholder="Eposta Adresi" name="Eposta" required autofocus="" maxlength="100">
            <input type="password" id="parola" class="form-control" placeholder="Parola" name="Parola" required autofocus="" maxlength="25">
            <div class="form-group mt-2">
                <input type="checkbox" name="Onay" id="onay" class="form-check-inline" required />
                <label class="form-label"> Bilgilerimin doğruluğuna eminim.</label>
            </div>

            <button class="btn btn-primary btn-block" type="button" onclick="kayit()"><i class="fas fa-user-plus"></i>Kayıt Ol</button>
            <a href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Geri Dön</a>
        </form>
        <br>

    </div>

</section>
<script src="content/jquery.min.js"></script>

<script>
  /*  function kayit() {
        var isim = document.getElementById('isim').value;
        var eposta = document.getElementById('eposta').value;
        var parola = document.getElementById('parola').value;
        var onay = document.getElementById('onay');
        if (onay.checked == true) {
            $.ajax({
                url: 'kayit.php',
                type: 'POST',
                data: { Isim: isim, Eposta: eposta, Parola: parola },
                success: function (response) {
                    $('#mesajdiv').html("<p class='alert alert-success'>" + response.message + "</p>");
                    setTimeout(function () {
                        // window.location.reload();
                        window.location.href = response.redirectUrl;
                    }, 3000);
                },
                error: function (response) {
                    $('#mesajdiv').html("<p class='alert alert-danger'>" + response.responseJSON.message + "</p>");
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
            });
        } else {
            alert("Bilgilerinizin doğruluğunu onaylamanız lazım!");
        }
    }*/

    function kayit() {
    var isim = document.getElementById('isim').value;
    var eposta = document.getElementById('eposta').value;
    var parola = document.getElementById('parola').value;

    // AJAX ile veriyi kayit.php'ye gönderme
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'kayit.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            $('#mesajdiv').html("<p class='alert alert-success'>" + response.result + "</p>");
            setTimeout(function () {
                window.location.href = 'giris.php';
            }, 3000);
        }
    };
    xhr.send('Isim=' + isim + '&Eposta=' + eposta + '&Parola=' + parola);
}



</script>


<script>
    function toggleResetPswd(e) {
        e.preventDefault();
        $('#logreg-forms .form-signin').toggle()
        $('#logreg-forms .form-reset').toggle()
    }

    function toggleSignUp(e) {
        e.preventDefault();
        $('#logreg-forms .form-signin').toggle();
        $('#logreg-forms .form-signup').toggle();
    }

    $(() => {
        // Login Register Form
        $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
        $('#logreg-forms #cancel_reset').click(toggleResetPswd);
        $('#logreg-forms #btn-signup').click(toggleSignUp);
        $('#logreg-forms #cancel_signup').click(toggleSignUp);
    })
</script>
<?php

include 'resoruces/_SiteLayout.php';
?>