<!DOCTYPE html>
<html>
<head>
    <title>Lista dei Ristoranti</title>
    <link rel="stylesheet" type="text/css" href="../css/stile.css">
    <script src="../js/navbar.js"></script>
</head>
<body>
    
    <?php include("../common/navbar_acquirente.php"); ?>
   
    <h1>Elenco Ristoranti</h1>
  
     
<section class="page-content">
    <!--   in teoria si può eliminare    
    </div>
    </div>
    
  
    </div>
    </div>
-->


    

<?php

include("../common/connessione.php");

//aggiungiamo questa parte per la città
// se collegato
session_start();
if (isset($_SESSION['utente'])) {
    $acquirenteEmail = $_SESSION['utente'];
    //echo $acquirenteEmail;

    // recupero la città dell'acquirente
    /*
    $cityQuery = "SELECT citta FROM domicilio WHERE mailacq = ?";
    $cityStmt = $conn->prepare($cityQuery);
    $cityStmt->bind_param("s", $acquirenteEmail);
    $cityStmt->execute();
    $cityResult = $cityStmt->get_result();

    if ($cityResult && $cityResult->num_rows > 0) {
        $row = $cityResult->fetch_assoc();
        $acquirenteCity = $row['citta'];
        */
        //RECUPER LA CITTA DELL'ACQUIRENTE
        $query = "SELECT i.citta 
          FROM acquirente AS a
          JOIN indirizzo AS i ON a.domicilio = i.id
          WHERE a.mail = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $acquirenteEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ora puoi estrarre la città dal risultato
        if ($row = $result->fetch_assoc()) {
            $acquirenteCity = $row['citta'];
            // Fai qualcosa con $citta
        } else {
            echo "Errore non è stato possibile recuperare la città dell'acquirente ";
        }

//prendo solo i ristaranti della sua città
        /*
$query = "SELECT r.nome 
          FROM ristorante r
          JOIN location l ON r.mail = l.mailrist
          WHERE citta = '$acquirenteCity'";
          */
          //QUESTA QUERY FUNZIONA PERò MI SERVE ALTRO 
          /*
          $query = "SELECT r.nome 
          FROM ristorante r
          JOIN indirizzo i ON r.location = i.id
          WHERE i.citta = '$acquirenteCity'";
          */

          // Imposta la localizzazione in italiano
          date_default_timezone_set("Europe/Rome");
          $dataOdiernaING = date("l");
          $iNGToITA = array(
              'Monday' => 'Lunedì',
              'Tuesday' => 'Martedì',
              'Wednesday' => 'Mercoledì',
              'Thursday' => 'Giovedì',
              'Friday' => 'Venerdì',
              'Saturday' => 'Sabato',
              'Sunday' => 'Domenica'
          );
  
          $giornoCorrente = $iNGToITA[$dataOdiernaING];
// Recupera l'ora corrente
$oraCorrente = date("H:i:s"); // "H:i:s" restituisce l'ora in formato 24 ore con i minuti e i secondi

// Esegui una query per ottenere i ristoranti aperti in quel giorno e in quell'orario
$query = "SELECT r.nome 
          FROM ristorante r
          JOIN indirizzo i ON r.location = i.id
          JOIN rlavorasu rl ON r.mail = rl.mail
          JOIN turno t ON rl.turno = t.id
          WHERE i.citta = '$acquirenteCity'
          AND t.giorno = '$giornoCorrente'
          AND '$oraCorrente' BETWEEN t.orainizio AND t.orafine";


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
            echo "nessun ristorante aperto in questo momento";
        }
    }
}


    // Chiudo connesione
    $conn->close();
    ?>

   

</section>
<?php include("../common/footer.html"); ?>
</body>
</html>
