<?php
require 'db.php';

$stmt_genres = $pdo->query("SELECT * FROM genres");
$genres = $stmt_genres->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'] ?? '';

    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO genres (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        header("Location: create_genre.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Genre erstellen</title>
</head>

<body>
    <h1>Neues Genre erstellen</h1>
    <a href="index.php">Zurück zur Startseite</a>

    <form method="post">
        Genre:
        <input type="text" name="name" required><br><br>
        <button type="submit">Speichern</button>
    </form>

    <h2>Vorhandene Genres</h2>
    <table border="1">
        <?php foreach ($genres as $genre): ?>
            <tr>
                <td><?= htmlspecialchars($genre['name']) ?></td>
                <td><a href="edit_genre.php?id=<?= htmlspecialchars($genre['id']) ?>">Bearbeiten</a> |
                    <a href="delete_genre.php?id=<?= htmlspecialchars($genre['id']) ?>">Löschen</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>