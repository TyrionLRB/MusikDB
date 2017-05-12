<?php
include('datenbankinitialisierung.php');
include('header.php');
include('menue.php');
?>
  <table>
    <caption>Titel</caption>
    <tr>
      <th>Name</th>
      <th>Laenge</th>
      <th>Genre</th>
    </tr>
    <?php
    /*
    * Im Folgenden werden die Spalten "Titel_Name", "Laenge" und "Genre" aus der
    * der Datenbank "MusikDB" mithilfe des SELECT-Statements ausgewählt.
    * Danach werden die verschiedenen Spalten in einer Tabelle auf der Seite angezeigt.
    */
    $sql = "SELECT Titel_Name, Laenge, Genre FROM titel";

    foreach ($pdo->query($sql) as $row) {
      echo "<tr>";
      echo "<td>", $row['Titel_Name'], "</td>";
      echo "<td>", $row['Laenge'], "</td>";
      echo "<td>", $row['Genre'], "</td>";
      echo "</tr>";
      }
      echo "</table>";

      /*
      * Nun folgt das Rechtemanagement. In der IF-Abfrage wird abgefragt, ob der
      * angemeldete User schriebende oder lesende Rechte hat. Dazu wurde
      * datenbankinitialisierung.php herangezogen.
      *
      * Wenn der User die entsprechenden schreibenden Rechte hat, kann er den Namen,
      * die Laenge sowie die Genre des Titels, welchen er in die Datenbank einfügen möchte
      * in eine Input-Form eintragen. Diese wird mithilfe eines Submit Buttons abgeschlossen.
      * Eine weitere If-Abfrage stellt sicher, dass alle Felder ausgefüllt wurden.
      * Des Weiteren wird mithilfe eines regausdrucks überprüft, ob das Input-Form
      * der Laenge des Titels im Format "00:00" eingetragen wurde.
      *
      * Sind die vorher beschriebenen Bedingungen erfüllt, werden die Daten mithilfe
      * eines INSERT-Statements in die Datenbank geschrieben.
      */

      if($rechte == "1"){
        ?>
        <form action="?einfügen=1" method="post">
        Album:<br>
        <input type="Name" size="40" maxlength="250" name="Name"><br><br>
        Genre:<br>
        <input type="Laenge" size="40" maxlength="250" name="Laenge"><br><br>
        Erscheinungsdatum:<br>
        <input type="Genre" size="40" maxlength="250" name="Genre"><br><br>
        <input type="submit" value="Abschicken">
        </form>
        <?php
        if(isset($_GET['einfügen'])) {
         $name = $_POST['Name'];
         $laenge = $_POST['Laenge'];
         $genre = $_POST['Genre'];
         $error = false;
         if(strlen($name) == 0 || strlen($laenge) == 0 || strlen($genre) == 0){
           echo "Alle Felder müssen ausgefüllt werden.";
           $error = true;
         }
         $regausdruck = "/[0-9]{2}[:]{1}[0-9]{2}/";
         if(!preg_match($regausdruck, $laenge)){
           echo "Bitte die Laenge des Titels im Format 00:00 eingeben!";
           $error = true;
         }
         if(!$error){
           $statement = $pdo->prepare("INSERT INTO titel (Name, Laenge, Genre) VALUES (:Name, :Laenge, :Genre)");
           $result = $statement->execute(array('Name' => $name, 'Laenge' => $laenge, 'Genre' => $genre));
           $user = $statement->fetch();
         }
       }
     }
    include('footer.php');
  ?>
