<!DOCTYPE html>
<html>
<head>
    <title>Lista dei Ristoranti</title>
    <link rel="stylesheet" type="text/css" href="../css/stile.css">
    <script src="../js/navbar.js"></script>
</head>
<body>
    
    <div class="header">
    <div class="navbar">
        <li><img src="../images/MainIcon.png" height="40px"></li>
        <a href="../frontend/ordini_acquirente.php">Ordini</a>
        <a href="../frontend/profilo_acquirente.php">Profilo</a>
        <a href="../frontend/modificaprofilo_acquirente.php">Modifica Profilo</a>
        <a href="../common/logout.php">Logout</a>
    </div>
        
        
    <!--   in teoria si può eliminare    
    </div>
    </div>
    
  
    </div>
    </div>
-->

<div class="lista-ristoranti">
    <p>Ecco l'elenco dei ristoranti da cui puoi ordinare</p>


<?php

include("../common/connessione.php");

//aggiungiamo questa parte per la città
// se collegato
session_start();
if (isset($_SESSION['utente'])) {
    $acquirenteEmail = $_SESSION['utente'];
    //echo $acquirenteEmail;

    // recupero la città dell'acquirente
    $cityQuery = "SELECT citta FROM domicilio WHERE mailacq = ?";
    $cityStmt = $conn->prepare($cityQuery);
    $cityStmt->bind_param("s", $acquirenteEmail);
    $cityStmt->execute();
    $cityResult = $cityStmt->get_result();

    if ($cityResult && $cityResult->num_rows > 0) {
        $row = $cityResult->fetch_assoc();
        $acquirenteCity = $row['citta'];


//prendo solo i ristaranti della sua città
$query = "SELECT r.nome 
          FROM ristorante r
          JOIN location l ON r.mail = l.mailrist
          WHERE citta = '$acquirenteCity'";
$res= $conn->query($query);
if (!$res){
echo "<p>Impossibile eseguire query.</p>"
. "<p>Codice errore " . $conn->errno
. ": " . $conn->error . "</p>";
}else{
if ($res->num_rows > 0) {
    // Output dati
    while ($row = $res->fetch_assoc()) {
        $nomeristorante = $row["nome"];
        
        
        echo "<div class='ristorante'>";
        echo "<h3>" .$nomeristorante . "</h3>";
          
        // passo il nome come parametro per vedere poi i suoi piatti
        echo "<a href='elenco_piatti.php?nomeristorante={$nomeristorante}'>Visualizza menu</a>";
    
        echo "</div>";
            }
        } else {
            echo "0 results";
        }
    }
}
}

    // Chiudo connesione
    $conn->close();
    ?>

   
</div>
<?php include("../common/footer.html"); ?>
</body>
</html>
