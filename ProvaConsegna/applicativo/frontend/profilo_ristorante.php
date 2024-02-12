<!DOCTYPE html>
<html>
    <head>
        <script src="../js/javascript.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
    </head>
    <body>
        <?php
        include("../common/navbar_ristorante.php");
        include("../backend/display_risto_info.php");
        ?>
        <h1>Profilo Ristorante</h1>
        <section class="page-content">
            <div class=wrapperInfoRist>
                <div class="infoRist">
                    <h2>Dati del ristorante</h2>
                    <p>Nome: <?php echo $row['nome'];?></p>
                    <p>Ragione sociale: <?php echo $row['ragsoc'];?></p>
                    <p>Partita IVA: <?php echo $row['partitaiva'];?></p>
                    <p>E-mail: <?php echo $row['mail'];?></p>
                    <p>Password: <?php echo $row['password'];?></p>
                </div>
                <div class="infoRist">
                    <h2>Location</h2>
                    <p><?php echo $row['via'] . " " . $row['numero'] . ",";?></p>
                    <p><?php echo $row['cap'] . ",";?>
                    <p><?php echo $row['citta'] . ", Zona " . $row['zona'];?></p>
                </div>
                <div class="infoRist">
                    <h2>Sede legale</h2>
                    <p><?php echo $row['viasl'] . " " . $row['numerosl'];?></p>
                    <p><?php echo $row['capsl'];?>
                    <p><?php echo $row['cittasl'];?></p>
                </div>
            </div>
            <div class="wrapperOrariRisto">
                <div class="orariRisto">
                    <h2>Orari di esercizio</h2>
                    <?php include("../backend/visualizza_orari_ristorante.php");?>
                </div>
            </div>
        </section>
    </body>
    <?php include("../common/footer.html"); ?>
</html>