<?php
require 'db.php';

$stmt_genres = $pdo->query("SELECT * FROM genres");
$genres = $stmt_genres->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name =  $_POST['name'] ?? '';
    $genre_id = $_POST['genre_id'] ?? '';
    $stream_url = $_POST['stream_url'] ?? '';
    $web_url = $_POST['web_url'] ?? '';
    $logo = $_POST['logo'] ?? '';

    if (!empty($name) && !empty($genre_id) && !empty($stream_url)) {

        $stmt = $pdo->prepare(
            "INSERT INTO stations (name, genre_id, stream_url, web_url, logo) VALUES (:name, :genre_id, :stream_url, :web_url, :logo)"
        );

        $stmt->execute([
            'name' => $name,
            'genre_id' => $genre_id,
            'stream_url' => $stream_url,
            'web_url' => $web_url,
            'logo' => $logo
        ]);

        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Radio Station</h1>

    <a href="index.php">Zurück</a>
    <br><br>

    <form method="post">

        Name:
        <input type="text" name="name" required>
        <br><br>

        Genre:
        <select name="genre_id">
            <?php foreach ($genres as $genre): ?>

                <option value="<?= htmlspecialchars($genre['id']) ?>">
                    <?= htmlspecialchars($genre['name']) ?></option>

            <?php endforeach; ?>

        </select><br><br>

        Stream Url: <input type="url" name="stream_url"><br><br>
        Web Url: <input type="url" name="web_url"><br><br>
        Logo Url: <input type="url" name="logo"><br><br>

        <button type="submit">Speichern</button>

    </form>

</body>

</html>