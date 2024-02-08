<?php
session_start();
include("../common/connessione.php");

if(!isset($_SESSION["utente"])) {
    header("Location: ../index.html");
} else {
    $mail = $_SESSION["utente"];
    $sql = "SELECT acquirente.*, indirizzo.*
            FROM acquirente INNER JOIN indirizzo ON acquirente.domicilio = indirizzo.id
            WHERE acquirente.mail = '$mail';";
    
    $risultato = $conn->query($sql);

    if ($risultato->num_rows > 0) {
        $row = $risultato->fetch_assoc();
    } else {
        echo "Non è stato trovato nessun record associato alla mail";
    }
    $conn->close();
}
?>