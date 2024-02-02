<!DOCTYPE html>
<html lang="en">

<head>
  <title>ordini acquirente</title>
    <link rel="stylesheet" type="text/css" href="../css/stile.css">  
    <?php include("../common/footer.html"); ?>
</head>



<body>

    <div class="header">
    <div class="navbar">
        <li><img src="../images/MainIcon.png" height="40px"></li>
        <!--<a href="acquirente.php">Torna indietro</a>-->
       
        <a href="../frontend/profilo_acquirente.php">Profilo</a>
        <a href="../frontend/modificaprofilo_acquirente.php">Modifica Profilo</a>
        <a href="../common/logout.php">Logout</a>
    </div>
    </div>

    <div class="titolo">
         <a href="acquirente.php" class="indietro"><img src="../immagini/back.png" alt="Freccia indietro" class="freccia"></a>
        <h1>I tuoi ordini</h1>
    </div>
<section class="page-content">
<?php
include("../common/connessione.php");
    session_start();
if (isset($_SESSION['utente'])) {
    $mail = $_SESSION['utente'];


$stmt = $conn->prepare( "SELECT data,ora,stato,metodopagamento FROM ordine WHERE mailacq     = ?  ORDER BY data DESC,ora DESC");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();



 if ($result && $result->num_rows > 0) {
    /*
    echo "<h2>I tuoi ordini :</h2>";
            echo "<ul>";*/
    
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
    

    // chiudo connessione
    $conn->close();
}


?>
</section>
</body>

</html>