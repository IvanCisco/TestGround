<!DOCTYPE html>
<html>
    <head>
        <script src="../js/funzioni.js" async></script>
         <link rel="stylesheet" type="text/css" href="../css/stile.css">
    </head>
    <body>
        <?php include("../common/navbar_acquirente.php"); ?>
        <h1>Riepilogo ordine</h1>
        <section class="page-content">
        <div>
            <h3>Piatti e menu selezionati</h2>
            <form method="post" action="../backend/process_order.php">
                <?php
                include("../common/connessione.php");
                if (isset($_POST['selectedPlates'])) {
                    

                    // Recupero i piatti selezionati dall'utente
                    $selected_plates = $_POST['selectedPlates'];

                    foreach ($selected_plates as $selectedPlate) {
                        // li divido
                        $plateValues = explode('|', $selectedPlate);

                        // controllo ci siano sia nome che prezzo e li separo 
                        if (count($plateValues) == 2) {
                            list($nome, $prezzo) = $plateValues;
            
                            // separati uno in $nome l'altro in $prezzo
                            echo "Nome: $nome, Prezzo: $prezzo<br>";
                        } else {
                            // gestione nel caso in cui l'array non abbia i valori chemi aspetto
                            echo "<p class=\"error\">I dati selezionati non hanno il formato corretto: $selectedPlate</p>";
                        }
                    }
                } else {
                    echo "<p class=\"error\">Nessun piatto selezionato o form non inviato.</p>";
                }
                ?>
                <!--campo hidden -->
                <input type="hidden" name="selectedPlates" id="selectedPlates"value='<?php echo json_encode($_POST['selectedPlates']); ?>'>
            <h3>Metodo di pagamento</h3>
                <select id="metodoPagamento" name="metodoPagamento" onchange="mostraCampiCarta()" required>
                    <option disabled selected value></option>
                    <option value="contanti">Contanti</option>
                    <option value="carta">Carta</option>
                </select>
                <div id="campiCarta" style="display: none; visibility: hidden;">
                    <label for="cardNumber">Numero della carta:</label>
                    <input type="text" inputmode="numeric" class="daticarta" id="cardNumber" name="cardNumber" minlength="16" maxlength="16" size="16"
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                    <label for="cardCode">CCV:</label>
                    <input type="text" inputmode="numeric" class="daticarta" id="cardCode" name="cardCode" minlength="3" maxlength="3" size="3"
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                </div>
                <br><br>
                <input type="submit" name="submitOrder" value="Conferma Ordine">
            </form>
        </div>
      </section> 
      <?php include("../common/footer.html"); ?>
    </body>
</html>