<?php
session_start();

// Termina la sessione
session_unset();
session_destroy();

// Reindirizza l'utente alla pagina di login o a un'altra pagina
header("Location: ../login.php");
exit();
?>
