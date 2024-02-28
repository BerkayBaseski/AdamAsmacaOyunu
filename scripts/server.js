const express = require('express');
const mysql = require('mysql');

const app = express();
const port = 3000;

// MySQL bağlantı bilgileri
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'adam_asmaca'
});

// MySQL bağlantısını başlat
connection.connect((err) => {
  if (err) {
    console.error('MySQL connection error:', err);
  } else {
    console.log('Connected to MySQL database');
  }
});

// Yüksek skoru kaydetme fonksiyonu
const saveHighScore = (playerName, score) => {
  const sql = 'INSERT INTO HighScores (playerName, score) VALUES (?, ?)';
  connection.query(sql, [playerName, score], (err, results) => {
    if (err) {
      console.error('Failed to save high score:', err);
    } else {
      console.log('High score saved successfully!');
    }
  });
};

// Örnek bir yüksek puanı kaydetme endpoint'i
app.get('/saveHighScore', (req, res) => {
  const playerName = req.query.playerName;
  const playerScore = req.query.playerScore;
  saveHighScore(playerName, playerScore);
  res.send('High score saved successfully!');
});

// Sunucuyu dinle
app.listen(port, () => {
  console.log(`Server listening at http://localhost:${port}`);
});
