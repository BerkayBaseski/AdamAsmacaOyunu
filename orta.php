<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adam Asmaca - Orta</title>
    <link rel="stylesheet" href="hangman.css">
    <script src="scripts/word-list2.js" defer></script>
<script src="scripts/script2.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="game-modal">
        <div class="content">
            <img src="#" alt="gif">
            <h4>Oyun Bitti!</h4>
            <p>Doğru Kelime Şuydu: <b>gökkuşağı</b></p>
            <p>Toplam Puan: <b id="totalPointsDisplay"></b></p>
            <button class="play-again">Tekrar Oyna</button>
        </div>
    </div>

    <div class="container">
        <div class="hangman-box">
            <img src="#" draggable="false" alt="hangman-img">
            <h1>ADAM ASMACA</h1>
        </div>
        <div class="game-box">
            <ul class="word-display"></ul>
            <h4 class="hint-text">İpucu: <b></b></h4>
            <h4 class="guesses-text">Yanlış Tahminler: <b></b></h4>
            <div class="keyboard"></div>
            <div style="position: fixed; top: 80px; right: 90px;"><a href="kolay.php"><i
                        style="color: white; font-size: 24px; font-weight: bold;" class="fa fa-undo"></i></a></div>
            <div style="color: white; font-size: 18px; font-weight: bold; position: fixed; top: 10px; right: 42px;"
                class="round-count"><span id="roundCount"></span></div>
            <div style="color: white; font-size: 18px; font-weight: bold; position: fixed; top: 40px; right: 35px;"
                class="total-points">Toplam Puan: <span id="totalPoints"></span></div>
        </div>
    </div>
</body>

</html>
<script>
</script>