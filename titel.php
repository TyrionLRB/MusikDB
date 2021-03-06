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
    if(!isset($_GET['suchen'])){
    $sql = "SELECT Titel_Name, Laenge, Genre FROM titel";
    foreach ($pdo->query($sql) as $row) {
      echo "<tr>";
      echo "<td>", $row['Titel_Name'], "</td>";
      echo "<td>", $row['Laenge'], "</td>";
      echo "<td>", $row['Genre'], "</td>";
      echo "</tr>";
      }
      echo "</table>";
    }
    if(isset($_GET['suchen'])){
      $titel = $_POST['Titel'];
      $laenge = $_POST['Laenge'];
      $genre = $_POST['Genre'];
      $error = false;
      $errortext;
      $result;
      if(strlen($titel) == 0 && strlen($laenge) == 0 && strlen($genre) == 0){
        $errortext = "Bitte füllen Sie genau ein Feld.";
        $error = true;
      }
      switch(true){
      case strlen($titel) != 0 :
        $statement = $pdo->prepare("SELECT Titel_Name, Laenge, Genre FROM titel WHERE Titel_Name = :Titel_Name");
        $statement->execute(array(':Titel_Name' => $titel));
        break;
      case strlen($laenge) != 0 :
        $statement = $pdo->prepare("SELECT Titel_Name, Laenge, Genre FROM titel WHERE Laenge = :Laenge");
        $statement->execute(array(':Laenge' => $laenge));
        break;
      case strlen($genre) != 0 :true;
        $statement = $pdo->prepare("SELECT Titel_Name, Laenge, Genre FROM titel WHERE Genre = :Genre");
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
          echo "<td>", $row['Titel_Name'], "</td>";
          echo "<td>", $row['Laenge'], "</td>";
          echo "<td>", $row['Genre'], "</td>";
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
    Titel:<br>
    <input type="Titel" size="40" maxlength="250" name="Titel"><br><br>
    Laenge:<br>
    <input type="Laenge" size="40" maxlength="250" name="Laenge"><br><br>
    Genre:<br>
    <input type="Genre" size="40" maxlength="250" name="Genre"><br><br>
    <input type="submit" value="Suchen">
    </form>
    <?php
      /*
      * Nun folgt das Rechtemanagement. In der IF-Abfrage wird abgefragt, ob der
      * angemeldete User schriebende oder lesende Rechte hat. Dazu wurde
      * datenbankinitialisierung.php herangezogen.
      *
      * Wenn der User die entsprechenden schreibenden Rechte hat, kann er "Name",
      * "Laenge" sowie "Genre" des Titels, in eine Input-Form eintragen.
      * Diese wird mithilfe eines Submit Buttons abgeschlossen.
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
        Titel:<br>
        <input type="Titel" size="40" maxlength="250" name="Titel"><br><br>
        Laenge:<br>
        <input type="Laenge" size="40" maxlength="250" name="Laenge"><br><br>
        Genre:<br>
        <input type="Genre" size="40" maxlength="250" name="Genre"><br><br>
        <input type="submit" value="Abschicken">
        </form>
        <?php
        if(isset($_GET['einfügen'])) {
         $titel = $_POST['Titel'];
         $laenge = $_POST['Laenge'];
         $genre = $_POST['Genre'];
         $error = false;
         if(strlen($titel) == 0 || strlen($laenge) == 0 || strlen($genre) == 0){
           echo "Alle Felder müssen ausgefüllt werden.";
           $error = true;
         }
         $regausdruck = "/[0-9]{2}[:]{1}[0-9]{2}/";
         if(!preg_match($regausdruck, $laenge)){
           echo "Bitte die Laenge des Titels im Format hh:ss eingeben!";
           $error = true;
         }
         if(!$error){
           $statement = $pdo->prepare("INSERT INTO titel (Titel_Name, Laenge, Genre) VALUES (:Titel_Name, :Laenge, :Genre)");
           $result = $statement->execute(array('Titel_Name' => $titel, 'Laenge' => $laenge, 'Genre' => $genre));
           $user = $statement->fetch();
         }
       }
     }
  ?>
</body>
</html>
