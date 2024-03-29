<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
</head>
<body>
    <section class="page-content">
<?php


include("../common/connessione.php");
session_start();

if (isset($_POST['modifyOrderStatus'])) {
    $data = $_POST['data'];
    $ora = $_POST['ora'];

    if (isset($_SESSION['utente'])) {
        $mail = $_SESSION['utente'];
        $tipo = $_SESSION['tipo'];

        // Aggiorna lo stato dell'ordine

        $currentStatusQuery = "SELECT stato FROM ordine WHERE data = ? AND ora = ?";
        $currentStatusStmt = $conn->prepare($currentStatusQuery);
        $currentStatusStmt->bind_param("ss", $data, $ora);
        $currentStatusStmt->execute();
        $currentStatusResult = $currentStatusStmt->get_result();

        if ($currentStatusResult && $currentStatusResult->num_rows > 0) {
            $row = $currentStatusResult->fetch_assoc();
            $currentStatus = $row['stato'];

            if ($tipo == 'ristorante') {
                $newStato = "in consegna";
            } elseif ($tipo == 'fattorino') {
                if ($currentStatus == 'in preparazione') {
                    $newStato = "preso in carico";
                    include("assegna_ordine_fattorino.php"); // Gestione assegnamento a fattorino
                } elseif ($currentStatus == 'in consegna') {
                    $newStato = 'consegnato';
                    $prezzototale_query = "SELECT SUM(pietanza.prezzo) AS prezzo_totale
                    FROM ordine
                    JOIN consegna ON ordine.data = consegna.data AND ordine.ora = consegna.ora
                    JOIN contiene ON ordine.data = contiene.data AND ordine.ora = contiene.ora
                    JOIN pietanza ON contiene.nome = pietanza.nome AND contiene.mail =pietanza.mail
                    WHERE ordine.data= ? AND ordine.ora=? AND consegna.mailfatt =?";
    
                    $prezzototale_stmt = $conn->prepare($prezzototale_query);
                    if ($prezzototale_stmt === false) {
                        echo "<p class =\"error\">Errore nella preparazione dell'istruzione SQL per ottenere il prezzo totale: </p> " . $conn->error;
                        echo "<p class =\"error\">verrai reindirizzato alla home</p>";
                    } else {
                        $prezzototale_stmt->bind_param("sss", $data, $ora, $mail);
                        $prezzototale_stmt->execute();
                        $prezzototale_result = $prezzototale_stmt->get_result();

                        if ($prezzototale_result === false) {
                            echo "<p class =\"error\">Errore nell'esecuzione della query per ottenere il prezzo totale: </p>" . $conn->error;
                            echo "<p class =\"error\">verrai reindirizzato alla home</p>";
                             header("refresh:5;url=../frontend/fattorino.php");
                        } else {
                            $totalPriceRow = $prezzototale_result->fetch_assoc();
                            $totalPrice = $totalPriceRow['prezzo_totale'];
                            // Calcola il 10% 
                            $credit = $totalPrice * 0.1;
                            // Aggiorna credito
                            $updateCreditQuery = "UPDATE fattorino SET credito = credito + ? WHERE mail = ?";
                            $updateCreditStmt = $conn->prepare($updateCreditQuery);

                            if ($updateCreditStmt === false) {
                                echo "<p class =\"error\">Errore nella preparazione dell'istruzione SQL per aggiornare il credito del fattorino: </p>" . $conn->error;
                                echo "<p class =\"error\">verrai reindirizzato alla home</p>";
                                 header("refresh:5;url=../frontend/fattorino.php");
                            } else {
                                $updateCreditStmt->bind_param("ds", $credit, $mail);
                                $updateCreditStmt->execute();
                                $updateCreditStmt->close();
                            }
                        }
                    }
                } else {
                    $newStato = "";
                }
            }
            if (!empty($newStato)) {
                $query = "UPDATE ordine SET stato = ? WHERE data = ? AND ora = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $newStato, $data, $ora);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "<p class =\"success\">La modifica allo stato dell'ordine è avvenuta con successo, verrai reindirizzato. </p>";
                    echo "<p class =\"success\">verrai reindirizzato</p>";
                    // Reindirizzamento in base al tipo
                    if ($tipo == 'ristorante') {
                        header("refresh:5;url=../frontend/ordini_ristorante.php");
                    } elseif ($tipo == 'fattorino') {
                        header("refresh:5;url=../frontend/fattorino.php");
                    } else {
                        echo "<p class =\"error\">errore di reindirizzamento</p>";
                        header("refresh:5;url=../common/logout.php");
                    }
                } else {
                    echo "<p class =\"error\">Errore: Stato non modificato.</p>";
                    echo "<p class =\"error\">verrai reindirizzato alla home</p>";
                    header("refresh:5;url=../frontend/ordini_ristorante.php");
                }
                $stmt->close();
            } else {
                if ($tipo == 'ristorante') {
                    echo "<p class =\"error\">Errore: Tipo utente o stato corrente non valido.</p>";
                    echo "<p class =\"error\">verrai reindirizzato</p>";
                    header("refresh:5;url=../frontend/ordini_ristorante.php");
                } elseif ($tipo == 'fattorino') {
                    echo "<p class =\"error\">Errore: il ristorante deve confermare il ritiro</p>";
                    echo "<p class =\"error\">verrai reindirizzato alla home</p>";
                    header("refresh:5;url=../frontend/fattorino.php");
                }
            }
        } else {
            if ($tipo == 'ristorante') {
                echo "<p class=\"error\">Errore: Utente non loggato o richiesta non valida.</p>";
                echo "<p class =\"error\">verrai reindirizzato </p>";
                header("refresh:5;url=../frontend/ordini_ristorante.php");
            } elseif ($tipo == 'fattorino') {
                echo "<p class=\"error\">Errore: Utente non loggato o richiesta non valida.</p>";
                echo "<p class =\"error\">verrai reindirizzato alla home</p>";
                header("refresh:5;url=../frontend/fattorino.php");
            }
        }
    } else {
        if ($tipo == 'ristorante') {
            echo "<p class =\"error\">Errore: Richiesta non valida.</p>";
            echo "<p class =\"error\">verrai reindirizzato</p>";
            header("refresh:5;url=../frontend/ordini_ristorante.php");
        } elseif ($tipo == 'fattorino') {
            echo "<p class=\"error\">Errore: Richiesta non valida.</p>";
            echo "<p class =\"error\">verrai reindirizzato alla home</p>";
            header("refresh:5;url=../frontend/fattorino.php");
        }
    }
} else {
    echo "modifyOrderStatus non è settato!";
}
?>
</section>
</body>
</html>