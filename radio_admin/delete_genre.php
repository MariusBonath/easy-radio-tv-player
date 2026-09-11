<?php
require 'db.php';

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM genres WHERE id = :id");
$stmt->execute(['id' => $id]);
$genre = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("DELETE FROM genres WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header("Location: create_genre.php");
    exit;
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
    <h1>Genre löschen</h1>

    <h2>Genre "<?= htmlspecialchars($genre['name']) ?>" wirklich löschen?</h2>

    <a href="create_genre.php">Zurück</a>

    <form method="post">
        <button type="submit">Löschen</button>
    </form>

</body>

</html>