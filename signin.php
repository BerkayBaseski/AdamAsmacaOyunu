<?php
include 'db_config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Şifre hashleme

    // Kullanıcı kaydını ekle
    $sql = "INSERT INTO kullanici (Kullanici_adi, Mail, Sifre) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Başarıyla giriş yapıldıysa, şifreyi oturumda sakla
        $_SESSION['user_password'] = $password;
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
