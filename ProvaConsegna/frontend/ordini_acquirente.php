<!DOCTYPE html>
<html lang="en">

<head>
    
</head>

<body>
<p><a href="acquirente.php">Torna indietro</a></p>

<?php
include("../common/connessione.php");
    session_start();
if (isset($_SESSION['utente'])) {
    $mail = $_SESSION['utente'];


$stmt = $conn->prepare( "SELECT data,ora,stato,metodopagamento FROM ordine WHERE mailacq	 = ?  ORDER BY data DESC,ora DESC");
	$stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();



 if ($result && $result->num_rows > 0) {
    echo "<h2>I tuoi ordini :</h2>";
            echo "<ul>";
    
	// per ogni riga
    while ($row = $result->fetch_assoc()) {


        $data = $row["data"];
        $ora = $row["ora"];
        $stato = $row["stato"];
        $metodopagamento = $row["metodopagamento"];

        echo "<li><b>Data:</b> $data | <b>Ora:</b> $ora | <b>Stato:</b> $stato | <b>Metodo Pagamento:</b> $metodopagamento</li>";
        }
    
        echo "</ul>";
            
        } else {
            echo "Attualmente non è stato effettuato alcun ordine";
        }
    

    // Close connection
    $conn->close();
}


?>
</body>

</html>