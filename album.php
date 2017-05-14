<?php
include('datenbankinitialisierung.php');
include('header.php');
include('menue.php');
?>
  <table>
    <caption>Album</caption>
    <tr>
      <th>Album</th>
      <th>Genre</th>
      <th>Erscheinungsdatum</th>
    </tr>

    /*
* Im Folgenden werden die Spalten "Album_Name", "Genre" und "Erscheinungsdatum" aus der
* der Datenbank "MusikDB" mithilfe des SELECT-Statements ausgewählt, falls nicht gesucht wurde.
* Danach werden die verschiedenen Spalten in einer Tabelle auf der Seite angezeigt.
*/
    <?php
    if(!isset($_GET['suchen'])){
    $sql = "SELECT Album_Name, Genre, Erscheinungsdatum FROM album";
    foreach ($pdo->query($sql) as $row) {
      echo "<tr>";
      echo "<td>", $row['Album_Name'], "</td>";
      echo "<td>", $row['Genre'], "</td>";
      echo "<td>", $row['Erscheinungsdatum'], "</td>";
      echo "</tr>";
      }
      echo "</table>";
    }
      if(isset($_GET['suchen'])){
        $album = $_POST['Album'];
        $erscheinungsdatum = $_POST['Erscheinungsdatum'];
        $genre =  $_POST['Genre'];
        $error = false;
        $errortext;
        $result;
        if(strlen($album) == 0 && strlen($erscheinungsdatum) == 0 && strlen($genre) == 0){
          $errortext = "Bitte füllen Sie genau ein Feld.";
          $error = true;
        }
        switch(true){
        case strlen($album) != 0 :
          $statement = $pdo->prepare("SELECT Album_Name, Erscheinungsdatum, Genre FROM album WHERE Album_Name = :Album_Name");
          $statement->execute(array(':Album_Name' => $album));
        break;
        case strlen($erscheinungsdatum) != 0 :
          $regausdruck = "/[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/";
          if(!preg_match($regausdruck, $erscheinungsdatum)){
            $errortext = "Bitte geben Sie ein reguläres Datum ein. Das Format ist YYYY-MM-DD";
            $error = true;
          }
          $statement = $pdo->prepare("SELECT Album_Name, Erscheinungsdatum, Genre FROM album WHERE Erscheinungsdatum = :Erscheinungsdatum");
          $statement->execute(array(':Erscheinungsdatum' => $erscheinungsdatum));
        break;
        case strlen($genre) != 0 :
          $statement = $pdo->prepare("SELECT Album_Name, Erscheinungsdatum, Genre FROM album WHERE Genre = :Genre");
          $statement->execute(array(':Genre' => $genre));
        break;
      }
        if($error){
          echo "<tr>";
          echo "<td>", $errortext,"</td>";
          echo "<td> </td>";
          echo "<td> </td>";
          echo "</tr>";
          echo "</table>";
        }
        if(!$error){
          $result =  $statement->fetchAll();
          if(count($result) != 0){
             foreach( $result as $row) {
               echo "<tr>";
               echo "<td>", $row['Album_Name'], "</td>";
               echo "<td>", $row['Genre'], "</td>";
               echo "<td>", $row['Erscheinungsdatum'], "</td>";
               echo "</tr>";
               }
           }
           else {
             echo "<tr>";
             echo "<td>","Kein Eintrag gefunden";"</td>";
             echo "</tr>";
           }
           echo "</table>";
         }
      }
      ?>
      <form action="?suchen=1" method="post">
      Album:<br>
      <input type="Album" size="40" maxlength="250" name="Album"><br><br>
      Genre:<br>
      <input type="Genre" size="40" maxlength="250" name="Genre"><br><br>
      Erscheinungsdatum:<br>
      <input type="Erscheinungsdatum" size="40" maxlength="250" name="Erscheinungsdatum"><br><br>
      <input type="submit" value="Suchen">
      </form>
      <?php

      /*
     * Nun folgt das Rechtemanagement. In der IF-Abfrage wird abgefragt, ob der
     * angemeldete User schriebende oder lesende Rechte hat. Dazu wurde
     * datenbankinitialisierung.php herangezogen.
     *
     * Wenn der User die entsprechenden schreibenden Rechte hat, kann er "Album",
     * "Genre" sowie "Erscheinungsdatum" des Titels, in eine Input-Form eintragen.
     * Diese wird mithilfe eines Submit Buttons abgeschlossen.
     * Eine weitere If-Abfrage stellt sicher, dass alle Felder ausgefüllt wurden.
     * Des Weiteren wird mithilfe eines regausdrucks überprüft, ob das Input-Form
     * der Laenge des Titels im Format "YYYY-MM-DD" eingetragen wurde.
     *
     * Sind die vorher beschriebenen Bedingungen erfüllt, werden die Daten mithilfe
     * eines INSERT-Statements in die Datenbank geschrieben.
     */

      if($rechte == "1"){
        ?>
        <br>
        <form action="?einfügen=1" method="post">
        Album:<br>
        <input type="Album" size="40" maxlength="250" name="Album"><br><br>
        Genre:<br>
        <input type="Genre" size="40" maxlength="250" name="Genre"><br><br>
        Erscheinungsdatum:<br>
        <input type="Erscheinungsdatum" size="40" maxlength="250" name="Erscheinungsdatum"><br><br>
        <input type="submit" value="Abschicken">
        </form>
        <?php
        if(isset($_GET['einfügen'])) {           //Abfrage ob Login Fornular abgesendet
         $album = $_POST['Album'];
         $genre = $_POST['Genre'];
         $erscheinungsdatum = $_POST['Erscheinungsdatum'];
         $error = false;
         if(strlen($album) == 0 || strlen($genre) == 0 || strlen($erscheinungsdatum) == 0){
           echo "Alle Felder müssen ausgefüllt werden.";
           $error = true;
         }
         $regausdruck = "/[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/";
         if(!preg_match($regausdruck, $erscheinungsdatum)){
           echo "Bitte geben Sie ein reguläres Datum ein. Das Format ist YYYY-MM-DD";
           $error = true;
         }
         if(!$error){
           $statement = $pdo->prepare("INSERT INTO album (Album_Name, Genre, Erscheinungsdatum) VALUES (:Album, :Genre, :Erscheinungsdatum)");    //Datenbankabfrage ob E-Mail-Adresse Vorhanden
           $result = $statement->execute(array('Album' => $album, 'Genre' => $genre, 'Erscheinungsdatum' => $erscheinungsdatum));
           $user = $statement->fetch();
         }
       }
     }
  ?>
</body>
</html>
