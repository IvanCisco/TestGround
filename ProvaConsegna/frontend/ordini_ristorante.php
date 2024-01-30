<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Menu del Ristorante</title>
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <p><a href="ristorante.php">Torna indietro</a></p>
        <?php
        include("../common/connessione.php");
        session_start();

        if (isset($_SESSION['utente'])) {
            $mail = $_SESSION['utente'];

            //QUERY CON IL JOIN
            $query = "SELECT c.nome, c.data, c.ora
                FROM contiene c
                JOIN ordine o ON c.data = o.data AND c.ora = o.ora
                WHERE c.mail = ? 
                AND o.stato = 'in preparazione' or o.stato ='preso in carico'
                AND TIMESTAMPDIFF(HOUR, CONCAT(c.data, ' ', c.ora), NOW()) < 2";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                // Loop date e ore
                while ($row = $result->fetch_assoc()) {
                    $data = $row['data'];
                    $ora = $row['ora'];

                    // Visualizza informazioni ordine
                    echo "<div class='order'>";
                    echo "<p>Data: $data, Ora: $ora</p>";

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
                    // Bottone
                    echo "<form method='post' action='../backend/modify_order_status.php'>";
                    echo "<input type='hidden' name='data' value='$data'>";
                    echo "<input type='hidden' name='ora' value='$ora'>";
                    echo "<input type='submit' name='modifyOrderStatus' value='Consegnato al fattorino'>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "Nessun ordine, verrai reindirizzato alla home.";
                //header ("location:http://localhost/SITO_NOVEMBRE2023/Ristorante.php?status=ok&msg=Login+effettuato+con+successo")
                header("refresh:5;url=../frontend/Ristorante.php");
            }
        }
        ?>
    </body>
</html>