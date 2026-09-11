<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

/* Den zu bearbeitenden Sender laden */
$stmt = $pdo->prepare("SELECT * FROM tv_channels WHERE id = :id");
$stmt->execute(['id' => $id]);
$channel = $stmt->fetch();

if (!$channel) {
    header("Location: index.php");
    exit;
}

/* Kategorien fuer das Dropdown */
$stmt_categories = $pdo->query("SELECT * FROM tv_categories");
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name        = $_POST['name'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $stream_url  = $_POST['stream_url'] ?? '';
    $web_url     = $_POST['web_url'] ?? '';
    $logo        = $_POST['logo'] ?? '';

    if (!empty($name) && !empty($category_id) && !empty($stream_url)) {
        $stmt = $pdo->prepare(
            "UPDATE tv_channels SET
            name = :name,
            category_id = :category_id,
            stream_url = :stream_url,
            web_url = :web_url,
            logo = :logo
            WHERE id = :id"
        );
        $stmt->execute([
            'name'        => $name,
            'category_id' => $category_id,
            'stream_url'  => $stream_url,
            'web_url'     => $web_url,
            'logo'        => $logo,
            'id'          => $id
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
    <title>Sender bearbeiten</title>
</head>

<body>
    <h2>Sender "<?= htmlspecialchars($channel['name']) ?>" bearbeiten</h2>

    <a href="index.php">Zurück zur Übersicht</a>
    <br><br>

    <form method="post">

        Name:
        <input type="text" name="name" value="<?= htmlspecialchars($channel['name']) ?>" required>
        <br><br>

        Kategorie:
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>

                <option value="<?= htmlspecialchars($category['id']) ?>"
                    <?= $category['id'] == $channel['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>

            <?php endforeach; ?>

        </select><br><br>

        Stream URL: <input type="url" name="stream_url" size="60" value="<?= htmlspecialchars($channel['stream_url']) ?>" required>
        <br><br>
        Web URL: <input type="url" name="web_url" size="60" value="<?= htmlspecialchars($channel['web_url']) ?>">
        <br><br>
        Logo URL: <input type="url" name="logo" size="60" value="<?= htmlspecialchars($channel['logo']) ?>">
        <br><br>

        <button type="submit">Aktualisieren</button>

    </form>

</body>

</html>
