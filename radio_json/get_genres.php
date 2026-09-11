<?php

// Erlaubt Zugriff von anderen Webseiten / Domains.
// Das ist wichtig, wenn JavaScript die Daten per fetch() laden soll.
header("Access-Control-Allow-Origin: *");

// Teilt dem Browser mit, dass als Antwort JSON-Daten kommen.
// Außerdem wird UTF-8 als Zeichensatz verwendet.
header("Content-Type: application/json; charset=utf-8");


// dirname(__DIR__) geht einen Ordner nach oben.
// BASE_PATH speichert also den Grundpfad des Projekts.
define('BASE_PATH', dirname(__DIR__));


// Hier wird der vollständige Pfad zur db.php-Datei zusammengesetzt.
// In dieser Datei liegt die Verbindung zur Datenbank.
$dbPath = BASE_PATH . '/radio_admin/db.php';


// Lädt die Datei mit der Datenbankverbindung.
// Danach ist z.B. die Variable $pdo verfügbar.
require $dbPath;


// SQL-Befehl:
// Alle Einträge aus der Tabelle "genres" holen.
$sql = 'SELECT * FROM genres';

// Die SQL-Abfrage wird an die Datenbank geschickt.
// Das Ergebnis wird in $stmt gespeichert.
$stmt = $pdo->query($sql);


// Alle gefundenen Datensätze auslesen.
// PDO::FETCH_ASSOC bedeutet:
// Die Spaltennamen werden als Schlüssel verwendet.
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Die Daten als JSON an den Browser zurückgeben.
// So kann JavaScript die Antwort später leicht weiterverarbeiten.
echo json_encode($data);
