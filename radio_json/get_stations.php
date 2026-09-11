<?php

// Diese Datei kann von anderen Webseiten aufgerufen werden.
// Das ist wichtig, wenn JavaScript die Daten laden soll.
header("Access-Control-Allow-Origin: *");

// Der Browser soll wissen:
// Die Antwort ist JSON und die Sonderzeichen sind in UTF-8 kodiert.
header("Content-Type: application/json; charset=utf-8");


// Hier wird der Grundpfad des Projekts gespeichert.
// dirname(__DIR__) bedeutet: einen Ordner nach oben gehen.
define('BASE_PATH', dirname(__DIR__));


// Jetzt wird der Pfad zur Datenbankdatei zusammengesetzt.
// Dadurch muss der Pfad nicht komplett ausgeschrieben werden.
$dbPath = BASE_PATH . '/radio_admin/db.php';


// Diese Datei wird eingebunden.
// Dort steht normalerweise die Verbindung zur Datenbank.
// Danach kann man mit $pdo arbeiten.
require $dbPath;


// SQL bedeutet: Sprache für Datenbankabfragen.
// Hier holen wir alle Datensätze aus der Tabelle "stations".
$sql = 'SELECT * FROM stations';

// Die Abfrage wird an die Datenbank geschickt.
// Das Ergebnis kommt in $stmt.
$stmt = $pdo->query($sql);


// Die Daten werden jetzt aus dem Ergebnis gelesen.
// fetchAll() holt alle Zeilen auf einmal.
// PDO::FETCH_ASSOC sorgt dafür, dass die Spaltennamen als Schlüssel benutzt werden.
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Die Daten werden in JSON umgewandelt.
// JSON kann JavaScript sehr gut lesen und verarbeiten.
echo json_encode($data);
