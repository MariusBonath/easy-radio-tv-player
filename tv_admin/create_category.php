<?php
require 'db.php';

$stmt_categories = $pdo->query("SELECT * FROM tv_categories");
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'] ?? '';

    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO tv_categories (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        header("Location: create_category.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Kategorie erstellen</title>
</head>

<body>
    <h1>Neue Kategorie erstellen</h1>
    <a href="index.php">Zurück zur Startseite</a>

    <form method="post">
        Kategorie:
        <input type="text" name="name" required><br><br>
        <button type="submit">Speichern</button>
    </form>

    <h2>Vorhandene Kategorien</h2>
    <table border="1" cellpadding="6">
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td><a href="edit_category.php?id=<?= htmlspecialchars($category['id']) ?>">Bearbeiten</a> |
                    <a href="delete_category.php?id=<?= htmlspecialchars($category['id']) ?>">Löschen</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>
