<?php
include 'db_config.php';
session_start();
// ... (diğer kodlar)

if (isset($_SESSION['username'])) {
    $oyuncuAdi = $_SESSION['username'];

    // Eğer skor kaydetme formu gönderilmişse işlemi gerçekleştir
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oyuncuSkoru = intval($_POST["oyuncuSkoru"]);

        // Veritabanına skoru ekle
        $sql = "INSERT INTO highscores (oyuncu_adi, skor) VALUES (?, ?)";

        // Hazırlanmış ifade kullanımı
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $oyuncuAdi, $oyuncuSkoru);

        if ($stmt->execute()) {
            echo "Skor başarıyla eklendi";
        } else {
            echo "Skor eklenirken hata oluştu: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    // Kullanıcı giriş yapmamışsa, giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}

// Veritabanı bağlantısını kapat
$conn->close();
?>
