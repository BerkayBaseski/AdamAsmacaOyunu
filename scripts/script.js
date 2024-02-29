const wordDisplay = document.querySelector(".word-display");
const guessesText = document.querySelector(".guesses-text b");
const keyboardDiv = document.querySelector(".keyboard");
const hangmanImage = document.querySelector(".hangman-box img");
const gameModal = document.querySelector(".game-modal");
const playAgainBtn = gameModal.querySelector("button");
const totalPointsDisplay = document.getElementById("totalPointsDisplay");

// Değişkelnler
let currentWord, correctLetters, wrongGuessCount, roundsRemaining, totalPoints;
const maxGuesses = 6;
const totalRounds = 10; // Toplam 10 tur oynanacak

const resetGame = () => {
    // değişkenler ve arayüz ayarları
    correctLetters = [];
    wrongGuessCount = 0;
    hangmanImage.src = "images/hangman-0.svg";
    guessesText.innerText = `${wrongGuessCount} / ${maxGuesses}`;
    wordDisplay.innerHTML = "";
    keyboardDiv.querySelectorAll("button").forEach(btn => btn.disabled = false);
    gameModal.classList.remove("show");
}

const getRandomWord = () => {
    let isUniqueWord = false;
    let selectedWord;

    // Döngü, benzersiz bir kelime seçene kadar devam eder
    while (!isUniqueWord) {
        // Rastgele bir kelime seçme
        selectedWord = wordList[Math.floor(Math.random() * wordList.length)];

        // Seçilen kelimenin daha önce kullanılıp kullanılmadığını kontrol etme
        if (!selectedWord.used) {
            isUniqueWord = true;
            selectedWord.used = true; // Kelimeyi kullanıldı olarak işaretleme
        }
    }

    // puan ve kelimeyi gösterme
    currentWord = selectedWord.word;
    document.querySelector(".hint-text b").innerText = selectedWord.hint;
    resetGame();
    roundsRemaining--;
    updateRoundCount();
    totalPoints += 0;
    updateTotalPoints();
    wordDisplay.innerHTML = currentWord.split("").map(() => `<li class="letter"></li>`).join("");
}

const updateRoundCount = () => {
    // HTML deki round sayacını güncelleme
    document.getElementById("roundCount").innerText = `Kalan Turlar: ${roundsRemaining}`;
}

const updateTotalPoints = () => {
    // Toplam puanı güncelleme
    document.getElementById("totalPoints").innerText = totalPoints;
    totalPointsDisplay.innerText = totalPoints;
}

const gameOver = (isVictory) => {
    // Oyun bitme kontrolü
    const modalText = isVictory ? `Kelimeyi Buldun!:` : 'Doğru Kelime Buydu:';
    gameModal.querySelector("img").src = `images/${isVictory ? 'victory' : 'lost'}.gif`;
    gameModal.querySelector("h4").innerText = isVictory ? 'Tebrikler!' : 'Yanlış!';
    gameModal.querySelector("p").innerHTML = `${modalText} <b>${currentWord}</b>`;

    gameModal.classList.add("show");

    if (roundsRemaining > 0) {
        playAgainBtn.innerText = "Sonraki Tur";
    } else {
        playAgainBtn.innerText = "Oyunu Bitir";
        playAgainBtn.addEventListener("click", function() {
            var oyuncuAdi; // Oyuncu adını veya kimlik bilgisini alma
            var oyuncuSkoru = document.getElementById("totalPoints").innerHTML; // Oyuncunun aldığı skoru alma
        
            // Kullanıcı adını dosyadan alma
            $.get("get_username.php", function(data) {
                oyuncuAdi = data;
        
                // Sunucuya skoru gönderma
                $.post("kaydet.php", { oyuncuAdi: oyuncuAdi, oyuncuSkoru: oyuncuSkoru }, function(data) {
                    console.log(data);
        
                    // Kayıt işlemi tamamlandıktan sonra yönlendirme yapma
                    window.location.href = 'kolay.php';
                });
            });
        });
        
        
    }
}

const initGame = (button, clickedLetter) => {
    // Tıklanan harfin kelime içinde bulunma kontrolü
    if (currentWord.includes(clickedLetter)) {
        let allLettersGuessed = true; // Kontrol durumu

        // Bilindiğinde kelimeyi göster
        [...currentWord].forEach((letter, index) => {
            if (letter === clickedLetter) {
                correctLetters.push(letter);
                wordDisplay.querySelectorAll("li")[index].innerText = letter;
                wordDisplay.querySelectorAll("li")[index].classList.add("guessed");
            }

            // Kelime bilinmeme kontrolü
            if (!correctLetters.includes(letter)) {
                allLettersGuessed = false;
            }
        });

        // Tüm harflerin tahmin edilip edilmediğini kontrol edip sadece bir kere puan ekleme
        if (allLettersGuessed && correctLetters.length === currentWord.length) {
            // Kelimeyi kelime listesinde bulun ve daha önce tahmin edilmediyse puanlarını totalPoints'e ekleme
            const wordInfo = wordList.find(wordInfo => wordInfo.word === currentWord);
            if (!wordInfo.guessed) {
                totalPoints += wordInfo.points;
                updateTotalPoints();
                wordInfo.guessed = true;
            } else {
                totalPoints += 0;
                updateTotalPoints();
            }
        }
    } else {
        // Tıklanan harf kelimede yoksa kontrolü
        wrongGuessCount++;
        hangmanImage.src = `images/hangman-${wrongGuessCount}.svg`;

        // Total puanı kooruma
        if (totalPoints > 0) {
            updateTotalPoints();
        }
    }

    button.disabled = true; // Butona tıklandığında devre dışı bırakma
    guessesText.innerText = `${wrongGuessCount} / ${maxGuesses}`;

    // Maksimum hakka ulaşıldığında oyunu bitir
    if (wrongGuessCount === maxGuesses) return gameOver(false);
    if (correctLetters.length === currentWord.length) return gameOver(true);
};
 
// klavye tuşlarını diziye aktar
const turkishKeyboard = [
    'a', 'b', 'c', 'ç', 'd', 'e', 'f', 'g', 'ğ', 'h', 'ı', 'i', 'j', 'k', 'l', 'm', 'n',
    'o', 'ö', 'p', 'r', 's', 'ş', 't', 'u', 'ü', 'v', 'y', 'z'
];

// Klavye tuşlarını oluştururken Türkçe karakterleri kullan
for (let i = 0; i < turkishKeyboard.length; i++) {
    const button = document.createElement("button");
    button.innerText = turkishKeyboard[i];
    keyboardDiv.appendChild(button);
    button.addEventListener("click", (e) => initGame(e.target, turkishKeyboard[i]));
}

roundsRemaining = totalRounds;
totalPoints = 0;

// Fonksiyonları çağır
updateRoundCount();
updateTotalPoints();

getRandomWord();

playAgainBtn.addEventListener("click", () => {
    if (roundsRemaining > 0) {
        getRandomWord();
    } else {
        console.log("Oyun Bitti. 10 turu tamamladın.");
        // Konsol kontrolü
    }
});
