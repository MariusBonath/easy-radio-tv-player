<?php

// Erlaubt Zugriff von anderen Webseiten / Domains (fuer fetch()).
header("Access-Control-Allow-Origin: *");

// Antwort ist JSON in UTF-8.
header("Content-Type: application/json; charset=utf-8");

// Grundpfad des Projekts (einen Ordner nach oben).
define('BASE_PATH', dirname(__DIR__));

// Pfad zur zentralen Datenbank-Datei zusammensetzen.
$dbPath = BASE_PATH . '/tv_admin/db.php';

// Datenbank-Verbindung laden -> danach ist $pdo verfuegbar.
require $dbPath;

// Alle Sender holen.
$sql = 'SELECT * FROM tv_channels';
$stmt = $pdo->query($sql);

// Ergebnis als assoziatives Array auslesen.
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Als JSON an den Browser zurueckgeben.
echo json_encode($data);
