<!DOCTYPE html>
<html>
    <head>
        <title>Inserisci piatto</title>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
        <script src="../js/funzioni.js" async></script>
    </head>
    <body>
        <?php include("../backend/inserisci_piatto.php");?>
        <div class="header">
            <div class="navbar">
                <li><img src="../images/MainIcon.png" height="40px"></li>
                    <a href="ristorante.php">Torna indietro</a>
                    <a href="profilo_ristorante.php">Profilo</a>
                    <a href="modificaprofilo_ristorante.php">Modifica Profilo</a>
                    <a href="inserisci_piatto.php">Inserire nuovo piatto</a>
                    <a href="crea_menu.php">Crea menu</a>
                    <a href="ordini_ristorante.php">Ordini</a>
                    <a href="../common/logout.php">Logout</a>
                </div>
            </div>
        <h1>Inserimento piatto</h1>
        <section class="page-content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                <label for="nome">Nome del piatto:</label>
                <input type="text" id="nome" name="nome" required>
                <br><br>
                <label for="descrizione">descrizione del piatto :</label>
                <input type="text" id="descrizione" name="descrizione" required>
                <br><br>
                <label for="password">prezzo del piatto:</label>
                <input type="text" inputmode="numeric" id="prezzo" name="prezzo" required>
                <br><br>
                <!--preso da ariel -->
                <div class="container-xxl position-relative d-flex p-0">
                    <div class = "content">
                        <div class="container-fluid px-5">
                            Select image to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Inserisci">
                <span class="error"><?php echo $errore?></span>
            </form>
        </section>
        <?php include("../common/footer.html"); ?>
    </body>
</html>