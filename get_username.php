<?php
session_start();

if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "Misafir"; // Varsayılan kullanıcı adı, kullanıcı giriş yapmamışsa
}
?>
