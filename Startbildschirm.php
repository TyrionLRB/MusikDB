<?php
include('header.php');
?>

/*
* Der Startbildschirm wird als erstes aufgerufen. Ein kurzer Begrüßungstext wird angezeigt
* sowie zwei Buttons, welche zum Registrierungsformular bzw. zum Loginformular führen.
*/
<body>
  <h1>Willkommen bei der MusikDB von Marco Claussen und Robin Batta</h1><br>
  <p>Zur Nutzung unserer Datenbank muessen Sie sich registrieren. Falls Sie sich schon einen Account angelegt haben, bitten wir Sie, sich einzuloggen.<br> Viel Spass bei der Nutzung unserer MusikDB.</p>
<div align="center">
  <a href="Registrierung.php">
    <button>Registrierung</button>
  </a>
  <a href="Login.php">
    <button>Login</button>
  </a>
</div>
<?php
include('footer.php');
?>
