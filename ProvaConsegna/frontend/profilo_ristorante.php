<!DOCTYPE html>
<html>
    <head>
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <p><a href="ristorante.php">Torna indietro</a></p>
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
            <h3>Sede Legale </h3>
            <?php

            //select per l'indirizzo della sede legale del ristorante
            $stmt = $conn->prepare("SELECT * FROM sedelegale WHERE mailrist = ?");
            $stmt->bind_param("s", $mail);
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
            $stmt = $conn->prepare("SELECT * FROM location WHERE mailrist = ?");
            $stmt->bind_param("s", $mail);
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
            echo "Utente non loggato";
        }
        ?>
    </body>
</html>