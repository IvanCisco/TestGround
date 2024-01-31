<!DOCTYPE html>
<?php
	include("../common/connessione.php");
	session_start();
	// Recupero dei dati dell'utente
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in session
	$query=mysqli_query($conn,"select * from `fattorino` where mail='$mail'");
	$row=mysqli_fetch_array($query);

	$query2=mysqli_query($conn,"select * from `operainfatt` where mailfatt='$mail'");
	$row2=mysqli_fetch_array($query2);
	}
?>

<html lang="it">
	<script src="../js/javascript.js"></script>
	<head>
		<title>EDIT</title>
		<script src="../js/funzioni.js" async></script>
	</head>
	<body>
		<h2>Edit</h2>
		<form method="POST" action="../backend/modificaprofilo_fatt.php?id=<?php echo $mail; ?>" onsubmit="return validazione()">
				<label for="nome">Nome: </label>
			<input type="text" id="nome" name="nome" value="<?php echo $row['nome'];?>" maxlength="20" required>
			<br><br>
			<label for="cognome">Cognome: </label>
			<input type="text" id="cognome" name="cognome" value="<?php echo $row['cognome'];?>" maxlength="20" required>
			<br><br>
			<label for="password">Password: </label>
			<input type="text" id="password" name="password" value="<?php echo $row['password']; ?>" maxlength="30" required>
			<br><br>
			<span>Sesso: </span>
			<input type="radio" name="sesso" id="m" <?php if (isset($row["sesso"]) && $row["sesso"]=="M") echo "checked";?> value="m" required><label for="m">M</label>
        	<input type="radio" name="sesso" id="f" <?php if (isset($row["sesso"]) && $row["sesso"]=="F") echo "checked";?> value="f"><label for="f">F</label>
       		<input type="radio" name="sesso" id="nb" <?php if (isset($row["sesso"]) && $row["sesso"]=="NB") echo "checked";?> value="nb"><label for="nb">NB</label>
			<br><br>
			<label for="datanascita">Data di nascita: </label>
        	<input type="date" id="datanascita" name="datanascita" value="<?php echo $row["datanascita"];?>" action="checkAge()" required>
			<br><br>
			<label for="luogonascita">Luogo di nascita:</label>
			<input type="text" id="luogonascita" value="<?php echo $row['luogonascita'];?>" name="luogonascita" maxlength="25" required>
			<br><br>
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
			<label for="numero">Zona: </label>
    		<select id="numero" name="numero" required>
        		<option disabled selected value></option>
        		<option value="1" <?php echo ($row2['numero'] == "1") ? "selected" : "";?>>1</option>
        		<option value="2" <?php echo ($row2['numero'] == "2") ? "selected" : "";?>>2</option>
        		<option value="3" <?php echo ($row2['numero'] == "3") ? "selected" : "";?>>3</option>
        		<option value="4" <?php echo ($row2['numero'] == "4") ? "selected" : "";?>>4</option>
        		<option value="5" <?php echo ($row2['numero'] == "5") ? "selected" : "";?>>5</option>
    		</select>
			<br><br>
			Disponibilità:
			<input type="radio" name="disponibilita" id="s" <?php if (isset($row["disponibilita"]) && $row["disponibilita"]=="s") echo "checked";?> value="s" required><label for="s">S</label>
        	<input type="radio" name="disponibilita" id="n" <?php if (isset($row["disponibilita"]) && $row["disponibilita"]=="n") echo "checked";?> value="n"><label for="n">N</label>

		<?php
		//session_start();
		if(isset($_SESSION['utente'])) {
		$mail = $_SESSION['utente'];
		$query=mysqli_query($conn,"select * from `domicilio` where mailacq='$mail'");
		$row=mysqli_fetch_array($query);
		}
		?>
		<div class="tab" id="orari">
            <h2>I miei orari</h2>
            <div id="dynamicFieldContainer">
                <div class="dynamicField">
                    <label for="giorno0">Giorno: </label>
                    <select id="giorno0" name="giorno[]">
                        <option disabled selected value></option>
                        <option value="Lunedì">Lunedì</option>
                        <option value="Martedì">Martedì</option>
                        <option value="Mercoledì">Mercoledì</option>
                        <option value="Giovedì">Giovedì</option>
                        <option value="Venerdì">Venerdì</option>
                        <option value="Sabato">Sabato</option>
                        <option value="Domenica">Domenica</option>
                    </select>
                    <label for="orainizio0">Orario di apertura: </label>
                    <input type="time" id="orainizio0" name="orainizio[]" step="300">
                    <label for="orafine0">Orario di chiusura: </label>
                    <input type="time" id="orafine0" name="orafine[]" step="300">
                </div>
            </div>
            <button type="button" onclick="aggiungiCampo()">+</button>
        </div>
		<input type="submit" name="submit">
		</form>
	</body>
</html>