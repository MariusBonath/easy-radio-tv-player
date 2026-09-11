<?php
require_once 'db.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: create_category.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tv_categories WHERE id = :id");
$stmt->execute(['id' => $id]);
$category = $stmt->fetch();

if (!$category) {
    header("Location: create_category.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category_name = $_POST['name'] ?? '';

    if (!empty($category_name)) {
        $stmt = $pdo->prepare("UPDATE tv_categories SET name = :name WHERE id = :id");
        $stmt->execute(['name' => $category_name, 'id' => $id]);
        header("Location: edit_category.php?id=$id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Kategorie bearbeiten</title>
</head>

<body>
    <h2>Bearbeiten: <?= htmlspecialchars($category['name']) ?></h2>

    <a href="create_category.php">Zurück</a>
    <br>

    <form method="post">
        Kategorie:
        <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" placeholder="Kategorie Name" required><br><br>
        <button type="submit">Aktualisieren</button>
    </form>

</body>

</html>
