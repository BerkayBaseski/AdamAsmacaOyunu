<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veritabanı bağlantı bilgileri
    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "";
    $dbname = "adam_asmaca";
    $errorMsg = '';

    // Formdan gelen verileri al
    $username = $_POST["username"];
    $newPassword = $_POST["password"];
    $confirmPassword = $_POST["passwordconfirm"];

    // Şifrelerin eşleşip eşleşmediğini kontrol et
    if ($newPassword === $confirmPassword) {
        // Veritabanı bağlantısını oluştur
        $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

        // Bağlantı hatasını kontrol et
        if ($conn->connect_error) {
            die("Veritabanı bağlantı hatası: " . $conn->connect_error);
        }

        // Şifreyi hashle
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Kullanıcı adı ve e-posta adresine göre güncelleme yap
        $query = "UPDATE kullanici SET Sifre = '$hashedPassword' WHERE Kullanici_adi = '$username'";
        $result = $conn->query($query);

        // Güncelleme başarılı ise
        if ($result === TRUE) {
            header("Location: passwordsuccess.html");
        } else {
            $errorMsg = "Şifre güncelleme hatası: " . $conn->error;
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
    } else {
        $errorMsg = "Şifreler eşleşmiyor.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgotpassword.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
	#togglePassword{
		margin-left: 80%;
		position: relative;
		bottom: 40px;
        cursor: pointer;
	}
</style>
<body>
<div class="container" id="container">
    <div class="form-container sign-in-container">
        <form action="forgotpassword2.php" method="post">
            <h1>Şifre Güncelleme</h1>
            <br>
            <input type="text" name="username" placeholder="Kullanıcı Adı" required />
            <input type="password" name="password" id="password" placeholder="Şifre" required />
            <input type="password" name="passwordconfirm" id="password1" placeholder="Şifre Tekrar" required /><i class="fa fa-eye" id="togglePassword"></i>
            <a href="signin.html">Yeni hesap oluşturun</a>
            <a href="login.php">Hesabınız var mı? Giriş yapın.</a>
            <button>Şifreyi Güncelle</button>
            <?php if (!empty($errorMsg)) : ?>
                <p style="color: red;">
                    <?php echo $errorMsg; ?>
                </p>
            <?php endif; ?>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Merhaba!</h1>
                <p>Bilgilerinizi girin ve şifrenizi güncelleyin.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
const passwordInput = document.getElementById('password');
const passwordInput1 = document.getElementById('password1');
const togglePasswordButton = document.getElementById('togglePassword');

togglePasswordButton.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Şifre göster/gizle ikonunu değiştir
    togglePasswordButton.className = type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
});

// İkinci input için de aynı işlemi tekrarlayın
togglePasswordButton.addEventListener('click', () => {
    const type1 = passwordInput1.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput1.setAttribute('type', type1);

    // Şifre göster/gizle ikonunu değiştir
    togglePasswordButton.className = type1 === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
});
</script>
