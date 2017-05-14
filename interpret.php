<?php
include('datenbankinitialisierung.php');
include('header.php');
include('menue.php');
?>
<table>
  <caption>Interpret</caption>
  <tr>
    <th>Interpret</th>
    <th>Nationalität</th>
    <th>Gründungsdatum</th>
  </tr>
  /*
* Im Folgenden werden die Spalten "Interpret_Name", "Nationalitaet" und "Gruendungsdatum" aus der
* der Datenbank "MusikDB" mithilfe des SELECT-Statements ausgewählt, falls nicht gesucht wurde.
* Danach werden die verschiedenen Spalten in einer Tabelle auf der Seite angezeigt.
*/
  <?php
  if(!isset($_GET['suchen'])){
    $sql = "SELECT Interpret_Name, Nationalitaet, Gruendungsdatum FROM interpret";
    foreach ($pdo->query($sql) as $row) {
      echo "<tr>";
      echo "<td>", $row['Interpret_Name'], "</td>";
      echo "<td>", $row['Nationalitaet'], "</td>";
      echo "<td>", $row['Gruendungsdatum'], "</td>";
      echo "</tr>";
      }
      echo "</table>";
  }
    if(isset($_GET['suchen'])){
      $interpret = $_POST['Interpret'];
      $nationalitaet = $_POST['Nationalitaet'];
      $gruendungsdatum = $_POST['Gruendungsdatum'];
      $error = false;
      $errortext;
      $result;
      if(strlen($interpret) == 0 && strlen($nationalitaet) == 0 && strlen($gruendungsdatum) == 0){
        $errortext = "Bitte füllen Sie genau ein Feld.";
        $error = true;
      }
      switch(true){
      case strlen($interpret) != 0 :
        $statement = $pdo->prepare("SELECT Interpret_Name, Nationalitaet, Gruendungsdatum FROM interpret WHERE Interpret_Name = :Interpret_Name");
        $statement->execute(array(':Interpret_Name' => $interpret));
        break;
      case strlen($nationalitaet) != 0 :
        $statement = $pdo->prepare("SELECT Interpret_Name, Nationalitaet, Gruendungsdatum FROM interpret WHERE Nationalitaet = :Nationalitaet");
        $statement->execute(array(':Nationalitaet' => $nationalitaet));
        break;
      case strlen($gruendungsdatum) != 0 :
        $regausdruck = "/[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/";
        if(!preg_match($regausdruck, $gruendungsdatum)){
          $errortext = "Bitte geben Sie ein reguläres Datum ein. Das Format ist YYYY-MM-DD";
          $error = true;
        }
        $statement = $pdo->prepare("SELECT Interpret_Name, Nationalitaet, Gruendungsdatum FROM interpret WHERE Gruendungsdatum = :Gruendungsdatum");
        $statement->execute(array(':Gruendungsdatum' => $gruendungsdatum));
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
          echo "<td>", $row['Interpret_Name'], "</td>";
          echo "<td>", $row['Nationalitaet'], "</td>";
          echo "<td>", $row['Gruendungsdatum'], "</td>";
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
    Interpret:<br>
    <input type="Interpret" size="40" maxlength="250" name="Interpret"><br><br>
    Nationalität:<br>
    <input type="Nationaltaet" size="40" maxlength="250" name="Nationalitaet"><br><br>
    Gründungsdatum:<br>
    <input type="Gruendungsdatum" size="40" maxlength="250" name="Gruendungsdatum"><br><br>
    <input type="submit" value="Suchen">
    </form>
    <?php
    if($rechte == "1"){
      ?>
      <br>
      <form action="?einfügen=1" method="post">
      Interpret:<br>
      <input type="Interpret" size="40" maxlength="250" name="Interpret"><br><br>
      Nationalität:<br>
      <input type="Nationaltaet" size="40" maxlength="250" name="Nationalitaet"><br><br>
      Gründungsdatum:<br>
      <input type="Gruendungsdatum" size="40" maxlength="250" name="Gruendungsdatum"><br><br>
      <input type="submit" value="Abschicken">
      </form>
      <?php
      if(isset($_GET['einfügen'])) {
       $interpret = $_POST['Interpret'];
       $nationalitaet = $_POST['Nationalitaet'];
       $gruendungsdatum = $_POST['Gruendungsdatum'];
       $error = false;
      if(strlen($interpret) == 0 || strlen($nationalitaet) == 0){
        echo "Felder Interpret und Nationalität müssen ausgefüllt werden.";
        $error = true;
      }
      $regausdruck = "/[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/";
      if(!preg_match($regausdruck, $gruendungsdatum)){
        echo "Bitte geben Sie ein reguläres Datum ein. Das Format ist YYYY-MM-DD";
        $error = true;
      }
      if(!$error){
        $statement = $pdo->prepare("SELECT * FROM interpret WHERE Interpret_Name = $interpret");
        $result = $statement->execute(array('Interpret' => $interpret));
        $user = $statement->fetch();
      if($user !== false) {
      echo 'Dieser Interpret ist bereits vorhanden<br>';
      $error = true;
      }
      }
      if(!$error){
        $statement = $pdo->prepare("INSERT INTO interpret (Interpret_Name, Nationalitaet, Gruendungsdatum) VALUES (:Interpret, :Nationalitaet, :Gruendungsdatum)");
        $result = $statement->execute(array('Interpret' => $interpret, 'Nationalitaet' => $nationalitaet, 'Gruendungsdatum' => $gruendungsdatum));
        $user = $statement->fetch();
      }
      }
      }
?>
</body>
</html>

