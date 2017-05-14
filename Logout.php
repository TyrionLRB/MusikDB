<?php

/*
* Das Formular Logout.php stellt den Logoutvorgang dar. Wird dieses Formular ausgeführt,
* wird die Session des Users abgeschlossen und er bekommt eine Meldung, dass er
* erfolgreich ausgeloggt wurde.
*/
session_start();
session_destroy();
include('header.php');
echo "<h1>Vielen Dank fuer Ihren Besuch!</h1>
  <p>Ihr Logout war erfolgreich. Wir hoffen, dass Sie uns bald wieder besuchen!
  </p>";

include('footer.php')
?>

