<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Impero del Cibo</title>
        <style>
            .error {color: #FF0000;}
        </style>
        <script src="../js/funzioni.js" async></script>
    </head>
    <body>
        <?php
        include "../common/connessione.php";
        include "../backend/fattsignupcheck.php";
        ?>
        <p><a href="http://localhost/SITO_NOVEMBRE2023/login.php">Torna indietro</a></p>
        <div id="form">
            <h1>Registrazione fattorino</h1>
            <p><span class="error">* Campi obbligatori</span></p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validazione()">
                <label for="nome">Nome: </label>
                <input type="text" id="nome" name="nome" maxlength="20" pattern="[a-zA-Z-' ]+" required>
                <span class="error">* <?php echo $nomeErr;?></span>
                <br><br>
                <label for="cognome">Cognome: </label>
                <input type="text" id="cognome" name="cognome" maxlength="20" pattern="[a-zA-Z-' ]+" required>
                <span class="error">* <?php echo $cognomeErr;?></span>
                <br><br>
                Sesso: 
                <input type="radio" name="sesso" id="m" <?php if (isset($sesso) && $sesso=="m") echo "checked";?> value="f" required><label for="m">M</label>
                <input type="radio" name="sesso" id="f" <?php if (isset($sesso) && $sesso=="f") echo "checked";?> value="m"><label for="f">F</label>
                <input type="radio" name="sesso" id="nb" <?php if (isset($sesso) && $sesso=="nb") echo "checked";?> value="nb"><label for="nb">NB</label>
                <span class="error">* <?php echo $sessoErr;?></span>
                <br><br>
                <label for="datanascita">Data di nascita: </label>
                <input type="date" id="datanascita" name="datanascita" action="checkAge()" required>
                <span class="error">* <?php echo $datanascitaErr;?></span>
                <br><br>
                <label for="mail">Mail: </label>
                <input type="email" id="mail" name="mail" maxlength="40" required>
                <span class="error">* <?php echo $mailErr;?></span>
                <br><br>
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" maxlength="30" required>
                <span class="error">* <?php echo $passwordErr;?></span>
                <br><br>
                <label for="luogonascita">Luogo di nascita: </label>
                <input type="text" id="luogonascita" name="luogonascita" maxlength="25" pattern="[a-zA-Z-' ]+" required>
                <span class="error">* <?php echo $luogonascitaErr;?></span>
                <br><br>
                <label for="citta">In quale città vorresti operare?</label>
                <select name="citta" id="citta" required>
                    <option disabled selected value></option>
                    <option value="milano">Milano</option>
                    <option value="roma">Roma</option>
                    <option value="palermo">Palermo</option>
                    <option value="torino">Torino</option>
                    <option value="cagliari">Cagliari</option>
                    <option value="trento">Trento</option>
                </select>
                <br><br>
                In quali zone vorresti operare?
                <span class="error" id="checkErr" style="visibility:hidden;">Seleziona almeno una zona</span><br>   
                <input type="checkbox" id="zone_1" name="zone[]" value="1"><label for="zone_1">1</label><br>
                <input type="checkbox" id="zone_2" name="zone[]" value="2"><label for="zone_2">2</label><br>
                <input type="checkbox" id="zone_3" name="zone[]" value="3"><label for="zone_3">3</label><br>
                <input type="checkbox" id="zone_4" name="zone[]" value="4"><label for="zone_4">4</label><br>
                <input type="checkbox" id="zone_5" name="zone[]" value="5"><label for="zone_5">5</label><br>
                <input type="submit" name="registrati" value="Registrati">
                <span class="error"><?php echo $alreadyErr;?></span>
            </form>
        </div>
    </body>
</html>