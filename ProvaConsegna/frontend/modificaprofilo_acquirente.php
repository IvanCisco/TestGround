<!DOCTYPE html>
<?php
	include("../common/connessione.php");
	session_start();
	// Recupero dei dati dell'utente
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in session
	$query=mysqli_query($conn,"select * from `acquirente` where mail='$mail'");
	$row=mysqli_fetch_array($query);
}
?>

<html>
<script src="js/javascript.js"></script>
<head>
<title>modificaacq</title>
<link rel="stylesheet" type="text/css" href="../css/stile.css">
</head>
<body>
	


	<div class="navbar">
        <li><img src="../images/MainIcon.png" height="40px"></li>
        <a href="acquirente.php">Torna indietro</a>
        <a href="../frontend/ordini_acquirente.php">Ordini</a>
        <a href="../frontend/profilo_acquirente.php">Profilo</a>
        <a href="../common/logout.php">Logout</a>
    </div>

	<h1>Modifica profilo</h1>
	<form method="POST" action="../backend/modificaprofilo_acq.php?id=<?php echo $mail; ?>">
		<p><label>Nome: </label><input type="text" value="<?php echo $row['nome']; ?>" name="nome" maxlength="20" required></p>
		<p><label>Cognome: </label><input type="text" value="<?php echo $row['cognome']; ?>" name="cognome" maxlength="20" required></p>
		<p><label>Password: </label><input type="text" value="<?php echo $row['password']; ?>" name="password" maxlength="30" required></p>
		<p><label>telefono: </label><input type="text" inputmode="numeric" value="<?php echo $row['telefono']; ?>" name="telefono" maxlength="10"
		onkeypress="return (event.key !=8 && event.key ==0 || (event.key >= 0 && event.key <= 9))" required></p>
		<p><label>Istruzioni: </label><textarea name="istruzioni" maxlength="40"><?php echo $row['istruzioni']; ?></textarea></p>
		

	<?php
	//session_start();
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente'];
	$query=mysqli_query($conn,"select * from `domicilio` where mailacq='$mail'");
	$row=mysqli_fetch_array($query);
	}
	?>

		<p><label>Via: </label><input type="text" value="<?php echo $row['via']; ?>" name="via" maxlength="25" required></p>
		<p><label>Numero: </label><input type="text" value="<?php echo $row['numero']; ?>" name="numero"
		onkeypress="return (event.key !=8 && event.key ==0 || (event.key >= 0 && event.key <= 9))" maxlength="3" size="3" required></p>
		<p><label>CAP: </label><input type="text" inputmode="numeric" value="<?php echo $row['cap']; ?>" name="cap"
		onkeypress="return (event.key !=8 && event.key ==0 || (event.key >= 0 && event.key <= 9))" minlength="5" maxlength="5" size="5" required></p>
		<label for="citta">Città: </label>
		<select id="citta" name="citta" required>
            <option value="milano" <?php echo ($row['citta'] == "Milano") ? "selected" : "";?>>Milano</option>
            <option value="roma" <?php echo ($row['citta'] == "Roma") ? "selected" : "";?>>Roma</option>
            <option value="palermo" <?php echo ($row['citta'] == "Palermo") ? "selected" : "";?>>Palermo</option>
            <option value="torino" <?php echo ($row['citta'] == "Torino") ? "selected" : "";?>>Torino</option>
            <option value="cagliari" <?php echo ($row['citta'] == "Cagliari") ? "selected" : "";?>>Cagliari</option>
            <option value="trento" <?php echo ($row['citta'] == "Trento") ? "selected" : "";?>>Trento</option>
        </select>
		<br><br>
		<input type="submit" name="submit" value="Salva">
		</form>

	
</body>

</html>