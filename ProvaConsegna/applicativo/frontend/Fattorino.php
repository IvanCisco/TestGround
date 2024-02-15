<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="../js/navbar.js"></script>
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <?php include("../common/navbar_fattorino.php"); ?>

        <h1>Ordini disponibili nella tua zona</h1>
        <section class="page-content">
        <?php
        /*
        opera in fatt ha dentro mail fattorino e zona
        mentre la città è in fattorino 

        opera in rist ha mail e zona zona
        mail rist si collega a location da cui posso prendere la zona e città
        */
        // connetto al database
        include("../common/connessione.php");
        session_start();

        // se loggato
        if (isset($_SESSION['utente'])) {
            $mail = $_SESSION['utente'];

            //select disponibilita del fattorino
            $queryDisponibilita = "SELECT disponibilita FROM fattorino WHERE mail=?";
            $stmtFattorino = $conn->prepare($queryDisponibilita);
            $stmtFattorino->bind_param("s", $mail);
            $stmtFattorino->execute();
            $resultdisponibilitaFattorino = $stmtFattorino->get_result();

            if ($resultdisponibilitaFattorino && $resultdisponibilitaFattorino->num_rows > 0) {
                $row = $resultdisponibilitaFattorino->fetch_assoc();
                $disp = $row['disponibilita'];
            }

            if ($disp == "N") {
                echo ("Attualmente la tua disponibilità si trova su N, non puoi accettare alcun ordine. Recati nella sezione modifica profilo per attivarla");
            } else {

                //RECUPERO DATA E ORA CORRENTI 
                // Imposta la localizzazione in italiano
                //date_default_timezone_set("Europe/Rome");
                $dataOdiernaING = date("l");
                $iNGToITA = array(
                    'Monday' => 'Lunedì',
                    'Tuesday' => 'Martedì',
                    'Wednesday' => 'Mercoledì',
                    'Thursday' => 'Giovedì',
                    'Friday' => 'Venerdì',
                    'Saturday' => 'Sabato',
                    'Sunday' => 'Domenica'
                );
        
                $giornoCorrente = $iNGToITA[$dataOdiernaING];


                // Recupera l'ora corrente
                $oraCorrente = date("H:i:s"); // "H:i:s" restituisce l'ora in formato 24 ore con i minuti e i secondi

                // Esegui una query per controllare se il fattorino è in turno in questo momento di questo giorno 
                $query = "SELECT t.giorno, t.orainizio, t.orafine 
                        FROM turno t
                        JOIN flavorasu fl ON t.id = fl.turno
                        JOIN fattorino f ON f.mail = fl.mail
                        WHERE f.citta = 'Milano'
                        AND t.giorno = '$giornoCorrente'
                        AND '$oraCorrente' BETWEEN t.orainizio AND t.orafine";

                $res= $conn->query($query);
                if (!$res){
                    echo "<p>Impossibile eseguire query.</p>"
                    . "<p>Codice errore " . $conn->errno
                    . ": " . $conn->error . "</p>";
                }else{
                    if ($res->num_rows > 0) {
                        // Output dati
                        while ($row = $res->fetch_assoc()) {

                            // select citta da fattorino in base alla mail 
                            $querycittaFattorino = "SELECT citta FROM fattorino WHERE mail = ?";
                            $stmtFattorino = $conn->prepare($querycittaFattorino);
                            $stmtFattorino->bind_param("s", $mail);
                            $stmtFattorino->execute();
                            $resultcittaFattorino = $stmtFattorino->get_result();

                            // select zona zona da operainfatt in base alla mail
                            $queryareaFattorino = "SELECT zona FROM operainfatt WHERE mail = ?";
                            $stmtFattorino = $conn->prepare($queryareaFattorino);
                            $stmtFattorino->bind_param("s", $mail);
                            $stmtFattorino->execute();
                            $resultareaFattorino = $stmtFattorino->get_result();

                            if ($resultcittaFattorino && $resultcittaFattorino->num_rows > 0) {
                                $row = $resultcittaFattorino->fetch_assoc();
                                $city_where_fattorino_works = $row['citta'];
                                if ($resultareaFattorino && $resultareaFattorino->num_rows > 0) {
                                    $row = $resultareaFattorino->fetch_assoc();
                                    $area_where_fattorino_delivers = $row['zona'];
        
        
                                    //echo "citta lavoro $city_where_fattorino_works<br>";
                                    //echo "zona lavoro $area_where_fattorino_delivers<br>";


                                    //Debugging output
                                    //echo "City where fattorino works: $city_where_fattorino_works<br>";
                                    //echo "Area where fattorino delivers: $area_where_fattorino_delivers<br>";

                                    //query commento
 
                                    // join tra ordine,contiene,operainrist,operainfatt,fattorino,ristorante
                                    // usiamo data e ora per distinguere gli ordini
                                    // il fattorino vedrà solo ordini della città in cui lavora e ristoranti della sua zona
                                    // lo stato può essere in preparazione e allora potrà prenderlo in carico
                                    // oppure può essere preso in carico e non potrà prenderlo lui 

        

                                    $query = "SELECT o.data, o.ora, o.stato, r.nome AS nome_ristorante
                                            FROM ordine o
                                            JOIN contiene c ON o.data = c.data AND o.ora = c.ora
                                            JOIN operainrist oi ON c.mail = oi.mail
                                            JOIN operainfatt of ON oi.zona = of.zona
                                            JOIN fattorino f ON of.mail = f.mail
                                            JOIN ristorante r ON oi.mail = r.mail
                                            WHERE f.mail = ? 
                                                AND f.citta = ? 
                                                AND oi.zona = ?
                                                AND oi.zona = of.zona -- Check if fattorino delivers in the same area as the restaurant

                                                /* AND f.citta = of.citta */
                                                AND oi.zona = of.zona 
                                                AND o.stato in('in preparazione','preso in carico')
                                                AND TIMESTAMPDIFF(HOUR, CONCAT(o.data, ' ', o.ora), NOW()) < 2";


                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("sss", $mail, $city_where_fattorino_works, $area_where_fattorino_delivers);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            //$nome = $row['nome'];
                                            $data = $row['data'];
                                            $ora = $row['ora'];
                                            $stato = $row['stato'];
                                            $nomeRistorante = $row['nome_ristorante'];

                                            echo "<div class='order'>";
                                            /*echo "<p>Nome: $nome, Data: $data, Ora: $ora, Stato: $stato</p>";*/
                                            echo "<p> Data: $data, Ora: $ora, Stato: $stato, Ristorante: $nomeRistorante</p>";

                                            // bottone modifica stato
                                            if ($row["stato"] == 'in preparazione') {
                                                echo "<form method='post' action='../backend/modify_order_status.php'>";
                                                echo "<input type='hidden' name='data' value='$data'>";
                                                echo "<input type='hidden' name='ora' value='$ora'>";
                                                echo "<input type='submit' name='modifyOrderStatus' value='Prendi in carico'>";
                                                echo "</form>";

                                                echo "</div>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "Nessun ordine trovato";
                                    //echo "sbagliato";
                                }

                                $stmt->close();
                                $conn->close();
                            }
                        }
                    } else {
                        // Nessun risultato trovato
                        echo "I tuoi turni non coincidono con l'orario e il giorno attuale, puoi modificarli nella sezione Modifica Profilo.";
                        echo $oraCorrente;
                        echo $giornoCorrente;
                        echo $mail;
                        var_dump($res);
                    }
                }
            }
        } else {
            echo ("utente non loggato");
        }
        ?>
        </section>
    </body>
    <?php include("../common/footer.html"); ?>
</html>
