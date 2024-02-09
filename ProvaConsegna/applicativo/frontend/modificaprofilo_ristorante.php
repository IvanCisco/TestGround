<!DOCTYPE html>
<html>

<script src="js/javascript.js"></script>
<head>
<title>EDIT ristorante</title>
<script src="js/funzioni.js" async></script>
<link rel="stylesheet" type="text/css" href="../css/stile.css">
</head>
<body>
    <head>
        <script src="js/javascript.js"></script>
        <title>EDIT ristorante</title>
        <script src="js/funzioni.js" async></script>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
    </head>
    <body>
	    <div class="header">
            <div class="navbar">
                <li><img src="../images/MainIcon.png" height="40px"></li>
                <a href="ristorante.php">Torna indietro</a>
                <a href="profilo_ristorante.php">Profilo</a>
                <a href="modificaprofilo_ristorante.php">Modifica Profilo</a>
                <a href="inserisci_piatto.html">Inserire nuovo piatto</a>
                <a href="crea_menu.php">Crea menu</a>
                <a href="ordini_ristorante.php">Ordini</a>
                <a href="../common/logout.php">Logout</a>
            </div>
        </div>
        <?php include("../backend/display_risto_info.php");?>
	    <h1>Modifica il tuo profilo</h1>
	    <section class="page-content">
	        <form method="POST" action="../backend/modificaprofilo_ris.php?id=<?php echo $mail; ?>">
		        <p><label>Password:</label><input type="text" value="<?php echo $row['password']; ?>" name="password" maxlength="30" required></p>
		        <p><label>Nome:</label><input type="text" value="<?php echo $row['nome']; ?>" name="nome" maxlength="30" required></p>
		        <p><label>Ragione Sociale:</label><input type="text" value="<?php echo $row['ragsoc']; ?>" name="ragsoc" maxlength="20" requiired></p>
		        <p><label>Partita IVA:</label><input type="text" inputmode="numeric" value="<?php echo $row['partitaiva']; ?>" name="partitaiva" minlength="11" maxlength="11" size="11"
		        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>


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

		        <p><label>Via:</label><input type="text" value="<?php echo $row['via']; ?>" name="via_location" maxlength="25" required></p>
		        <p><label>Numero:</label><input type="text" value="<?php echo $row['numero']; ?>" name="numero_location" maxlength="3" size="3"
		        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		        <p><label>CAP:</label><input type="text" value="<?php echo $row['cap']; ?>" name="cap_location" minlength="5" maxlength="5" size="5"
		        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		        <label for="citta">Città: </label>
                <select id="citta" name="citta_location" required>
                    <option value="milano" <?php echo ($row["citta"] == "Milano") ? "selected" : "";?>>Milano</option>
                    <option value="roma" <?php echo ($row["citta"] == "Roma") ? "selected" : "";?>>Roma</option>
                    <option value="palermo" <?php echo ($row["citta"] == "Palermo") ? "selected" : "";?>>Palermo</option>
                    <option value="torino" <?php echo ($row["citta"] == "Torino") ? "selected" : "";?>>Torino</option>
                    <option value="cagliari" <?php echo ($row["citta"] == "Cagliari") ? "selected" : "";?>>Cagliari</option>
                    <option value="trento" <?php echo ($row["citta"] == "Trento") ? "selected" : "";?>>Trento</option>
                </select>

	            <h3>Sede Legale</h3>

		        <p><label>Via:</label><input type="text" value="<?php echo $row['viasl']; ?>" name="via_sedelegale" maxlength="25" required></p>
		        <p><label>Numero:</label><input type="text" inputmode="numeric" value="<?php echo $row['numerosl']; ?>" name="numero_sedelegale" maxlength="3" size="3"
		        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		        <p><label>CAP:</label><input type="text" inputmode="numeric" value="<?php echo $row['capsl']; ?>" name="cap_sedelegale" minlength="5" maxlength="5" size="5"
		        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></p>
		        <label for="citta_sedelegale">Città: </label>
                <select id="citta_sedelegale" name="citta_sedelegale" required>
                    <option value="milano" <?php echo ($row["cittasl"] == "Milano") ? "selected" : "";?>>Milano</option>
                    <option value="roma" <?php echo ($row["cittasl"] == "Roma") ? "selected" : "";?>>Roma</option>
                    <option value="palermo" <?php echo ($row["cittasl"] == "Palermo") ? "selected" : "";?>>Palermo</option>
                    <option value="torino" <?php echo ($row["cittasl"] == "Torino") ? "selected" : "";?>>Torino</option>
                    <option value="cagliari" <?php echo ($row["cittasl"] == "Cagliari") ? "selected" : "";?>>Cagliari</option>
                    <option value="trento" <?php echo ($row["cittasl"] == "Trento") ? "selected" : "";?>>Trento</option>
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
</body>
	    <?php include("../common/footer.html"); ?>
    </body>


</html>