<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../css/stile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../js/navbar.js"></script>
    <script src="../js/javascript.js"></script>
    <!-- Aggiungi questo codice dove desideri visualizzare il pulsante di logout 
<form action="common/logout.php" method="post">
    <button type="submit">Logout</button>
</form>
-->
</head>
<body>
    
    
    
    <div class="navbar">
            <div class="menu-toggle" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="menu-items" id="menuItems">
                <a href="profilo_fattorino.php">Profilo</a>
                <a href="modificaprofilo_fattorino.php">Modifica Profilo</a>
                <a href="ordini_acarico.php">Ordini a carico</a>
                <a href="ordini_consegnati.php">Ordini consegnati</a>
                <a href="../common/logout.php">Logout</a>
            </div>
            <div class="welcome-user">
            
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

    <h2>ordini disponibili nella tua zona</h2>
<?php
/*
opera in fatt ha dentro mail fattorino e zona
mentre la città è in fattorino 

opera in rist ha mail e numrto zona
mail rist si collega a location da cui posso prendere la zona e città
*/
// include database connection
include("../common/connessione.php");
//session_start();

// check if fattorino is logged in
if (isset($_SESSION['utente'])) {
    $mail = $_SESSION['utente'];

    // retrieve other details of the fattorino
    $querycittaFattorino = "SELECT citta FROM fattorino WHERE mail = ?";
    $stmtFattorino = $conn->prepare($querycittaFattorino);
    $stmtFattorino->bind_param("s", $mail);
    $stmtFattorino->execute();
    $resultcittaFattorino = $stmtFattorino->get_result();

    $queryareaFattorino = "SELECT numero FROM operainfatt WHERE mailfatt = ?";
    $stmtFattorino = $conn->prepare($queryareaFattorino);
    $stmtFattorino->bind_param("s", $mail);
    $stmtFattorino->execute();
    $resultareaFattorino = $stmtFattorino->get_result();

    if ($resultcittaFattorino && $resultcittaFattorino->num_rows > 0) {
        $row = $resultcittaFattorino->fetch_assoc();
        $city_where_fattorino_works = $row['citta'];
    if ($resultareaFattorino && $resultareaFattorino->num_rows > 0) {
        $row = $resultareaFattorino->fetch_assoc();
        $area_where_fattorino_delivers = $row['numero'];
        // Add any other details you might need

        //Debugging output
        //echo "City where fattorino works: $city_where_fattorino_works<br>";
        //echo "Area where fattorino delivers: $area_where_fattorino_delivers<br>";


  $query = "
SELECT o.data, o.ora, o.stato, r.nome AS nome_ristorante
FROM ordine o
JOIN contiene c ON o.data = c.data AND o.ora = c.ora
JOIN operainrist oi ON c.mail = oi.mailrist
JOIN operainfatt of ON oi.zona = of.numero
JOIN fattorino f ON of.mailfatt = f.mail
JOIN ristorante r ON oi.mailrist = r.mail
WHERE f.mail = ? 
  AND f.citta = ? 
  
  AND oi.zona = ?
 /* AND f.citta = of.citta -- Check if fattorino works in the same city as the restaurant*/
  AND oi.zona = of.numero -- Check if fattorino delivers in the same area as the restaurant
  AND o.stato in('in preparazione','preso in carico')
  AND TIMESTAMPDIFF(HOUR, CONCAT(o.data, ' ', o.ora), NOW()) < 2";


$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $mail, $city_where_fattorino_works, $area_where_fattorino_delivers);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        //$nome = $row['nome'];
        $data = $row['data'];
        $ora = $row['ora'];
        $stato = $row['stato'];
        $nomeRistorante = $row['nome_ristorante'];

        echo "<div class='order'>";
        /*echo "<p>Nome: $nome, Data: $data, Ora: $ora, Stato: $stato</p>";*/
        echo "<p> Data: $data, Ora: $ora, Stato: $stato, Ristorante: $nomeRistorante</p>";

        // Add a button to modify the stato in ordine se è libero
        if ($row["stato"] == 'in preparazione') {
        echo "<form method='post' action='../backend/modify_order_status.php'>";
        echo "<input type='hidden' name='data' value='$data'>";
        echo "<input type='hidden' name='ora' value='$ora'>";
        echo "<input type='submit' name='modifyOrderStatus' value='Prendi in carico'>";
        echo "</form>";

        echo "</div>";
    }
}
} else {
    echo "No orders found.";
    //echo "sbagliato";
}

$stmt->close();
$conn->close();
}
}
}

?>
