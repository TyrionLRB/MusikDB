<?php
include('datenbankinitialisierung.php');
include('header.php');
include('menue.php');
?>
    <table>
    <caption>Titel</caption>
    <tr>
      <th>Titel_Name</th>
    </tr>
    <?php
    $sql = "SELECT * FROM titel";

    foreach ($pdo->query($sql) as $row) {
      echo "<tr>";
      echo "<td>", $row['Titel_Name'], "</td>";
      echo "</tr>";

      }
      echo "</table>";

      if($rechte == "1"){
        ?>
        <form action="?einfügen=1" method="post">
        Titel:<br>
        <input type="Titel" size="40" maxlength="250" name="Titel"><br><br>

        <input type="submit" value="Abschicken">
        </form>
        <?php
        if(isset($_GET['einfügen'])) {           //Abfrage ob Login Fornular abgesendet
         $titel = $_POST['Titel'];
         $statement = $pdo->prepare("INSERT INTO titel (Titel_Name) VALUES (:Titel)");    //Datenbankabfrage ob E-Mail-Adresse Vorhanden
         $result = $statement->execute(array('Titel' => $titel));
         $user = $statement->fetch();
       }
     }
    include('footer.php');
  ?>
