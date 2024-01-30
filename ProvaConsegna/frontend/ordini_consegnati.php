<?php
include("../common/connessione.php");
session_start();
// Recupero dei dati dell'utente
if(isset($_SESSION['utente'])) {
$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in sessione
?>
<h2>Ordini presi a carico</h2>



<?php

// QUESTA è LA QUERY NUOVA 
$stmt = $conn->prepare("SELECT c.data, c.ora, o.mailacq, o.stato
                            FROM consegna c
                            JOIN ordine o ON c.data = o.data AND c.ora = o.ora
                            WHERE c.mailfatt = ? AND o.stato = 'consegnato'");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $orderCounter = 1; // Initialize the order counter
        while ($row = $result->fetch_assoc()) {
            echo "<div class='order'>";
            echo "<p>Ordine #$orderCounter</p>";
            echo "<p>Data: " . $row["data"] . "</p>";
            $data = $row["data"];
            $ora = $row["ora"];
            echo "<p>Ora: " . $row["ora"] . "</p>";
            echo "<p>Email Acquirente: " . $row["mailacq"] . "</p>";
            echo "<p>Stato: " . $row["stato"] . "</p>";
            echo "<form method='post' action='../backend/modify_order_status.php'>";
            echo "</div>";
            $orderCounter++; // Increment the order counter for the next order
        }
    } else {
        echo "Nessun ordine consegnato.";
    }
} else {
    echo "Utente non loggato";
}
?>