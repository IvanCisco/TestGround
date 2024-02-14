<?php
session_start();
include("../common/connessione.php");

if (!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
} else {
    $mail = $_SESSION["utente"];
    $sql1 = "SELECT *
            FROM fattorino
            WHERE mail = '$mail'";
    
    $risultato1 = $conn->query($sql1);

    if ($risultato1->num_rows > 0) {
        $row = $risultato1->fetch_assoc();
    } else {
        echo "Non è stato trovato alcun record associato alla e-mail";
    }
}
?>