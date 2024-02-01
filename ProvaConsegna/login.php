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
        <style>
            @import url('https://fonts.cdnfonts.com/css/nimbus-sans-l');
        </style>
                
        <link rel="stylesheet" href="css/stile.css">
        <!--<link rel="stylesheet" href="css/style.css">-->
        <!--<link rel="stylesheet" href="css/loginstyle.css">-->
    </head>
    <body>
        <?php
        include("common/connessione.php");
        include("backend/logincheck.php");
        ?>
        <div class="login-nav">
            <a class="nu" href="index.html"><img src="images/MainIcon.png" height="40px"></a>
            <a class="nu" href="index.html">Impero del Cibo</a>
            <a>Benvenuto</a>
        </div>
        <br><br><br><br><br><br><br><br>
        <div class=login-form>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
                    <span><a class="nu" href="backend/registrazione_acq.php">Crea account acquirente</a></span>
                    <br><br>
                    <span><a class="nu" href="backend/registrazione_rist.php">Crea account ristorante</a></span>
                    <br><br>
                    <span><a class="nu" href="backend/registrazione_fatt.php">Crea account fattorino</a></span>
                </div>
            </form>
    </div>

        <!-- Include the footer -->
    <?php include("common/footer.html"); ?>
    </body>
</html>