<?php
session_start();
// Kullanıcı giriş yapmış mı kontrol et
if(isset($_SESSION['username'])){
    $loggedin_user = $_SESSION['username'];
} else {
    // Eğer giriş yapılmamışsa, giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <title>Adam Asmaca</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <meta charset="UTF-8">
</head>
<body>
  <div class="sidebar">
    <div class="logo_details">
      <i class="bx bxl-audible icon"></i>
      <div class="logo_name">Adam Asmaca</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="index.php">
          <i class="bx bx-home"></i>
          <span class="link_name">Anamenü</span>
        </a>
        <span class="tooltip">Anamenü</span>
      </li>
      <li>
        <a href="aboutus.html">
          <i class="bx bx-question-mark"></i>
          <span class="link_name">Hakkımızda</span>
        </a>
        <span class="tooltip">Hakkımızda</span>
      </li>
      <li>
        <a href="contact.html">
          <i class="bx bx-envelope"></i>
          <span class="link_name">İletişim</span>
        </a>
        <span class="tooltip">İletişim</span>
      </li>
      <li class="profile">
        <div class="profile_details">
          <img src="images/boy.png" alt="profile image">
          <div class="profile_content">
            <div class="name"><?php echo $loggedin_user; ?></div>
          </div>
        </div>
          <i class="bx bx-log-out" id="log_out"></i>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="anamenu">
        <div class="logo">
            <img src="images/adam-asmaca-oyunu-high-resolution-logo.png">
        </div>
        <div class="oyna">
            <a href="aramenü.html"><i class="fa fa-play-circle"></i><span>Oyna</span></a>
        </div>
        <div class="arkadaşınla-oyna">
            <a href="playfriend.html"><i class="fa fa-users"></i><span>Arkadaşınla Oyna</span></a>
        </div>
        <div class="en-iyi-skorlar">
            <a href="eniyiskorlar.php"> <i class="fa fa-trophy"></i><span>En İyi Skorlar</span></a>
        </div>
      </div>
  </section>
  <!-- Scripts -->
  <script src="script.js"></script>
  <script>
    // JavaScript (script.js)
    document.getElementById('btn').addEventListener("click", function() {
      document.querySelector(".sidebar").classList.toggle("active");
    });

    document.getElementById('log_out').addEventListener("click", function(){
window.location.href = "login.php";
    });
  </script>
</body>
</html>
