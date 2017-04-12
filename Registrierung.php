<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=MusikDB', 'root', '');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registrierung</title>
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if(isset($_GET['register'])) {
 $error = false;
 $email = $_POST['Email'];
 $passwort = $_POST['Passwort'];
 $passwort2 = $_POST['Passwort2'];

 if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
 $error = true;
 }
 if(strlen($passwort) == 0) {
 echo 'Bitte ein Passwort angeben<br>';
 $error = true;
 }
 if($passwort != $passwort2) {
 echo 'Die Passwörter müssen übereinstimmen<br>';
 $error = true;
 }

 //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
 if(!$error) {
 $statement = $pdo->prepare("SELECT * FROM nutzer WHERE Email = :Email");
 $result = $statement->execute(array('Email' => $email));
 $user = $statement->fetch();

 if($user !== false) {
 echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
 $error = true;
 }
 }

 //Keine Fehler, wir können den Nutzer registrieren
 if(!$error) {
 $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

 $statement = $pdo->prepare("INSERT INTO nutzer (Email, Passwort) VALUES (:Email, :Passwort)");
 $result = $statement->execute(array('Email' => $email, 'Passwort' => $passwort_hash));

 if($result) {
 echo 'Registrierung war erfolgreich. <a href="Login.php">Zum Login</a>';
 $showFormular = false;
 } else {
 echo 'Fehler beim Speichern.<br>';
 }
 }
}

if($showFormular) {
?>

<form action="?register=1" method="post">
E-Mail:<br>
<input type="Email" size="40" maxlength="250" name="Email"><br><br>

Dein Passwort:<br>
<input type="Password" size="40"  maxlength="250" name="Passwort"><br>

Passwort wiederholen:<br>
<input type="Password" size="40" maxlength="250" name="Passwort2"><br><br>

<input type="submit" value="Abschicken">
</form>

<?php
} //Ende von if($showFormular)
?>

</body>
</html>
