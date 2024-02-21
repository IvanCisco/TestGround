
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Menu del Ristorante</title>
    <script src="../js/javascript.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/stile.css">
</head>
<body>
<?php include("../common/navbar_ristorante.php"); ?>

<h1>Ordini Ristorante</h1>
<section class="page-content">
    <?php
    include("../common/connessione.php");
    session_start();

    if (isset($_SESSION['utente'])) {
        $mail = $_SESSION['utente'];

        //QUERY che seleziona cosa contengono gli ordini
        $query = "SELECT c.nome, c.data, c.ora, o.stato
                FROM contiene c
                JOIN ordine o ON c.data = o.data AND c.ora = o.ora
                WHERE c.mail = ? 
                AND (o.stato = 'in preparazione' OR o.stato ='preso in carico')
                AND TIMESTAMPDIFF(HOUR, CONCAT(c.data, ' ', c.ora), NOW()) < 2
                ORDER BY c.data, c.ora";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // se ci sono ordini recupero questi dati
            $orders = []; // Array per memorizzare tutti gli ordini
            while ($row = $result->fetch_assoc()) {
                $data = $row['data'];
                $ora = $row['ora'];
                $stato = $row['stato'];
                $nomePiatto = $row['nome']; // Aggiunto il nome del piatto
                
                // Aggiungi l'articolo all'ordine corrispondente o crea un nuovo ordine
                $orderKey = "$data-$ora";
                if (!isset($orders[$orderKey])) {
                    $orders[$orderKey] = [
                        'data' => $data,
                        'ora' => $ora,
                        'stato' => $stato,
                        'piatti' => [] // Inizializza l'array dei piatti per questo ordine
                    ];
                }
                // Aggiungi il piatto all'ordine corrente
                $orders[$orderKey]['piatti'][] = $nomePiatto;
            }

            // Stampare ciascun ordine
            foreach ($orders as $order) {
                echo "<div class='order'>";
                echo "<p><strong>Ordine - Data: {$order['data']}, Ora: {$order['ora']}</strong></p>";
                echo "<p>Stato: {$order['stato']}</p>";
                echo "<div class='menu-items'>"; // Apri il div per la lista degli articoli
                foreach ($order['piatti'] as $piatto) {
                    echo "<div class='menu-item'>";
                    echo "<p>$piatto</p>";
                    echo "</div>";
                }
                // Bottone per confermare il ritiro del fattorino solo se l'ordine è stato preso in carico
                if ($order['stato'] == 'preso in carico') {
                    echo "<form method='post' action='../backend/modify_order_status.php'>";
                    echo "<input type='hidden' name='data' value='{$order['data']}'>";
                    echo "<input type='hidden' name='ora' value='{$order['ora']}'>";
                    echo "<input type='submit' name='modifyOrderStatus' value='Consegnato al fattorino'>";
                    echo "</form>";
                }
                echo "</div>"; // Chiudi il div 'menu-items'
                echo "</div>"; // Chiudi il div 'order'
            }
        } else {
            echo "<p class=\"error\">Nessun ordine ricevuto.</p>";
        }
    }
    ?>
</section>
<?php include("../common/footer.html"); ?>
</body>
</html>
