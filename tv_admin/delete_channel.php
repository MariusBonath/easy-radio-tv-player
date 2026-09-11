<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id) || $id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tv_channels WHERE id = :id");
$stmt->execute(['id' => $id]);
$channel = $stmt->fetch();

if (!$channel) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("DELETE FROM tv_channels WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sender löschen</title>
</head>

<body>
    <h2>Sender "<?= htmlspecialchars($channel['name']) ?>" wirklich löschen?</h2>

    <a href="index.php">Zurück zur Übersicht</a>
    <br><br>

    <form method="post">
        <button type="submit">Löschen</button>
    </form>

</body>

</html>
