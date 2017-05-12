<?php

/*
* In diesem PHP-Form wird die Verbindung zur Datenbank hergestellt.
*/

session_start();
$rechte = $_SESSION['rechte'];
$pdo = new PDO('mysql:host=localhost;dbname=MusikDB', 'root', '');
?>
