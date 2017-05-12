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
    <?php
    $sql = "SELECT Album_Name, Genre, Erscheinungsdatum FROM album";

    foreach ($pdo->query($sql) as $row) {
      echo "<tr>";
      echo "<td>", $row['Album_Name'], "</td>";
      echo "<td>", $row['Genre'], "</td>";
      echo "<td>", $row['Erscheinungsdatum'], "</td>";
      echo "</tr>";
      }
      echo "</table>";

      if($rechte == "1"){
        ?>
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
    include('footer.php');
  ?>
