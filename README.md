# Easy Radio & TV Player

Ein webbasierter Radio- und TV-Player mit PHP-Admin-Oberfläche, entwickelt als Portfolio-Projekt im Rahmen meiner Umschulung zum Fachinformatiker Anwendungsentwicklung (IHK).

## Was ist das?

Das Projekt besteht aus zwei eigenständigen Playern:

| Modul | Beschreibung |
|---|---|
| **Easy Radio** | Wählt Genre und Sender, streamt Audio direkt im Browser |
| **Easy TV** | Unterstützt HLS-Streams (`.m3u8`) via hls.js und normale Video-Streams |

Jeder Player hat eine eigene Admin-Oberfläche zum Verwalten von Sendern und Genres/Kategorien sowie JSON-Endpunkte, über die die Player ihre Daten laden.

## Technologien

- **Backend:** PHP 8, PDO/MySQL (Prepared Statements)
- **Frontend:** Vanilla HTML, CSS, JavaScript – kein Framework, kein Build-Schritt
- **Datenbank:** MySQL
- **HLS-Streaming:** [hls.js](https://github.com/video-dev/hls.js/)

## Projektstruktur

```
easy_radio/         → Radio-Player  (player.html)
easy_tv/            → TV-Player     (player.html)
radio_admin/        → Admin: Sender & Genres verwalten (CRUD)
tv_admin/           → Admin: Kanäle & Kategorien verwalten (CRUD)
radio_json/         → JSON-Endpunkte für den Radio-Player
tv_json/            → JSON-Endpunkte für den TV-Player
```

## Lokale Einrichtung (XAMPP)

1. **Repo klonen** in den XAMPP-`htdocs`-Ordner
2. **Datenbank anlegen:** In phpMyAdmin eine neue Datenbank `myradio` erstellen
3. **Tabellen erstellen:** `tv_admin/install.sql` in phpMyAdmin importieren (erstellt TV-Tabellen + Beispieldaten). Die Radio-Tabellen manuell anlegen:

```sql
CREATE TABLE genres (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE stations (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(150) NOT NULL,
    genre_id   INT NOT NULL,
    stream_url VARCHAR(500) NOT NULL,
    web_url    VARCHAR(500),
    logo       VARCHAR(500),
    FOREIGN KEY (genre_id) REFERENCES genres(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

4. **Zugangsdaten konfigurieren:**
   - `radio_admin/db.example.php` → `radio_admin/db.php` kopieren, eigene Daten eintragen
   - `tv_admin/db.example.php` → `tv_admin/db.php` kopieren, eigene Daten eintragen

5. **Player öffnen:**
   - Radio: `http://localhost/easy_radio/player.html`
   - TV: `http://localhost/easy_tv/player.html`

6. **Admin öffnen:**
   - Radio: `http://localhost/radio_admin/`
   - TV: `http://localhost/tv_admin/`

## Live-Demo

- Radio-Player: `http://mariusbonath.bplaced.net/easy_radio/player.html`
- TV-Player: `http://mariusbonath.bplaced.net/easy_tv/player.html`

## Lernziele

- PHP-CRUD-Operationen mit PDO und Prepared Statements
- REST-ähnliche JSON-Endpunkte in PHP
- Dynamisches DOM-Rendering mit Vanilla JavaScript (`fetch`, `async/await`)
- HLS-Streaming im Browser mit hls.js
- Deployment auf einem Shared-Hoster (bplaced.net)
