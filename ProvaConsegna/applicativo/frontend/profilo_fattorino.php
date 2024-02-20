<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/stile.css">
</head>



<?php
include("../common/connessione.php");
session_start();
// Recupero dei dati dell'utente
if(isset($_SESSION['utente'])) {
$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in sessione
?>

<?php include("../common/navbar_fattorino.php"); ?>

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
    header("Location: ../index.html");
}
//select per la zona in cui ritira il fattorino
$stmt = $conn->prepare("SELECT * FROM operainfatt WHERE mail = ?");
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
    header("Location: ../index.html");
}

$tabella = "flavorasu";
include("../backend/visualizza_orari.php");



?>
</section>
</body>
<?php include("../common/footer.html"); ?>

</html>