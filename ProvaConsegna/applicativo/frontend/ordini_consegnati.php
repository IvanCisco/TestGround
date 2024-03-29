<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Ordini a carico</title>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
    </head>


<?php
include("../common/connessione.php");
session_start();
// Recupero dei dati dell'utente
if(isset($_SESSION['utente'])) {
$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in sessione
?>
<?php include("../common/navbar_fattorino.php"); ?>
<h1>Ordini consegnati</h1>

<body>
    <section class="page-content">

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
        $orderCounter = 1; // starto un contatore così stampo "ordine n"
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
            $orderCounter++; // incremento il contatore 
        }
    } else {
        echo "<p class=\"error\">Nessun ordine consegnato.</p>";
    }
} else {
    header("Location: ../index.html");
}
?>
</section>
</body>
<?php include("../common/footer.html"); ?>
</html>