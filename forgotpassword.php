<?php
include 'db_config.php';

// Hata mesajlarını tutacak değişken
$errorMsg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen kullanıcı adı ve e-posta adresini al
    $username = $_POST["username"];
    $email = $_POST["email"];

    // Kullanıcı adı ve e-posta adresini veritabanında kontrol et
    $query = "SELECT * FROM kullanici WHERE Kullanici_adi = '$username' AND Mail = '$email'";
    $result = $conn->query($query);

    // Eğer eşleşme bulunursa, forgotpassword2.html sayfasına yönlendir
    if ($result->num_rows > 0) {
        header("Location: forgotpassword2.php");
        exit();
    } else {
        $errorMsg = "Girilen kullanıcı adı ve e-posta adresi hatalı!";
    }

    // Veritabanı bağlantısını kapat
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="forgotpassword.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="container" id="container">
	<div class="form-container sign-in-container">
		<form action="forgotpassword.php" method="post">
			<h1>Forgot Password</h1>
            <br>
			<span>Enter your registered email to reset your password.</span>
			<input name="username" type="text" placeholder="Username" />
			<input name="email" type="email" placeholder="Email" />
			<a href="signin.html">New here? Sign Up.</a>
            <a href="login.php">Already have an account? Sign In.</a>
			<button type="submit">Continue</button>
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
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>
    const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
</script>
