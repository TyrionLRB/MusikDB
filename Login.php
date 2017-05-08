<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=MusikDB', 'root', '');
$_SESSION['rechte'] = "";
if(isset($_GET['login'])) {           //Abfrage ob Login Fornular abgesendet
 $email = $_POST['Email'];
 $passwort = $_POST['Passwort'];
 $statement = $pdo->prepare("SELECT * FROM nutzer WHERE Email = :Email");    //Datenbankabfrage ob E-Mail-Adresse Vorhanden
 $result = $statement->execute(array('Email' => $email));
 $user = $statement->fetch();
 //Überprüfung des Passworts
 if ($user !== false && password_verify($passwort, $user['Passwort']) OR $passwort == $user['Passwort']) {   //Passwortüberprüfung.
 $_SESSION['rechte'] = $user['Rechte'];
 header('Location: interpret.php');
 } else {
 $errorMessage = "E-Mail oder Passwort war ungültig<br>";
 }
}
include('header.php');
?>
<body>
<?php
if(isset($errorMessage)) {
 echo $errorMessage;
}
?>
<form action="?login=1" method="post">
E-Mail:<br>
<input type="Email" size="40" maxlength="250" name="Email"><br><br>

Passwort:<br>
<input type="Password" size="40"  maxlength="250" name="Passwort"><br><br>

<input type="submit" value="Abschicken">
<input type="button" onclick="location.href='Registrierung.php'" value="Zur Registrierung">
</form>
<?php
include('footer.php')
 ?>
