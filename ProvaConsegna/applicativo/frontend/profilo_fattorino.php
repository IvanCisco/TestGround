<!DOCTYPE html>
<html>
<header>
    <link rel="stylesheet" type="text/css" href="../css/stile.css">
</header>



<?php
include("../common/connessione.php");
session_start();
// Recupero dei dati dell'utente
if(isset($_SESSION['utente'])) {
$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in sessione
?>

<div class="header">
    <div class="navbar">
        <li><img src="../images/MainIcon.png" height="40px"></li>
        <a href="Fattorino.php">Torna indietro</a>
        <a href="profilo_fattorino.php">Profilo</a>
        <a href="modificaprofilo_fattorino.php">Modifica Profilo</a>
        <a href="ordini_acarico.php">Ordini a carico</a>
        <a href="ordini_consegnati.php">Ordini consegnati</a>
        <a href="../common/logout.php">Logout</a>
        </div>
    </div>
<h1>Dati del fattorino</h1>
<section class="page-content">
    <body>
<?php
//select per i dati del fattorino
$stmt = $conn->prepare("SELECT * FROM fattorino WHERE mail = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        echo "<p>Password: " . $row["password"] . "</p>";
         echo "<p>Mail: " . $row["mail"] . "</p>";
        echo "<p>Nome: " . $row["nome"] . "</p>";
        echo "<p>Cognome: " . $row["cognome"] . "</p>";
        echo "<p>Sesso: " . $row["sesso"] . "</p>";
        echo "<p>Data di nascita: " . $row["datanascita"] . "</p>";
        echo "<p>Luogo di nascita: " . $row["luogonascita"] . "</p>";
        echo "<p>Città: " . $row["citta"] . "</p>";
        echo "<p>Disponibilità: " . $row["disponibilita"] . "</p>";
        echo "<p>Credito: " . $row["credito"] . "</p>";
        
    }
}
} else {
    echo "Utente non loggato";
}
//select per la zona in cui ritira il fattorino
$stmt = $conn->prepare("SELECT * FROM operainfatt WHERE mailfatt = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Dati di lavoro</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        echo "<p>Zona: " . $row["zona"] . "</p>";
        }
}else {
    echo "Utente non loggato";
}

//select per i turni del fattorino
$stmt = $conn->prepare("SELECT * FROM flavorasu WHERE mailfatt = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();



if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        echo "<p>Giorno: " . $row["giorno"] . "</p>";
         echo "<p>inizio turno: " . $row["orainizio"] . "</p>";
          echo "<p>fine turno: " . $row["orafine"] . "</p>";
        }
}else {
    echo "Non è stato inserito alcun turno";
}



?>
</section>
</body>
<?php include("../common/footer.html"); ?>

</html>