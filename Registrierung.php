<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=MusikDB', 'root', '');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="menue.css" />
<title>Registrierung</title>
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular angezeigt werden soll
if(isset($_GET['register'])) {   //Überprüfung ob GET-Parameter übergeben
 $error = false;
 $email = $_POST['Email'];
 $passwort = $_POST['Passwort'];
 $passwort2 = $_POST['Passwort2'];    //Formulardaten abgefragt
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {   //Überprüfung ob eingegebene E-Mail gültig
 echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
 $error = true;
 }
 if(strlen($passwort) == 0) {
 echo 'Bitte ein Passwort angeben<br>';
 $error = true;
 }
 if($passwort != $passwort2) {    //Überprüfung ob beide Passwörter identisch sind
 echo 'Die Passwörter müssen übereinstimmen<br>';
 $error = true;
 }
 if(!$error) {      //Überprüfung, dass die E-Mail-Adresse noch nicht registriert wurde
 $statement = $pdo->prepare("SELECT * FROM nutzer WHERE Email = :Email");
 $result = $statement->execute(array('Email' => $email));
 $user = $statement->fetch();
 if($user !== false) {    //Ausgabe (Errormeldung) wenn E-Mail-Adresse schon vergeben ist.
 echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
 $error = true;
 }
 }
 //Keine Fehler, wir können den Nutzer registrieren
 if(!$error) {
 $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);     //Hashwert für Passwort wird berechnet
 $statement = $pdo->prepare("INSERT INTO nutzer (Email, Passwort) VALUES (:Email, :Passwort)");   //Eintrag eines neuen Nutzers
 $result = $statement->execute(array('Email' => $email, 'Passwort' => $passwort_hash));
 if($result) {
 header('Location: Login.php');    //Erfolgsmeldung das Eintrag des Users erfolgt ist.
 $showFormular = false;       //Registrierungsformular wird nicht nochmal aufgerufen.
 } else {
 echo 'Fehler beim Speichern.<br>';     //Wenn Fehler beim Eintragen in Tabelle.
 }
 }
}
if($showFormular) {       //Formular in welches man die Nutzerdaten eintragen kann.
?>

<form action="?register=1" method="post">
E-Mail:<br>
<input type="Email" size="40" maxlength="250" name="Email"><br><br>

Dein Passwort:<br>
<input type="Password" size="40"  maxlength="250" name="Passwort"><br>

Passwort wiederholen:<br>
<input type="Password" size="40" maxlength="250" name="Passwort2"><br><br>

<input type="submit" value="Abschicken">
<input type="button" onclick="location.href='Login.php'" value="Zum Login">
</form>
<?php
}
include('footer.php');
?>
