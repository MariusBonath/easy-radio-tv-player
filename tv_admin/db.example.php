<?php

// Vorlage – als db.php kopieren und eigene Zugangsdaten eintragen
// Diese Datei darf committet werden; db.php niemals!

// --- Produktiv (bplaced o. ä.) ---
// $host    = 'localhost';
// $db      = 'deinbenutzername_myradio';
// $user    = 'deinbenutzername';
// $pass    = 'deinPasswort';
// $charset = 'utf8mb4';

// --- Lokal (XAMPP) ---
$host    = 'localhost';
$db      = 'myradio';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Verbindung fehlgeschlagen: ' . $e->getMessage());
}
