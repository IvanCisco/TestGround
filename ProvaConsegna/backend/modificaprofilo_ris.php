<!DOCTYPE html>
<html>
<head>
<script src="../js/javascript.js"></script>
</head>
<?php
	include '../common/connessione_database_base.php';
	include("../common/funzioni.php");
	session_start();
	// Recupero dei dati dell'utente
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in session
	$query=mysqli_query($conn,"select * from `ristorante` where mail='$mail'");
	$row=mysqli_fetch_array($query);
	
 
	$nome=$_POST['nome'];
	$ragione_sociale=$_POST['ragsoc'];
	$password=$_POST['password'];
	$partitaiva=$_POST['partitaiva'];
	
 
	mysqli_query($conn,"update `ristorante` set 
		nome='$nome',
		password='$password',
		ragsoc='$ragione_sociale',
		partitaiva='$partitaiva'
		where mail='$mail'");
	//header('location:modificaprofilo_acquirente.php');

	$query=mysqli_query($conn,"select * from `operainrist` where mailrist='$mail'");
	$row=mysqli_fetch_array($query);
	
 
	$zona=$_POST['zona'];

	mysqli_query($conn,"update `operainrist` set 
		zona='$zona'");

		/*
	$query=mysqli_query($conn,"select * from `sedelegale` where via='$via' and numero='$numero' and cap='$cap' and citta='$citta'");
	$row=mysqli_fetch_array($query);
	*/
	$query=mysqli_query($conn,"select * from `location` where mailrist='$mail'");
	$rowlocation=mysqli_fetch_array($query);

	$via_location=$_POST['via_location'];
	$numero_location=$_POST['numero_location'];
	$cap_location=$_POST['cap_location'];
	$citta_location=$_POST['citta_location'];
 
	mysqli_query($conn,"update `location` set 
		via='$via_location',
		numero='$numero_location',
		cap='$cap_location',
		citta='$citta_location'
		where mailrist='$mail'");

	$query=mysqli_query($conn,"select * from `sedelegale` where mailrist='$mail'");
	$rowsedelegale=mysqli_fetch_array($query);
	
 
	$via_sedelegale=$_POST['via_sedelegale'];
	$numero_sedelegale=$_POST['numero_sedelegale'];
	$cap_sedelegale=$_POST['cap_sedelegale'];
	$citta_sedelegale=$_POST['citta_sedelegale'];

 
	mysqli_query($conn,"update `sedelegale` set 
		via='$via_sedelegale',
		numero='$numero_sedelegale',
		cap='$cap_sedelegale',
		citta='$citta_sedelegale'
		where mailrist='$mail'");

	
	$giorni = isset($_POST["giorno"]) ? $_POST["giorno"] : array();
	$orariInizio = isset($_POST["orainizio"]) ? $_POST["orainizio"] : array();
	$orariFine = isset($_POST["orafine"]) ? $_POST["orafine"] : array();

	if ((inserisciOrari($giorni, $orariInizio, $orariFine, $mail, $conn, "rlavorasu"))) {
    echo "Modifica avvenuta con successo, verrai reindirizzato alla pagina ristorante";
    ?>
    <script>
        redirectdelay(5000, '../frontend/ristorante.php');//delay di 5 secondi post avvenuta registrazione
    </script>
    <?php
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
	}
?>
</html>