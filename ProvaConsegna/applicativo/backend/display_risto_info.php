<?php
session_start();
include("../common/connessione.php");

if (!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
} else {
    $mail = $_SESSION["utente"];
    $sql = "SELECT ristorante.*, indirizzo.*, sedelegale.via AS viasl, sedelegale.numero AS numerosl, sedelegale.cap AS capsl, sedelegale.citta AS cittasl, operainrist.zona
            FROM ristorante INNER JOIN indirizzo ON ristorante.location = indirizzo.id
            LEFT JOIN indirizzo AS sedelegale ON ristorante.sedelegale = sedelegale.id
            LEFT JOIN operainrist ON ristorante.mail = operainrist.mailrist
            WHERE ristorante.mail = '$mail';";
    $risultato = $conn->query($sql);
    if ($risultato->num_rows > 0) {
        $row = $risultato->fetch_assoc();
    } else {
        echo "Non è stato trovato alcun record associato alla email";
    }
}
?>