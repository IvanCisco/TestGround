<!DOCTYPE html>
<html>




<?php
include("../common/connessione.php");
session_start();
// Recupero dei dati dell'utente
if(isset($_SESSION['utente'])) {
$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in sessione
?>
<p><a href="Fattorino.php">Torna indietro</a></p>
<h2>Dati del fattorino</h2>

<?php
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
        echo "<p>Città: " . $row["citta"] . "</p>";
        echo "<p>Disponibilità: " . $row["disponibilita"] . "</p>";
        echo "<p>Credito: " . $row["credito"] . "</p>";
        
    }
}
} else {
    echo "Utente non loggato";
}

$stmt = $conn->prepare("SELECT * FROM operainfatt WHERE mailfatt = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Dati di lavoro</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        echo "<p>Zona: " . $row["numero"] . "</p>";
        }
}else {
    echo "Utente non loggato";
}


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
    echo "Utente non loggato";
}



?>

</html>