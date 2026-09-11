<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM stations WHERE id = :id");
$stmt->execute(['id' => $id]);
$station = $stmt->fetch();

if (!$station) {
    header("Location: index.php");
    exit;
}

$stmt_genres = $pdo->query("SELECT * FROM genres");
$genres = $stmt_genres->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $genre_id = $_POST['genre_id'] ?? '';
    $stream_url = $_POST['stream_url'] ?? '';
    $web_url = $_POST['web_url'] ?? '';
    $logo = $_POST['logo'] ?? '';

    if (!empty($name) && !empty($genre_id) && !empty($stream_url)) {
        $stmt = $pdo->prepare(
            "UPDATE stations SET 
            name = :name, 
            genre_id = :genre_id, 
            stream_url = :stream_url, 
            web_url = :web_url, 
            logo = :logo 
            WHERE id = :id"
        );
        $stmt->execute([
            'name' => $name,
            'genre_id' => $genre_id,
            'stream_url' => $stream_url,
            'web_url' => $web_url,
            'logo' => $logo,
            'id' => $id
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
    <title>Station bearbeiten</title>
</head>

<body>
    <h2>Station "<?= htmlspecialchars($station['name']) ?>" bearbeiten</h2>

    <a href="index.php">Zurück zur Übersicht</a>
    <br><br>

    <form method="post">

        Name:
        <input type="text" name="name" value="<?= htmlspecialchars($station['name']) ?>" required>
        <br><br>

        Genre:
        <select name="genre_id" required>
            <?php foreach ($genres as $genre): ?>

                <option value="<?= htmlspecialchars($genre['id']) ?>"
                    <?= $genre['id'] == $station['genre_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre['name']) ?>
                </option>

            <?php endforeach; ?>

        </select><br><br>

        Stream URL: <input type="url" name="stream_url" value="<?= htmlspecialchars($station['stream_url']) ?>" required>
        <br><br>
        Web URL: <input type="url" name="web_url" value="<?= htmlspecialchars($station['web_url']) ?>">
        <br><br>
        Logo URL: <input type="url" name="logo" value="<?= htmlspecialchars($station['logo']) ?>">
        <br><br>

        <button type="submit">Aktualisieren</button>


    </form>

</body>

</html>