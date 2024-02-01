<?php
include("../common/connessione.php");

//session_start();

if (isset($_SESSION['utente']) && $_SESSION['tipo'] == 'fattorino') {
    $mailFattorino = $_SESSION['utente'];
    $data = $_POST['data'];
    $ora = $_POST['ora'];

    // inserimento in consegna
    $queryAssignDeliveryGuy = "INSERT INTO consegna (mailfatt, data, ora) VALUES (?, ?, ?)";
    $stmtAssignDeliveryGuy = $conn->prepare($queryAssignDeliveryGuy);
    $stmtAssignDeliveryGuy->bind_param("sss", $mailFattorino, $data, $ora);
    $stmtAssignDeliveryGuy->execute();

    if ($stmtAssignDeliveryGuy->affected_rows > 0) {
        echo "Ordine assegnato al fattorino";
    } else {
        echo "Errore: assegnamento non avvenuto";
    }

    $stmtAssignDeliveryGuy->close();
} else {
    echo "Errore: Accesso non autorizzato";
}
?>
