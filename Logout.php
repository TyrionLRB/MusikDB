<?php
session_start();
session_destroy();
include('header.php');
echo "<h1>Vielen Dank fuer Ihren Besuch!</h1>
  <p>Ihr Logout war erfolgreich. Wir hoffen, dass Sie uns bald wieder besuchen!
  </p>";
include('footer.php')
?>
