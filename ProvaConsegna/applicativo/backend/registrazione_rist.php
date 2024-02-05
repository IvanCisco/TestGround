<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Impero del cibo</title>
        <style>
            .error {color: #FF0000;}
        </style>
        <script src="../js/funzioni.js"></script>
    </head>
    <body>
        <?php
        include_once("ristosignup.php");
        ?>
        <p><a href="../login.php">Torna indietro</a></p>
        <div id="form">
            <h1>Registrazione ristorante</h1>
            <p><span class="error">* Campi obbligatori</span></p>
            <form method="post" id="ristoform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validazioneRist()">
                <div class="tab">
                    <h2>Info generali</h2>
                    <label for="nome">Nome ristorante: </label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome);?>" maxlength="30" required>
                    <span class="error">* </span>
                    <br><br>
                    <label for="partitaiva">Partita IVA: </label>
                    <input type="text" inputmode="numeric" id="partitaiva" name="partitaiva" value="<?php echo htmlspecialchars($partitaiva);?>" minlength="11" maxlength="11" size="11" 
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                    <span class="error">* </span>
                    <br><br>
                    <label for="ragsoc">Ragione sociale: </label>
                    <input type="text" id="ragsoc" name="ragsoc" value="<?php echo htmlspecialchars($ragsoc);?>" maxlength="20" required>
                    <span class="error">* </span>
                    <br><br>
                    <label for="mail">E-mail: </label>
                    <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($mail);?>" maxlength="40" required>
                    <span class="error">* </span>
                    <br><br>
                    <label for="password">Password: </label>
                    <input type="password" id="password" name="password" maxlength="30" required>
                    <span class="error">* </span>
                    <br><br>
                    <label for="via">Via: </label>
                    <input type="text" id="via" name="via" value="<?php echo htmlspecialchars($via);?>" maxlength="25" required>
                    <span class="error">* </span>
                    <label for="numero">Numero: </label>
                    <input type="text" inputmode="numeric" id="numero" name="numero" value="<?php echo htmlspecialchars($numero);?>" maxlength="3" size="3" 
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                    <span class="error">* </span>
                    <label for="cap">Cap: </label>
                    <input type="text" id="cap" name="cap" value="<?php echo htmlspecialchars($cap);?>" inputmode="numeirc" minlength="5" maxlength="5" size="5" 
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                    <span class="error">* </span>
                    <label for="citta">Città: </label>
                    <select id="citta" name="citta" required>
                        <option disabled selected value></option>
                        <option value="milano" <?php echo ($citta == "milano") ? "selected" : "";?>>Milano</option>
                        <option value="roma" <?php echo ($citta == "roma") ? "selected" : "";?>>Roma</option>
                        <option value="palermo" <?php echo ($citta == "palermo") ? "selected" : "";?>>Palermo</option>
                        <option value="torino" <?php echo ($citta == "torino") ? "selected" : "";?>>Torino</option>
                        <option value="cagliari" <?php echo ($citta == "cagliari") ? "selected" : "";?>>Cagliari</option>
                        <option value="trento" <?php echo ($citta == "trento") ? "selected" : "";?>>Trento</option>
                    </select>
                    <span class="error">* </span>
                    <label for="zona">Zona: </label>
                    <select id="zona" name="zona" required>
                        <option disabled selected value></option>
                        <option value="1" <?php echo ($zona == "1") ? "selected" : "";?>>1</option>
                        <option value="2" <?php echo ($zona == "2") ? "selected" : "";?>>2</option>
                        <option value="3" <?php echo ($zona == "3") ? "selected" : "";?>>3</option>
                        <option value="4" <?php echo ($zona == "4") ? "selected" : "";?>>4</option>
                        <option value="5" <?php echo ($zona == "5") ? "selected" : "";?>>5</option>
                    </select>
                    <span class="error">* </span>
                    <br><br>
                </div>
                <div class="tab" id="orari">
                    <h2>Orari di esercizio</h2>
                    <div id="dynamicFieldContainer">
                        <div class="dynamicField">
                            <label for="giorno">Giorno: </label>
                            <select id="giorno0" name="giorno[]" required>
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
                            <input type="time" id="orainizio0" name="orainizio[]" step="300" required>
                            <label for="orafine0">Orario di chiusura: </label>
                            <input type="time" id="orafine0" name="orafine[]" step="300" required>
                        </div>
                    </div>
                    <button type="button" onclick="aggiungiCampo()">+</button>
                </div>
                <div class="tab" id="sedelegale">
                    <h2>Sede legale</h2>
                    <label for="viasl">Via: </label>
                    <input type="text" id="viasl" name="viasl" value="<?php echo htmlspecialchars($viasl);?>" maxlength="25" required>
                    <span class="error">* </span>
                    <label for="numerosl">Numero: </label>
                    <input type="text" id="numerosl" name="numerosl" value="<?php echo htmlspecialchars($numerosl);?>" inputmode="numeric" maxlength="3" size="3" 
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                    <span class="error">* </span>
                    <label for="capsl">Cap: </label>
                    <input type="text" id="capsl" name="capsl" value="<?php echo htmlspecialchars($capsl);?>" inputmode="numeric" minlength="5" maxlength="5" size="5"
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                    <span class="error">* </span>
                    <label for="cittasl">Città: </label>
                    <select id="cittasl" name="cittasl" required>
                        <option disabled selected value></option>
                        <option value="milano" <?php echo ($cittasl == "milano") ? "selected" : "";?>>Milano</option>
                        <option value="roma" <?php echo ($cittasl == "roma") ? "selected" : "";?>>Roma</option>
                        <option value="palermo" <?php echo ($cittasl == "palermo") ? "selected" : "";?>>Palermo</option>
                        <option value="torino" <?php echo ($cittasl == "torino") ? "selected" : "";?>>Torino</option>
                        <option value="cagliari" <?php echo ($cittasl == "cagliari") ? "selected" : "";?>>Cagliari</option>
                        <option value="trento" <?php echo ($cittasl == "trento") ? "selected" : "";?>>Trento</option>
                    </select>
                    <span class="error">* </span>
                    <br><br>
                    <input type="submit" name="registrati" value="Registrati">
                    <span class="error"><?php echo $alreadyErr;?></span>
                </div> 
            </form>
        </div>
    </body>
</html>