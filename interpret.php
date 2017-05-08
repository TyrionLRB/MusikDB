<?php
include('datenbankinitialisierung.php');
include('header.php');
include('menue.php');
?>
<table>
  <caption>Interpret</caption>
  <tr>
    <th>Interpret</th>
  </tr>
  <?php
  $sql = "SELECT Interpret_Name FROM interpret";

  foreach ($pdo->query($sql) as $row) {
    echo "<tr>";
    echo "<td>", $row['Interpret_Name'], "</td>";
    echo "</tr>";
    }
    echo "</table>";

    if($rechte == "1"){
      ?>
      <form action="?einfügen=1" method="post">
      Interpret:<br>
      <input type="Interpret" size="40" maxlength="250" name="Interpret"><br><br>

      <input type="submit" value="Abschicken">
      </form>
      <?php
      if(isset($_GET['einfügen'])) {           //Abfrage ob Login Fornular abgesendet
       $interpret = $_POST['Interpret'];
       $statement = $pdo->prepare("INSERT INTO interpret (Interpret_Name) VALUES (:Interpret)");    //Datenbankabfrage ob E-Mail-Adresse Vorhanden
       $result = $statement->execute(array('Interpret' => $interpret));
       $user = $statement->fetch();
     }
    }

  include('footer.php');
?>
