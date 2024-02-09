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
<h1>Ordini presi a carico</h1>
<body>
    <section class="page-content">


<?php
// RECUPERO DATI ORDINE preso a carico io fattorino sto andando a recuperarlo, in consegna il ristorante ha confermato il mio ritiro
$stmt = $conn->prepare("SELECT c.data, c.ora, o.mailacq, o.stato, i.via, i.numero
                            FROM consegna c
                            JOIN ordine o ON c.data = o.data AND c.ora = o.ora
                            /*JOIN domicilio d on o.mailacq = d.mailacq*/
                            JOIN acquirente a on a.mail = o.mailacq
                            JOIN indirizzo i on i.id = a.domicilio
                            WHERE c.mailfatt = ? AND o.stato='preso in carico' or o.stato = 'in consegna'");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $contatoreOrdine = 1; // 
        while ($row = $result->fetch_assoc()) {
            echo "<div class='order'>";
            echo "<p>Ordine #$contatoreOrdine</p>";
            echo "<p>Data: " . $row["data"] . "</p>";
            $data = $row["data"];
            $ora = $row["ora"];
            echo "<p>Ora: " . $row["ora"] . "</p>";
            echo "<p>Email Acquirente: " . $row["mailacq"] . "</p>";
            echo "<p>Via: " . $row["via"] . "</p>";
            echo "<p>Numero civico: " . $row["numero"] . "</p>";
            echo "<p>Stato: " . $row["stato"] . "</p>";
            echo "<form method='post' action='../backend/modify_order_status.php'>";
        echo "<input type='hidden' name='data' value='$data'>";
        echo "<input type='hidden' name='ora' value='$ora'>";
        if ($row['stato']=='in consegna' or $row['stato']=='preso in carico'){
        echo "<input type='submit' name='modifyOrderStatus' value='Consegnato'>";}
        echo "</form>";
            echo "</div>";
            $contatoreOrdine++;
        }
    } else {
        echo "Nessun ordine preso a carico.";
    }
} else {
    echo "Utente non loggato";
}
?>
</section>
</body>
<?php include("../common/footer.html"); ?>
</html>