<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=MusikDB', 'root', '');

if(isset($_GET['login'])) {           //Abfrage ob Login Fornular abgesendet
 $email = $_POST['Email'];
 $passwort = $_POST['Passwort'];

 $statement = $pdo->prepare("SELECT * FROM nutzer WHERE Email = :Email");    //Datenbankabfrage ob E-Mail-Adresse Vorhanden
 $result = $statement->execute(array('Email' => $email));
 $user = $statement->fetch();

 //Überprüfung des Passworts
 if ($user !== false && password_verify($passwort, $user['Passwort'])) {   //Passwortüberprüfung.
// $_SESSION['Nutzer_ID'] = $user['id'];
 header('Location: interpret.htm');
 } else {
 $errorMessage = "E-Mail oder Passwort war ungültig<br>";
 }

}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="menue.css" />
  <title>Login</title>
</head>
<body>
  <body style="background-image:url(sunset.jpg)"
  >

<?php
if(isset($errorMessage)) {
 echo $errorMessage;
}
?>

<form action="?login=1" method="post">
E-Mail:<br>
<input type="Email" size="40" maxlength="250" name="Email"><br><br>

Passwort:<br>
<input type="Password" size="40"  maxlength="250" name="Passwort"><br>

<input type="submit" value="Abschicken">
</form>
</body>
</html>
