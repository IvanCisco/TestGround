<?php
include("../common/connessione.php");
session_start();
if (!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Menu del Ristorante</title>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
        <script src="../js/navbar.js"></script>
        <script src="../js/javascript.js"></script>
        <script src="../js/funzioni.js" async></script>
    </head>
    <body>
        <?php include("../common/navbar_ristorante.php");?>
        <h1>Il tuo menu</h1>
        <section class="page-content">
        <?php include("../backend/visualizza_pietanze.php");?>
        </section>
        <?php include("../common/footer.html"); ?>
    </body>
</html>