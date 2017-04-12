<?php
session_start();
if(!isset($_SESSION['Nutzer_ID'])) {
 die('Bitte zuerst <a href="Login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['Nutzer_ID'];

echo "Hallo User: ".$userid;
?>
