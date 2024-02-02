<!DOCTYPE html>
<html>
<head>
    <title>Registrati</title>
    <style> 
        .error {color: #FF0000;}
    </style>
</head>
<body>
<?php
include "../common/connessione.php";
include "../backend/signupcheck.php";
?>
<p><a href="../login.php">Torna indietro</a></p>

    <div id="form">
        <h1>Registrazione acquirente</h1>
        <p><span class="error">* Campi obbligatori</span></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome);?>" maxlength="20"
            onkeypress="return (event.key !=8 && event.key ==0 || ((event.key >= A && event.key <= Z) || (event.key >= a && event.key <= Z))" required>
            <span class="error">* <?php echo $nomeErr;?></span>
            <br><br>
            <label for="cognome">Cognome: </label>
            <input type="text" id="cognome" name="cognome" value="<?php echo htmlspecialchars($cognome);?>" maxlength="20" required>
            <span class="error">* <?php echo $cognomeErr;?></span>
            <br><br>
            <label for="mail">Mail: </label>
            <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($mail);?>" maxlength="40" required>
            <span class="error">* <?php echo $mailErr;?></span>
            <br><br>
            <label for="password">Password: </label>
            <input type="password" id="password" name="password" maxlenght="30" required>
            <span class="error">* <?php echo $passwordErr;?></span>
            <br><br>
            <label for="telefono">Telefono: </label>
            <input type="text" inputmode="numeric" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono);?>" minlength="10" maxlength="10" size="10"
            onkeypress="return (event.key !=8 && event.key ==0 || (event.key >= 0 && event.key <= 9))" required>
            <span class="error">* <?php echo $telefonoErr;?></span>
            <br><br>
            <label for="via">Via: </label>
            <input type="text" id="via" name="via" value="<?php echo htmlspecialchars($via);?>" maxlength="25" required>
            <span class="error">* <?php echo $viaErr;?></span>
            <label for="numero">Numero: </label>
            <input type="text" inputmode="numeric" id="numero" name="numero" value="<?php echo htmlspecialchars($numero);?>" maxlength="3" size="3"
            onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
            <span class="error">* <?php echo $numeroErr;?></span>
            <label for="cap">Cap: </label>
            <input type="text" id="cap" name="cap" value="<?php echo htmlspecialchars($cap);?>" inputmode="numeirc" minlength="5" maxlength="5" size="5" 
            onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
            <span class="error">* <?php echo $capErr;?></span>
            <label for="citta">Città: </label>
            <select name="citta" id="citta" required>
                <option disabled selected value></option>
                <option value="milano" <?php echo ($citta == "milano") ? "selected" : "";?>>Milano</option>
                <option value="roma" <?php echo ($citta == "roma") ? "selected" : "";?>>Roma</option>
                <option value="palermo" <?php echo ($citta == "palermo") ? "selected" : "";?>>Palermo</option>
                <option value="torino" <?php echo ($citta == "torino") ? "selected" : "";?>>Torino</option>
                <option value="cagliari" <?php echo ($citta == "cagliari") ? "selected" : "";?>>Cagliari</option>
                <option value="trento" <?php echo ($citta == "trento") ? "selected" : "";?>>Trento</option>
            </select>
            <br><br>
            <input type="submit" name="registrati" value="Registrati">
            <span class="error"><?php echo $alreadyErr;?></span>
        </form>
    </div>
</body>
</html>