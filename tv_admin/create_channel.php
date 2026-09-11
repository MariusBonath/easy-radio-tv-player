<?php
require 'db.php';

/* Alle Kategorien fuer das Auswahl-Dropdown holen */
$stmt_categories = $pdo->query("SELECT * FROM tv_categories");
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name        = $_POST['name'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $stream_url  = $_POST['stream_url'] ?? '';
    $web_url     = $_POST['web_url'] ?? '';
    $logo        = $_POST['logo'] ?? '';

    if (!empty($name) && !empty($category_id) && !empty($stream_url)) {

        $stmt = $pdo->prepare(
            "INSERT INTO tv_channels (name, category_id, stream_url, web_url, logo)
             VALUES (:name, :category_id, :stream_url, :web_url, :logo)"
        );

        $stmt->execute([
            'name'        => $name,
            'category_id' => $category_id,
            'stream_url'  => $stream_url,
            'web_url'     => $web_url,
            'logo'        => $logo
        ]);

        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV-Sender anlegen</title>
</head>

<body>
    <h1>TV-Sender anlegen</h1>

    <a href="index.php">Zurück</a>
    <br><br>

    <form method="post">

        Name:
        <input type="text" name="name" required>
        <br><br>

        Kategorie:
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>

                <option value="<?= htmlspecialchars($category['id']) ?>">
                    <?= htmlspecialchars($category['name']) ?></option>

            <?php endforeach; ?>

        </select><br><br>

        Stream URL (.m3u8 oder .mp4): <input type="url" name="stream_url" size="60"><br><br>
        Web URL: <input type="url" name="web_url" size="60"><br><br>
        Logo URL: <input type="url" name="logo" size="60"><br><br>

        <button type="submit">Speichern</button>

    </form>

</body>

</html>
