<?php
require 'db.php';

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM tv_categories WHERE id = :id");
$stmt->execute(['id' => $id]);
$category = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("DELETE FROM tv_categories WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header("Location: create_category.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Kategorie löschen</title>
</head>

<body>
    <h1>Kategorie löschen</h1>

    <h2>Kategorie "<?= htmlspecialchars($category['name']) ?>" wirklich löschen?</h2>

    <a href="create_category.php">Zurück</a>

    <form method="post">
        <button type="submit">Löschen</button>
    </form>

</body>

</html>
