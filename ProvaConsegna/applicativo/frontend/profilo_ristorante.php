<!DOCTYPE html>
<html>
    <head>
        <script src="../js/javascript.js"></script>
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
        <h1>Profilo Ristorante</h1>
        <h3>Dati del ristorante </h3>

        <?php
        include '../common/connessione.php';
        session_start();
        // Recupero dei dati dell'utente
        if(isset($_SESSION['utente'])) {
            $mail = $_SESSION['utente']; // Assumendo che l'email sia memorizzata in sessione

            //select dati del ristorante
            $stmt = $conn->prepare("SELECT * FROM ristorante WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
        ?>
                    <i class="far fa-edit edit-icon" onclick="editField('password')"></i>
                    </p>
                    <?php
                    echo "<p>Password: " . $row["password"] . "</p>";
                    echo "<p>Nome: " . $row["nome"] . "</p>";
                    echo "<p>Ragione Sociale: " . $row["ragsoc"] . "</p>";
                    echo "<p>PartitaIVA: " . $row["partitaiva"] . "</p>";
                }
            }
                    ?>
            <h3>Zona </h3>
            <?php

            //select per la zona in cui si trova il ristorante
            $stmt = $conn->prepare("SELECT * FROM operainrist WHERE mailrist = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p>Zona: " . $row["zona"] . "</p>";
                }
            }
            ?>

            <?php
            //recupero id sedelegale e location
            $stmt = $conn->prepare("SELECT location, sedelegale FROM ristorante WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            // Dichiarazione delle variabili per memorizzare la location e la sede legale
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

            <h3>Sede Legale </h3>
            <?php

            //select per l'indirizzo della sede legale del ristorante
            $stmt = $conn->prepare("SELECT * FROM indirizzo WHERE id = ?");
            $stmt->bind_param("s", $sedeLegale);
            $stmt->execute();
            $result = $stmt->get_result();


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <i class="far fa-edit edit-icon" onclick="editField('password')"></i>
                    </p>
                    <?php
                    echo "<p>Via: " . $row["via"] . "</p>";
                    echo "<p>Numero: " . $row["numero"] . "</p>";
                    echo "<p>Cap: " . $row["cap"] . "</p>";
                    echo "<p>Città: " . $row["citta"] . "</p>";
                }
            }
                    ?>
            <h3>Location</h3>
            <?php

            //select per l'indirizzo in cui si trova il ristorante
            $stmt = $conn->prepare("SELECT * FROM indirizzo WHERE id = ?");
            $stmt->bind_param("s", $location);
            $stmt->execute();
            $result = $stmt->get_result();


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <i class="far fa-edit edit-icon" onclick="editField('password')"></i>
                    </p>
                    <?php
                    echo "<p>Via: " . $row["via"] . "</p>";
                    echo "<p>Numero: " . $row["numero"] . "</p>";
                    echo "<p>Cap: " . $row["cap"] . "</p>";
                    echo "<p>Città: " . $row["citta"] . "</p>";
                }
            }

        } else {
            echo "Utente non loggato";
        }
                    ?>

        <h3>I miei orari</h3>
        <?php
        //select turni del ristorante
        $stmt = $conn->prepare("SELECT * FROM rlavorasu WHERE mailrist = ?");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();



        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        
                echo "<p>Giorno: " . $row["giorno"] . "</p>";
                echo "<p>inizio turno: " . $row["orainizio"] . "</p>";
                echo "<p>fine turno: " . $row["orafine"] . "</p>";
            }
        }else {
            echo "Non è stato trovato alcun turno, recarsi nella sezione modifica profilo per aggiungerne";
        }
        ?>
    </body>
</html>