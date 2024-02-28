<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kullanıcıyı sorgula
    $sql = "SELECT * FROM kullanici WHERE Mail='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            header("Location: index.html");
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}
$conn->close();
?>
