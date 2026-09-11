<?php
require 'db.php';

define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/radio_admin');

$stmt = $pdo->query(
    "SELECT
    stations.id,
    stations.name,
    stations.stream_url,
    stations.web_url,
    stations.genre_id,
    stations.logo,
    genres.name AS genre_name
    FROM stations
    JOIN genres ON stations.genre_id = genres.id
    "
);

$stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$defaultLogo = BASE_URL . "/logo.png"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <a href="create_station.php">Create Radio-Station</a>
    <a href="create_genre.php">Create Genre</a>
    <br><br>

    <table border="1">
        <tr>
            <th>id</th>
            <th>logo</th>
            <th>Name</th>
            <th>Genre</th>
            <th>Stream Url</th>
            <th>Web Url</th>
            <th>Action</th>
        </tr>

        <?php foreach ($stations as $station): ?>

            <tr>
                <td><?= htmlspecialchars($station['id']) ?></td>
                <td><img height="50" src="<?= !empty($station['logo']) ? htmlspecialchars($station['logo']) : $defaultLogo ?>"></td>
                <td><?= htmlspecialchars($station['name']) ?></td>
                <td><?= htmlspecialchars($station['genre_name']) ?></td>
                <td>
                    <audio controls>
                        <source src="<?= htmlspecialchars($station['stream_url']) ?>" type="audio/mpeg">
                    </audio>
                </td>
                <td><a href="<?= htmlspecialchars($station['web_url']) ?>">
                        <?= htmlspecialchars($station['web_url']) ?></a>
                </td>

                <td>
                    <a href="edit_station.php?id=<?= htmlspecialchars($station['id']) ?>">Bearbeiten</a> |
                    <a href="delete_station.php?id=<?= htmlspecialchars($station['id']) ?>">Löschen</a>
                </td>
            </tr>

        <?php endforeach; ?>


    </table>
</body>

</html>