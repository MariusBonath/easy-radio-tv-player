<?php
require 'db.php';

define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/tv_admin');

/* Alle Sender zusammen mit dem Namen ihrer Kategorie holen */
$stmt = $pdo->query(
    "SELECT
    tv_channels.id,
    tv_channels.name,
    tv_channels.stream_url,
    tv_channels.web_url,
    tv_channels.category_id,
    tv_channels.logo,
    tv_categories.name AS category_name
    FROM tv_channels
    JOIN tv_categories ON tv_channels.category_id = tv_categories.id
    "
);

$channels = $stmt->fetchAll(PDO::FETCH_ASSOC);

$defaultLogo = BASE_URL . "/logo.png";
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV-Admin</title>
</head>

<body>

    <h1>TV-Admin</h1>

    <a href="create_channel.php">TV-Sender anlegen</a>
    <a href="create_category.php">Kategorie anlegen</a>
    <br><br>

    <table border="1" cellpadding="6">
        <tr>
            <th>id</th>
            <th>Logo</th>
            <th>Name</th>
            <th>Kategorie</th>
            <th>Vorschau</th>
            <th>Web Url</th>
            <th>Aktion</th>
        </tr>

        <?php foreach ($channels as $channel): ?>

            <tr>
                <td><?= htmlspecialchars($channel['id']) ?></td>
                <td><img height="50" src="<?= !empty($channel['logo']) ? htmlspecialchars($channel['logo']) : $defaultLogo ?>"></td>
                <td><?= htmlspecialchars($channel['name']) ?></td>
                <td><?= htmlspecialchars($channel['category_name']) ?></td>
                <td>
                    <!-- Kleine Vorschau. HLS-Streams brauchen hls.js (unten eingebunden). -->
                    <video class="preview" width="220" height="124" controls muted
                        data-src="<?= htmlspecialchars($channel['stream_url']) ?>"></video>
                </td>
                <td><a href="<?= htmlspecialchars($channel['web_url']) ?>">
                        <?= htmlspecialchars($channel['web_url']) ?></a>
                </td>

                <td>
                    <a href="edit_channel.php?id=<?= htmlspecialchars($channel['id']) ?>">Bearbeiten</a> |
                    <a href="delete_channel.php?id=<?= htmlspecialchars($channel['id']) ?>">Löschen</a>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

    <!-- hls.js macht die .m3u8-Streams in allen Browsern abspielbar -->
    <script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
    <script>
        /* Fuer jedes Vorschau-Video den Stream laden */
        document.querySelectorAll("video.preview").forEach(function (video) {
            const src = video.dataset.src;

            if (src.endsWith(".m3u8")) {
                if (window.Hls && Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(src);
                    hls.attachMedia(video);
                } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
                    video.src = src; // Safari kann HLS direkt
                }
            } else {
                video.src = src; // normale Video-Datei (z.B. .mp4)
            }
        });
    </script>
</body>

</html>
