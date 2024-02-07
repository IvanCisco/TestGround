<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Menu del Ristorante</title>
        <script src="../js/javascript.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
    </head>
    <body>
        <div class="header">
        <div class="navbar">
            <li><img src="../images/MainIcon.png" height="40px"></li>
                <a href="ristorante.php">Torna indietro</a>
                <a href="modificaprofilo_ristorante.php">Modifica Profilo</a>
                <a href="crea_menu.php">Crea menu</a>
                <a href="ordini_ristorante.php">Ordini</a>
                <a href="../common/logout.php">Logout</a>
            </div>
        </div>
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
                AND o.stato = 'in preparazione' or o.stato ='preso in carico'
                AND TIMESTAMPDIFF(HOUR, CONCAT(c.data, ' ', c.ora), NOW()) < 2
                ORDER BY c.data, c.ora";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            $count = 1;
            if ($result && $result->num_rows > 0) {
                // se ci sono ordini recupero questi dati
                while ($row = $result->fetch_assoc()) {
                    $data = $row['data'];
                    $ora = $row['ora'];
                    $stato = $row['stato'];

                    // Visualizza informazioni ordine
                    echo "<div class='order'>";
                    echo "<p><strong>Ordine $count</strong> - Data: $data, Ora: $ora</p>";

                    $count++;
                    // Query per gli ordini attuali
            
                    $queryItems = "SELECT nome FROM contiene WHERE mail = ? AND data = ? AND ora = ?";
                    $stmtItems = $conn->prepare($queryItems);
                    $stmtItems->bind_param("sss", $mail, $data, $ora);
                    $stmtItems->execute();
                    $resultItems = $stmtItems->get_result();

            
                    //Visualizza nomi piatti per l'ordine corrente
                    while ($rowItem = $resultItems->fetch_assoc()) {
                        echo "<div class='menu-item'>";
                        echo "<p> {$rowItem['nome']}</p>";
                        echo "</div>";
                    }
                    // Bottone per confermare il ritiro del fattorino solo se è stato preso in carico
                    if ($stato == 'preso in carico') {
                    echo "<form method='post' action='../backend/modify_order_status.php'>";
                    echo "<input type='hidden' name='data' value='$data'>";
                    echo "<input type='hidden' name='ora' value='$ora'>";
                    echo "<input type='submit' name='modifyOrderStatus' value='Consegnato al fattorino'>";
                    echo "</form>";
                }
                    echo "<div>Stato: $stato</div>";
                    echo "</div>";
                }
            } else {
                echo "Nessun ordine, verrai reindirizzato alla home.";
                header("refresh:5;url=../frontend/Ristorante.php");
            }
        }
        ?>
    </body>
</html>