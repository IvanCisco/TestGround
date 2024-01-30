<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Impero del Cibo</title>
        <style>
            .error {color: #FF0000;}
        </style>
    </head>
    <body>
        <?php
        include("common/connessione.php");
        include("backend/logincheck.php");
        ?>
        <h1>Benvenuto</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<!--<form method="post" action"/check/your_script.php">-->
		
            <label for="email"><b>E-mail</b></label>
            <input type="email" name="mail" maxlength="40" required>
            <span class="error"><?php echo $mailErr;?></span>
            <br><br>
            <label for="password"><b>Password</b></label>
            <input type="password" name="password" maxlength="30" required>
            <span class="error"><?php echo $passwordErr;?></span>
            <br><br>
            <label for="utente">Utente</label>
            <select name="utente" required>
                <option disabled selected value></option>
                <option value="acquirente">Acquirente</option>
                <option value="fattorino">Fattorino</option>
                <option value="ristorante">Ristorante</option>
            </select>
            <br><br>
            <button type="submit" name="login">Login</button>
            <span class="error"><?php echo $loginErr;?></span>
            <div>
                <span><a href="backend/registrazione_acq.php">Crea account acquirente</a></span>
                <br><br>
                <span><a href="backend/registrazione_rist.php">Crea account ristorante</a></span>
                <br><br>
                <span><a href="backend/registrazione_fatt.php">Crea account fattorino</a></span>
            </div>
        </form>
    </body>
</html>