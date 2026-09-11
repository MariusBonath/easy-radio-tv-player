# CLAUDE.md – wordpress-easy_radio

## Projektübersicht

Dieses Projekt ist ein **WordPress-Webserver-Verzeichnis** mit zwei eingebetteten Eigenentwicklungen:

| Modul | Zweck |
|---|---|
| `easy_radio/` | Web-Radioplayer (HTML/JS, lädt Daten per Fetch-API) |
| `easy_tv/` | Web-TV-Player (HTML/JS, gleiches Muster wie Radio) |
| `radio_admin/` | PHP-Admin-Oberfläche für Radiosender & Genres (CRUD) |
| `tv_admin/` | PHP-Admin-Oberfläche für TV-Kanäle & Kategorien (CRUD) |
| `radio_json/` | REST-ähnliche JSON-Endpunkte (`get_stations.php`, `get_genres.php`) |
| `tv_json/` | REST-ähnliche JSON-Endpunkte (`get_channels.php`, `get_categories.php`) |

WordPress-Core-Dateien (`wp-*`, `wp-admin/`, `wp-includes/`, `wp-content/`) gehören **nicht** zum eigentlichen Entwicklungsbereich – nicht anfassen, es sei denn ausdrücklich gewünscht.

---

## Technologie-Stack

- **Backend:** PHP 8, PDO/MySQL
- **Frontend:** Vanilla HTML/CSS/JavaScript (kein Framework, kein Build-Schritt)
- **Datenbank:** MySQL – Datenbank `mariusbonath_myradio` (Produktiv), `myradio` (lokal)
- **Hosting:** bplaced.net (`http://mariusbonath.bplaced.net/`)
- **Lokale Entwicklung:** XAMPP/localhost (Port 80)

---

## Architektur

### Datenbankverbindung

Jedes Modul hat eine eigene `db.php`:
- `radio_admin/db.php` – PDO-Verbindung für das Radio-Modul
- `tv_admin/db.php` – PDO-Verbindung für das TV-Modul

Die JSON-Endpunkte (`radio_json/`, `tv_json/`) binden die jeweilige `db.php` über `dirname(__DIR__)` ein.

### Datenbankschema (Radio)

```
genres:   id, name
stations: id, name, stream_url, web_url, genre_id, logo
```

### Datenbankschema (TV)

```
categories: id, name
channels:   id, name, stream_url, web_url, category_id, logo
```

### Player-Logik (Frontend)

- `easy_radio/player.html` und `easy_tv/player.html` sind **standalone HTML-Seiten**
- Sie laden Genres/Kategorien und Sender/Kanäle per `fetch()` von den JSON-Endpunkten
- Basis-URL: `const url = "http://mariusbonath.bplaced.net/";`
- Lautstärke wird in `localStorage` gespeichert
- Kein Bundler, kein npm – direkt im Browser ausführbar

---

## Konventionen

- **Kein Framework** – kein React, Vue, jQuery. Nur Vanilla JS.
- **Kein Build-Schritt** – Dateien werden direkt deployed.
- **Ausgabe immer mit `htmlspecialchars()`** absichern (XSS-Schutz in PHP-Templates).
- JSON-Endpunkte setzen `Access-Control-Allow-Origin: *` (CORS für lokale Entwicklung).
- Deutsche Variablen-/Kommentarsprache ist im Projekt üblich (Lernprojekt).

---

## Häufige Aufgaben

### Neuen Radiosender hinzufügen
→ `radio_admin/create_station.php` (Formular) + SQL INSERT in Tabelle `stations`

### Neues Genre anlegen
→ `radio_admin/create_genre.php`

### Player-Optik ändern
→ CSS in `easy_radio/player.html` (Klassen mit Präfix `rp-`) oder `easy_tv/player.html` (`tv-`)

### JSON-Endpunkt erweitern
→ SQL-Abfrage in `radio_json/get_stations.php` oder `radio_json/get_genres.php` anpassen

### Datenbankverbindung wechseln (lokal ↔ Produktiv)
→ `radio_admin/db.php` – auskommentierte Localhost-Konfiguration umschalten

---

## Sicherheitshinweise

- `db.php` enthält Klartext-Credentials – **nicht committen** (kein Git vorhanden, trotzdem vorsichtig sein)
- Admin-Oberflächen (`radio_admin/`, `tv_admin/`) haben **keine Authentifizierung** – für Produktivbetrieb absichern
- Alle Nutzerausgaben in PHP via `htmlspecialchars()` escapen
