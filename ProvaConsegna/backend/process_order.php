<?php
session_start();

include("../common/connessione.php");

$metodoPagamento = "";

<<<<<<< HEAD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $metodoPagamento = $_POST['metodoPagamento'];
    if (isset($_POST['selectedPlates'])) {
        // Assuming database connection and other configurations are set up

        // Retrieve selected plates from the form
        //$selected_plates = $_POST['selectedPlates'];
        //    $selected_plates = $_POST['selectedPlates'];
        $selected_Plates = json_decode($_POST['selectedPlates'], true);
    }

    
    if (isset($_SESSION['utente'])) {
        $mailacq = $_SESSION['utente'];
    }
    $data = date("Y-m-d"); // Current date in 'YYYY-MM-DD' format
    $ora = date("H:i:s"); // Current time in 'HH:MM:SS' format
    $stato = "in preparazione"; // Set default status
=======
if (isset($_POST['submitOrder'])) {
    
    $metodoPagamento = $_POST['metodoPagamento'];
if (isset($_POST['selectedPlates'])) {
    

    //recupero piatti
    $selected_Plates = json_decode($_POST['selectedPlates'], true);
}

    
    if (isset($_SESSION['utente'])) {
    $mailacq = $_SESSION['utente'];
    } // mail
    $data = date("Y-m-d"); // data corrente
    $ora = date("H:i:s"); // ora corrente
    $stato = "in preparazione"; // sato default
>>>>>>> 1e1f124761c15b3494af788393bbb532b6373b20

    // Insert in ordine
    //QUESTA è LA INSERT CHE FUNZIONA
    
    $queryOrdine = "INSERT INTO ordine (data, ora, stato, metodopagamento, mailacq) VALUES (?, ?, ?, ?, ?)";
    $stmtOrdine = $conn->prepare($queryOrdine);
    $stmtOrdine->bind_param("sssss", $data, $ora, $stato, $metodoPagamento, $mailacq);
    $stmtOrdine->execute();
    //FINE query ORDINE

    // Retrieve the auto-generated order ID
    //$orderId = $stmtOrdine->insert_id;

    // Insert into 'contiene' table for each selected item
    // QUESTA è LA INSERT CHE  NON FUNZIONA
    //inseri in contiene quindi lato ristorante
    $queryContiene = "INSERT INTO contiene (nome, mail, data, ora) VALUES (?, ?, ?, ?)";
    $stmtContiene = $conn->prepare($queryContiene);
    
    // se sono stati selezionati piatti
    if (is_array($selected_Plates)) {
        foreach ($selected_Plates as $selectedPlate) {
        
<<<<<<< HEAD
            // Split the combined values using the pipe separator
            $plateValues = explode('|', $selectedPlate);
=======
        // divido
        $plateValues = explode('|', $selectedPlate);
>>>>>>> 1e1f124761c15b3494af788393bbb532b6373b20

            // Check if the array has both values (nome and prezzo)
            //if (count($plateValues) == 2) {
            //list($nome, $prezzo) = $plateValues;
            //echo $nome;
            //echo $prezzo;
         
<<<<<<< HEAD
            // Check if the array has both values (nome and prezzo)
            if (isset($plateValues[1])) {
                list($nome, $prezzo) = $plateValues;
                // Fetch the restaurant's email using the $nome value
                $queryFetchMail = "SELECT mail FROM pietanza WHERE nome = ?";
                $stmtFetchMail = $conn->prepare($queryFetchMail);
                $stmtFetchMail->bind_param("s", $nome);
                $stmtFetchMail->execute();
                $resultFetchMail = $stmtFetchMail->get_result();
=======
         // Check if the array has both values (nome and prezzo)
    if (isset($plateValues[1])) {
        list($nome, $prezzo) = $plateValues;
            // recupero la mail del ristorante
        $queryFetchMail = "SELECT mail FROM pietanza WHERE nome = ?";
        $stmtFetchMail = $conn->prepare($queryFetchMail);
        $stmtFetchMail->bind_param("s", $nome);
        $stmtFetchMail->execute();
        $resultFetchMail = $stmtFetchMail->get_result();
>>>>>>> 1e1f124761c15b3494af788393bbb532b6373b20

                if ($resultFetchMail && $resultFetchMail->num_rows > 0) {
                    $rowFetchMail = $resultFetchMail->fetch_assoc();
                    $mailRistorante = $rowFetchMail['mail'];

<<<<<<< HEAD
                    // check mail 
                    if (isset($mailRistorante)) {
                        // Now you have $nome and $prezzo separately for each selected plate
                        // Insert into 'contiene' table
                        $stmtContiene->bind_param("ssss", $nome, $mailRistorante, $data, $ora);
                        $stmtContiene->execute();
                        //echo "Data inserted into contiene successfully.";
                    }else{
                        echo "Error: Restaurant email not found for plate $nome.";
                    }
                }
            }
        }
        // Close the statements
        $stmtOrdine->close();
        $stmtContiene->close();

        echo "Ordine eseguito con successo. Verrai reindirizzato alla lista di ristoranti";
        header("refresh:5;url=../frontend/acquirente.php");
        
        exit();
    }
} else {
        echo "Error processing selectedPlates.";
    }
    session_destroy()
?>
=======
            // check mail 
            if (isset($mailRistorante)) {
            
            // Insert in contiene
            $stmtContiene->bind_param("ssss", $nome, $mailRistorante, $data, $ora);
            $stmtContiene->execute();
    //echo "Dati inseriti";
        }else{
            echo "Errore: Non è stato trovato alcun ristorante per questo piatto  $nome.";
        }
    }
    /*
    if (!$stmtContiene->execute()) {
    echo "Errore: " . $stmtContiene->error;
    */
}
}
    




        
    // chiudo connessione
    $stmtOrdine->close();
    $stmtContiene->close();



echo "Ordine eseguito con successo. Verrai reindirizzato alla lista di ristoranti";
header("refresh:5;url=../frontend/acquirente.php");
        
        exit();
    
    //header("Location: Acquirente.php");
    
    /*
} else {
    
   // header("Location: error_page.php");
    echo "sono qui";
    exit();
    */
}


} else {
    echo "Errore nell'array selectedPlates.";
}
session_destroy()

?>
>>>>>>> 1e1f124761c15b3494af788393bbb532b6373b20
