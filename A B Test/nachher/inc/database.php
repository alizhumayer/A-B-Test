<?php

try {
    $pdo = new PDO("mysql:dbname=ab;host:127.0.0.1", "ab", "HizbyJWYYPO3SEkV");
} catch (PDOException $e) {
    echo "Verbindung zur Datenbank fehlgeschlagen!";
    die();
}

?>