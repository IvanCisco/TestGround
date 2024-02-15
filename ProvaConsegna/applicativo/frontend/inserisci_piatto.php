<!DOCTYPE html>
<html>
<head>
    <title>Inserisci piatto</title>
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
    <h1>Inserimento piatto</h1>
    <section class="page-content">
    <form action="../backend/inserisci_piatto.php" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome del piatto:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="descrizione">descrizione del piatto :</label>
        <input type="text" id="descrizione" name="descrizione" required><br><br>


        <label for="password">prezzo del piatto:</label>
        <input type="float" id="prezzo" name="prezzo" required><br><br>


        <!--preso da ariel -->
        <div class="container-xxl position-relative d-flex p-0">

        <div class = "content">
            
            <div class="container-fluid px-5">
                   
                
                    Select image to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    
      
            

            </div>

            
        </div>


    </div>
        

        <input type="submit" value="Inserisci">
    </form>
</section>
<?php include("../common/footer.html"); ?>
</body>
</html>