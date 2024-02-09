<?php
session_start();
include("../common/connessione.php");

if (!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
} else {
    $mail = $_SESSION["utente"];
    $sql = "SELECT ristorante.*, indirizzo.*, indirizzo.via AS viasl, indirizzo.numero AS numerosl, indirizzo.cap AS capsl, indirizzo.citta AS cittasl, operainrist.zona, rlavorasu.turno
            FROM ristorante INNER JOIN indirizzo ON ristorante.location = indirizzo.id
            LEFT JOIN indirizzo AS sedelegale ON ristorante.sedelegale = indirizzo.id
            LEFT JOIN operainrist ON ristorante.mail = operainrist.mailrist
            LEFT JOIN rlavorasu ON ristorante.mail = rlavorasu.mailrist
            WHERE ristorante.mail = '$mail';";
    $risultato = $conn->query($sql);
    if ($risultato->num_rows > 0) {
        $row = $risultato->fetch_assoc();
    } else {
        echo "Non è stato trovato alcun record associato alla email";
    }
}
?>