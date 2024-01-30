<!DOCTYPE html>
<html>
    <head>
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <h1>Riepilogo ordine</h1>
        <div>
            <h3>Piatti e menu selezionati</h2>
            <form method="post" action="../backend/process_order.php">
                <?php
                include("../common/connessione.php");
                if (isset($_POST['selectedPlates'])) {
                    // Assuming database connection and other configurations are set up

                    // Retrieve selected plates from the form
                    $selected_plates = $_POST['selectedPlates'];

                    foreach ($selected_plates as $selectedPlate) {
                        // Split the combined values using the pipe separator
                        $plateValues = explode('|', $selectedPlate);

                        // Check if the array has both values (nome and prezzo)
                        if (count($plateValues) == 2) {
                            list($nome, $prezzo) = $plateValues;
            
                            // Now you have $nome and $prezzo separately for each selected plate
                            echo "Nome: $nome, Prezzo: $prezzo<br>";
                        } else {
                            // Handle the case where the array doesn't have the expected number of values
                            echo "Invalid data format for selected plate: $selectedPlate<br>";
                        }
                    }
                } else {
                    echo "Nessun piatto selezionato o form non inviato.";
                }
                ?>
                <input type="hidden" name="selectedPlates" id="selectedPlates"value='<?php echo json_encode($_POST['selectedPlates']); ?>'>
            <h3>Metodo di pagamento</h3>
                <select id="metodoPagamento" name="metodoPagamento" onchange="showHideCardFields()">
                    <option value="contanti">Contanti</option>
                    <option value="carta">Carta</option>
                </select>
                <div id="cardFieldsContainer" style="display: none;">
                    <label for="cardNumber">Numero della carta:</label>
                    <input type="text" id="cardNumber" name="cardNumber">
                    <label for="cardCode">CCV:</label>
                    <input type="text" id="cardCode" name="cardCode">
                </div>
                <br><br>
                <input type="submit" name="submitOrder" value="Conferma Ordine">
            </form>
        </div>    
    </body>
</html>