<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=MusikDB', 'root', '');
if(isset($_GET['login'])) {
 $email = $_POST['Email'];
 $passwort = $_POST['Passwort'];
 $statement = $pdo->prepare("SELECT * FROM nutzer WHERE Email = :Email");
 $result = $statement->execute(array('Email' => $email));
 $user = $statement->fetch();
 //�berpr�fung des Passworts
 if ($user !== false && password_verify($passwort, $user['Passwort'])) {
// $_SESSION['Nutzer_ID'] = $user['id'];
//die('Login erfolgreich. Weiter zu <a href="interpret.htm">internen Bereich</a>');
header('Location: interpret.htm');
 } else {
 $errorMessage = "E-Mail oder Passwort war ung�ltig<br>";
 }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
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
<input type="Password" size="40"  maxlength="250" name="Passwort"><br>

<input type="submit" value="Abschicken">
</form>
</body>
</html>

<?php
session_start();
if(!isset($_SESSION['Nutzer_ID'])) {
 die('Bitte zuerst <a href="Login.php">einloggen</a>');
}
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['Nutzer_ID'];
echo "Hallo User: ".$userid;
?>
