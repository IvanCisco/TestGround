<!DOCTYPE html>
<html>
<head>
<script src="../js/javascript.js"></script>
</head>
<?php
	include("../common/connessione.php");
	include("../common/funzioni.php");
	session_start();
	// Recupero dei dati dell'utente
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in session
	$query=mysqli_query($conn,"select * from `fattorino` where mail='$mail'");
	$row=mysqli_fetch_array($query);
	
 
	$nome=$_POST['nome'];
	$cognome=$_POST['cognome'];
	$password=$_POST['password'];
	$sesso=$_POST['sesso'];
	$datanascita=$_POST['datanascita'];
	$luogonascita=$_POST['luogonascita'];
	$citta=$_POST['citta'];
	$disponibilita=$_POST['disponibilita'];

	$giorni = isset($_POST["giorno"]) ? $_POST["giorno"] : array();
    $orariInizio = isset($_POST["orainizio"]) ? $_POST["orainizio"] : array();
    $orariFine = isset($_POST["orafine"]) ? $_POST["orafine"] : array();
 
	mysqli_query($conn,"update `fattorino` set 
		nome='$nome',
		cognome='$cognome',
		password='$password',
		sesso='$sesso',
		datanascita='$datanascita',
		luogonascita = '$luogonascita',
		citta = '$citta',
		disponibilita = '$disponibilita'
		where mail='$mail'");
	
	if (inserisciOrari($giorni, $orariInizio, $orariFine, $mail, $conn, "flavorasu")) {
    echo "Modifica avvenuta con successo, verrai reindirizzato alla home page";
    ?>
    <script>
        redirectdelay(5000, '../frontend/fattorino.php');//delay di 5 secondi post avvenuta registrazione
    </script>
    <?php
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
	}
?>
</html>