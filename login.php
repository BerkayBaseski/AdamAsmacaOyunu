<?php
include 'db_config.php';

$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM kullanici WHERE Kullanici_adi='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['Sifre'])) {  
            // Kullanıcı adını PHP $_SESSION değişkenine kaydet
            session_start();
            $_SESSION['username'] = $username;

            header("Location: index.php");
            exit();
        } else {
            $errorMsg = "Invalid password!";
        }
    } else {
        $errorMsg = "User not found!";
    }
}
?>


<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="girisyap.css">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    #togglePassword {
        margin-left: 80%;
        position: relative;
        bottom: 35px;
        cursor: pointer;
    }
</style>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="login.php" method="POST">
                <h1>Giriş Yap</h1>
                <br>
                <input name="username" type="text" placeholder="Kullanıcı Adı" />
                <input type="password" name="password" id="password" placeholder="Şifre" /><i class="fa fa-eye"
                    id="togglePassword"></i>
                <a href="signin.html">Yeni hesap oluştur.</a>
                <a href="guest.html">Ya da Misafir olarak Oyna.</a>
                <button type="submit">Giriş Yap</button>
                <!-- Hata mesajını görüntüle -->
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
                    <h1>Tekrar Hoşgeldin!</h1>
                    <p>Devam etmek için hesap bilgilerinizi girin.</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Şifre göster/gizle ikonunu değiştir
            togglePasswordButton.className = type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
        });
    </script>
</body>

</html>