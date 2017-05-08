<?php
include('datenbankinitialisierung.php');
include('header.php');
include('menue.php');
?>
  <table>
    <caption>Album</caption>
    <tr>
      <th>Album_Name</th>
    </tr>
    <?php
    $sql = "SELECT Album_Name FROM album";

    foreach ($pdo->query($sql) as $row) {
      echo "<tr>";
      echo "<td>", $row['Album_Name'], "</td>";
      echo "</tr>";
      }
      echo "</table>";

      if($rechte == "1"){
        ?>
        <form action="?einfügen=1" method="post">
        Album:<br>
        <input type="Album" size="40" maxlength="250" name="Album"><br><br>

        <input type="submit" value="Abschicken">
        </form>
        <?php
        if(isset($_GET['einfügen'])) {           //Abfrage ob Login Fornular abgesendet
         $album = $_POST['Album'];
         $statement = $pdo->prepare("INSERT INTO album (Album_Name) VALUES (:Album)");    //Datenbankabfrage ob E-Mail-Adresse Vorhanden
         $result = $statement->execute(array('Album' => $album));
         $user = $statement->fetch();
       }
     }
    include('footer.php');
  ?>
