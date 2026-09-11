<?php
require_once 'db.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: create_genre.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM genres WHERE id = :id");
$stmt->execute(['id' => $id]);
$genre = $stmt->fetch();

if (!$genre) {
    header("Location: create_genre.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $genre_name = $_POST['name'] ?? '';

    if (!empty($genre_name)) {
        $stmt = $pdo->prepare("UPDATE genres SET name = :name WHERE id = :id");
        $stmt->execute(['name' => $genre_name, 'id' => $id]);
        header("Location: edit_genre.php?id=$id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre bearbeiten</title>
</head>

<body>
    <h2>Genre "<?= htmlspecialchars($genre['name']) ?>" bearbeiten</h2>

    <a href="create_genre.php">Zurück</a>
    <br>

    <form method="post">
        Genre:
        <input type="text" name="name" value="<?= htmlspecialchars($genre['name']) ?>" placeholder="Genre Name" required><br><br>
        <button type="submit">Aktualisieren</button>
    </form>

</body>

</html>
