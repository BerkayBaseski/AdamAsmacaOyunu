<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adam_asmaca";

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    // Hata varsa işlemi sonlandır
    die();
}

// Bağlantı başarılıysa diğer işlemleri burada yapabilirsiniz
?>
