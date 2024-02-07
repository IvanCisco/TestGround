<!DOCTYPE html>
<?php
	include("../common/connessione.php");
	session_start();
	// Recupero dei dati dell'utente
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in session
	$query=mysqli_query($conn,"select * from `ristorante` where mail='$mail'");
	$row=mysqli_fetch_array($query);
}
?>

<html>
<script src="js/javascript.js"></script>
<head>
<title>EDIT ristorante</title>
<script src="js/funzioni.js" async></script>
<link rel="stylesheet" type="text/css" href="../css/stile.css">
</head>
<body>
	<div class="header">
        <div class="navbar">
            <li><img src="../images/MainIcon.png" height="40px"></li>
                <a href="ristorante.php">Torna indietro</a>
                <a href="modificaprofilo_ristorante.php">Modifica Profilo</a>
                <a href="inserisci_piatto.html">Inserire nuovo piatto</a>
                <a href="crea_menu.php">Crea menu</a>
                <a href="ordini_ristorante.php">Ordini</a>
                <a href="../common/logout.php">Logout</a>
            </div>
        </div>
	<h1>Modifica il tuo profilo</h1>
	<section class="page-content">
	<form method="POST" action="../backend/modificaprofilo_ris.php?id=<?php echo $mail; ?>">
		<p><label>Password:</label><input type="text" value="<?php echo $row['password']; ?>" name="password" maxlength="30" required></p>
		<p><label>Nome:</label><input type="text" value="<?php echo $row['nome']; ?>" name="nome" maxlength="30" required></p>
		<p><label>Ragione Sociale:</label><input type="text" value="<?php echo $row['ragsoc']; ?>" name="ragsoc" maxlength="20" requiired></p>
		<p><label>Partita IVA:</label><input type="text" inputmode="numeric" value="<?php echo $row['partitaiva']; ?>" name="partitaiva" minlength="11" maxlength="11" size="11"
		onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>

	<?php
	//session_start();
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente'];
	$query=mysqli_query($conn,"select * from `operainrist` where mailrist='$mail'");
	$row=mysqli_fetch_array($query);
	}
	?>

	<h3>Location</h3>

	<label for="zona">Zona: </label>
    <select id="zona" name="zona" required>
        <option disabled selected value></option>
        <option value="1" <?php echo ($row["zona"] == "1") ? "selected" : "";?>>1</option>
        <option value="2" <?php echo ($row["zona"] == "2") ? "selected" : "";?>>2</option>
        <option value="3" <?php echo ($row["zona"] == "3") ? "selected" : "";?>>3</option>
        <option value="4" <?php echo ($row["zona"] == "4") ? "selected" : "";?>>4</option>
        <option value="5" <?php echo ($row["zona"] == "5") ? "selected" : "";?>>5</option>
    </select>
	
	<?php
            //recupero id sedelegale e location
            $stmt = $conn->prepare("SELECT location, sedelegale FROM ristorante WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            $location = "";
            $sedeLegale = "";

            // Verifica se ci sono risultati
            if ($result->num_rows > 0) {
                // Estrai i dati e memorizzali nelle variabili
                while ($row = $result->fetch_assoc()) {
                    $location = $row["location"];
                    $sedeLegale = $row["sedelegale"];
                }
            }
            ?>

	<?php
	//session_start();
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente'];
	$query=mysqli_query($conn,"select * from `indirizzo` where id='$location'");
	$rowLocation=mysqli_fetch_array($query);
	}
	?>

		<p><label>Via:</label><input type="text" value="<?php echo $rowLocation['via']; ?>" name="via_location" maxlength="25" required></p>
		<p><label>Numero:</label><input type="text" value="<?php echo $rowLocation['numero']; ?>" name="numero_location" maxlength="3" size="3"
		onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		<p><label>CAP:</label><input type="text" value="<?php echo $rowLocation['cap']; ?>" name="cap_location" minlength="5" maxlength="5" size="5"
		onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		<label for="citta">Città: </label>
        <select id="citta" name="citta_location" required>
            <option value="milano" <?php echo ($rowLocation["citta"] == "Milano") ? "selected" : "";?>>Milano</option>
            <option value="roma" <?php echo ($rowLocation["citta"] == "Roma") ? "selected" : "";?>>Roma</option>
            <option value="palermo" <?php echo ($rowLocation["citta"] == "Palermo") ? "selected" : "";?>>Palermo</option>
            <option value="torino" <?php echo ($rowLocation["citta"] == "Torino") ? "selected" : "";?>>Torino</option>
            <option value="cagliari" <?php echo ($rowLocation["citta"] == "Cagliari") ? "selected" : "";?>>Cagliari</option>
            <option value="trento" <?php echo ($rowLocation["citta"] == "Trento") ? "selected" : "";?>>Trento</option>
        </select>
		<!--row location perchè era in conflitto con row sotto non avendo specificato erano uguali  -->



	<?php
	//session_start();
	if(isset($_SESSION['utente'])) {
	$mail = $_SESSION['utente'];
	$query=mysqli_query($conn,"select * from `indirizzo` where id='$sedeLegale'");
	$rowSedelegale=mysqli_fetch_array($query);
	}
	?>

	<h3>Sede Legale</h3>

		<p><label>Via:</label><input type="text" value="<?php echo $rowSedelegale['via']; ?>" name="via_sedelegale" maxlength="25" required></p>
		<p><label>Numero:</label><input type="text" inputmode="numeric" value="<?php echo $rowSedelegale['numero']; ?>" name="numero_sedelegale" maxlength="3" size="3"
		onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		<p><label>CAP:</label><input type="text" inputmode="numeric" value="<?php echo $rowSedelegale['cap']; ?>" name="cap_sedelegale" minlength="5" maxlength="5" size="5"
		onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		<label for="citta_sedelegale">Città: </label>
        <select id="citta_sedelegale" name="citta_sedelegale" required>
            <option value="milano" <?php echo ($rowSedelegale["citta"] == "Milano") ? "selected" : "";?>>Milano</option>
            <option value="roma" <?php echo ($rowSedelegale["citta"] == "Roma") ? "selected" : "";?>>Roma</option>
            <option value="palermo" <?php echo ($rowSedelegale["citta"] == "Palermo") ? "selected" : "";?>>Palermo</option>
            <option value="torino" <?php echo ($rowSedelegale["citta"] == "Torino") ? "selected" : "";?>>Torino</option>
            <option value="cagliari" <?php echo ($rowSedelegale["citta"] == "Cagliari") ? "selected" : "";?>>Cagliari</option>
            <option value="trento" <?php echo ($rowSedelegale["citta"] == "Trento") ? "selected" : "";?>>Trento</option>
        </select>
		<div class="tab" id="orari">
            <h2>I miei orari</h2>
            <div id="dynamicFieldContainer">
                <div class="dynamicField">
                    <label for="giorno">Giorno: </label>
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

	</section>
	<?php include("../common/footer.html"); ?>
</body>

</html>