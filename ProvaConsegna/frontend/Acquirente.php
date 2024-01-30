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
            <div class="menu-toggle" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="menu-items" id="menuItems">
                <a href="../frontend/ordini_acquirente.php">Ordini</a>
                <a href="../frontend/profilo_acquirente.php">Profilo</a>
                <a href="../frontend/modificaprofilo_acquirente.php">Modifica Profilo</a>
                <a href="../common/logout.php">Logout</a>
            </div>
        
        
            <div class="welcome-user">
            
            <?php
                session_start();
                if (isset($_SESSION['utente'])) {
                    echo 'Benvenuto ' . $_SESSION['utente'];
                    //echo 'il tuo tipo è ' . $_SESSION['tipo'] ;// Stampa il nome dell'utente
                }
            ?>
        

            </div>
    </div>
    </div>
    
  
    </div>
    </div>

<div class="lista-ristoranti">
    <p>Ecco l'elenco dei ristoranti da cui puoi ordinare</p>


<?php

include("../common/connessione.php");

//aggiungiamo questa parte per la città
// Check if the acquirente is logged in
if (isset($_SESSION['utente'])) {
    $acquirenteEmail = $_SESSION['utente'];

    // Retrieve the city of the acquirente
    $cityQuery = "SELECT citta FROM domicilio WHERE mailacq = ?";
    $cityStmt = $conn->prepare($cityQuery);
    $cityStmt->bind_param("s", $acquirenteEmail);
    $cityStmt->execute();
    $cityResult = $cityStmt->get_result();

    if ($cityResult && $cityResult->num_rows > 0) {
        $row = $cityResult->fetch_assoc();
        $acquirenteCity = $row['citta'];



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
    // Output data of each row
    while ($row = $res->fetch_assoc()) {
        $nomeristorante = $row["nome"];
        
        // Convert restaurant name to lowercase and remove spaces to create the file name
        $filename = strtolower(str_replace(' ', '', $nomeristorante)) . ".php";
        echo "<div class='ristorante'>";
        echo "<h3>" .$nomeristorante . "</h3>";
        //echo "<p>Descrizione del ristorante.</p>"; // You can fetch and display description from the database too
        //echo "<a href=" . $filename . "'>Visualizza il menu</a>";
        //echo "<a href = elenco_piatti.php>Visualizza il menu</a>";  
        // Pass the restaurant name as a parameter to the menu page
        echo "<a href='elenco_piatti.php?nomeristorante={$nomeristorante}'>Visualizza menu</a>";
    
        echo "</div>";
            }
        } else {
            echo "0 results";
        }
    }
}
}

    // Close connection
    $conn->close();
    ?>

   <!-- <p><a href="carrello.html">Visualizza il carrello</a></p>-->
</div>

</body>
</html>
