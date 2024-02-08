<!DOCTYPE html>
<html>
	<head>
		<script src="../js/javascript.js"></script>
	</head>
	<?php
	include("../common/connessione.php");
	session_start();
	// Recupero dei dati dell'utente
	if(isset($_SESSION['utente'])) {
		$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in session
		$query=mysqli_query($conn,"select * from `acquirente` where mail='$mail'");
		$row=mysqli_fetch_array($query);
	
 
		$nome=$_POST['nome'];
		$cognome=$_POST['cognome'];
		$password=$_POST['password'];
		$telefono=$_POST['telefono'];
		$istruzioni=$_POST['istruzioni'];
 
		mysqli_query($conn,"update `acquirente` set 
		nome='$nome',
		cognome='$cognome',
		password='$password',
		telefono='$telefono',
		istruzioni='$istruzioni'
		where mail='$mail'");

		$query=mysqli_query($conn,"select * from `domicilio` where mailacq='$mail'");
		$row=mysqli_fetch_array($query);
	
 
		$via=$_POST['via'];
		$numero=$_POST['numero'];
		$cap=$_POST['cap'];
		$citta=$_POST['citta'];

		$query=mysqli_query($conn,"select * from `domicilio` where via='$via' and numero='$numero' and cap='$cap' and citta='$citta'");
		$row=mysqli_fetch_array($query);
 
		mysqli_query($conn,"update `domicilio` set 
		via='$via',
		numero='$numero',
		cap='$cap',
		citta='$citta'
		where mailacq='$mail'");
	    echo "Modifica avvenuta con successo, verrai reindirizzato alla pagina acquirente";
    ?>
    <script>
        redirectdelay(5000, '../frontend/acquirente.php');//delay di 5 secondi post avvenuta registrazione
    </script>
    <?php
	} else {
    	echo "Error: " . $query . "<br>" . $conn->error;
	}
	?>
</html>