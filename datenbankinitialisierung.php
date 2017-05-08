<?php
session_start();
$rechte = $_SESSION['rechte'];
$pdo = new PDO('mysql:host=localhost;dbname=MusikDB', 'root', '');
?>
