const wordDisplay = document.querySelector(".word-display");
const guessesText = document.querySelector(".guesses-text b");
const keyboardDiv = document.querySelector(".keyboard");
const hangmanImage = document.querySelector(".hangman-box img");
const gameModal = document.querySelector(".game-modal");
const playAgainBtn = gameModal.querySelector("button");
const totalPointsDisplay = document.getElementById("totalPointsDisplay");

// Initializing game variables
let currentWord, correctLetters, wrongGuessCount, roundsRemaining, totalPoints;
const maxGuesses = 6;
const totalRounds = 10; // Toplam 10 tur oynanacak

const resetGame = () => {
    // Resetting game variables and UI elements
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
        // Rastgele bir kelime seç
        selectedWord = wordList3[Math.floor(Math.random() * wordList3.length)];

        // Seçilen kelimenin daha önce kullanılıp kullanılmadığını kontrol et
        if (!selectedWord.used) {
            isUniqueWord = true;
            selectedWord.used = true; // Kelimeyi kullanıldı olarak işaretle
        }
    }

    // Geri kalan kodlar...
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
    // Update the roundsRemaining value in the HTML
    document.getElementById("roundCount").innerText = `Kalan Turlar: ${roundsRemaining}`;
}

const updateTotalPoints = () => {
    // Update the totalPoints value in the HTML
    document.getElementById("totalPoints").innerText = totalPoints;
    totalPointsDisplay.innerText = totalPoints;
}

const gameOver = (isVictory) => {
    // After game complete.. showing modal with relevant details
    const modalText = isVictory ? `Kelimeyi Buldun!:` : 'Doğru Kelime Buydu:';
    gameModal.querySelector("img").src = `images/${isVictory ? 'victory' : 'lost'}.gif`;
    gameModal.querySelector("h4").innerText = isVictory ? 'Tebrikler!' : 'Oyun Bitti!';
    gameModal.querySelector("p").innerHTML = `${modalText} <b>${currentWord}</b>`;

    gameModal.classList.add("show");

    // Check if there are more rounds to play
    if (roundsRemaining > 0) {
        playAgainBtn.innerText = "Sonraki Tur";
    } else {
        playAgainBtn.innerText = "Oyunu Bitir";
        playAgainBtn.addEventListener("click", function() {
            var oyuncuAdi; // Oyuncu adını veya kimlik bilgisini al
            var oyuncuSkoru = document.getElementById("totalPoints").innerHTML; // Oyuncunun aldığı skoru al
        
            // Kullanıcı adını session'dan al
            $.get("get_username.php", function(data) {
                oyuncuAdi = data;
        
                // Sunucuya skoru gönder
                $.post("kaydet.php", { oyuncuAdi: oyuncuAdi, oyuncuSkoru: oyuncuSkoru }, function(data) {
                    console.log(data);
        
                    // Kayıt işlemi tamamlandıktan sonra yönlendirme yap
                    window.location.href = 'kolay.php';
                });
            });
        });
        
        
    }
}

const initGame = (button, clickedLetter) => {
    // Checking if clickedLetter is exist on the currentWord
    if (currentWord.includes(clickedLetter)) {
        let allLettersGuessed = true; // Flag to check if all letters are guessed

        // Showing all correct letters on the word display
        [...currentWord].forEach((letter, index) => {
            if (letter === clickedLetter) {
                correctLetters.push(letter);
                wordDisplay.querySelectorAll("li")[index].innerText = letter;
                wordDisplay.querySelectorAll("li")[index].classList.add("guessed");
            }

            // Check if any letter is not guessed yet
            if (!correctLetters.includes(letter)) {
                allLettersGuessed = false;
            }
        });

        // Check if all letters are guessed, then add points only once
        if (allLettersGuessed && correctLetters.length === currentWord.length) {
            // Find the word in the wordList3 and add its points to totalPoints only if not guessed before
            const wordInfo = wordList3.find(wordInfo => wordInfo.word === currentWord);
            if (!wordInfo.guessed) {
                totalPoints += wordInfo.points;
                updateTotalPoints();
                wordInfo.guessed = true; // Set as guessed to avoid adding points multiple times
            } else {
                totalPoints += 0;
                updateTotalPoints();
            }
        }
    } else {
        // If clicked letter doesn't exist, update the wrongGuessCount and hangman image
        wrongGuessCount++;
        hangmanImage.src = `images/hangman-${wrongGuessCount}.svg`;

        // Decrease totalPoints only when a wrong letter is guessed
        if (totalPoints > 0) {
            updateTotalPoints();
        }
    }

    button.disabled = true; // Disable the clicked button so the user can't click again
    guessesText.innerText = `${wrongGuessCount} / ${maxGuesses}`;

    // Call the gameOver function if any of these conditions are met
    if (wrongGuessCount === maxGuesses) return gameOver(false);
    if (correctLetters.length === currentWord.length) return gameOver(true);
};

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

// Set initial number of rounds and totalPoints
roundsRemaining = totalRounds;
totalPoints = 0;

// Initial call to the updateRoundCount and updateTotalPoints functions
updateRoundCount();
updateTotalPoints();

getRandomWord();

playAgainBtn.addEventListener("click", () => {
    if (roundsRemaining > 0) {
        getRandomWord();
    } else {
        console.log("Oyun Bitti. 10 turu tamamladın.");
        // Do something else if needed.
    }
});
