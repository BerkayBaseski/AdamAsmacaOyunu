<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En İyi Skorlar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #0067ac;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        td {
            background-color: #fff;
        }
    </style>
</head>
<body>

<?php
include 'db_config.php';

$sql = "SELECT * FROM highscores ORDER BY skor DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
        <tr>
            <th>Sıra</th>
            <th>Oyuncu Adı</th>
            <th>Skor</th>
        </tr>";

    $sira = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $sira . "</td>
            <td>" . $row["oyuncu_adi"] . "</td>
            <td>" . $row["skor"] . "</td>
        </tr>";
        $sira++;
    }
    echo "</table>";
} else {
    echo "Henüz skor bulunmuyor.";
}

$conn->close();
?>

</body>
</html>
