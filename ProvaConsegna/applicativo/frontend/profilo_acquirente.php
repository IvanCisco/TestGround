<!DOCTYPE html>
<html>
<head>
<title>modificaacq</title>
<link rel="stylesheet" type="text/css" href="../css/stile.css">
<?php include("../common/footer.html"); ?>
</head>
<div class="header">
    <div class="navbar">
        <li><img src="../images/MainIcon.png" height="40px"></li>
        <a href="acquirente.php">Torna indietro</a>
        <a href="../frontend/ordini_acquirente.php">Ordini</a>
        <a href="../frontend/modificaprofilo_acquirente.php">Modifica Profilo</a>
        <a href="../common/logout.php">Logout</a>
    </div>
    </div>


<body>
    <h1>Profilo</h1>
    <section class="page-content">
<?php
include("../common/connessione.php");
session_start();
// Recupero dei dati dell'utente
if(isset($_SESSION['utente'])) {
$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in sessione

//select per i dati di acquirente
$stmt = $conn->prepare("SELECT * FROM acquirente WHERE mail = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        echo "<p>Password: " . $row["password"] . "</p>";
        echo "<p>Nome: " . $row["nome"] . "</p>";
        echo "<p>Cognome: " . $row["cognome"] . "</p>";
        echo "<p>Data di registrazione: " . $row["datareg"] . "</p>";
        echo "<p>telefono: " . $row["telefono"] . "</p>";
        echo "<p>Istruzioni di consegna: " . $row["istruzioni"] . "</p>";
        
    }
}
} else {
    echo "Utente non loggato";
}
//select per l'indirizzo di acquirente
$stmt = $conn->prepare("SELECT * FROM domicilio WHERE mailacq = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        echo "<p>via: " . $row["via"] . "</p>";
        echo "<p>numero: " . $row["numero"] . "</p>";
        echo "<p>cap: " . $row["cap"] . "</p>";
        echo "<p>città: " . $row["citta"] . "</p>";
        
        
    }
}else {
    echo "Utente non loggato";
}



?>
</section>
</body>
</html>