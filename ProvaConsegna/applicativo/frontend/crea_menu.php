<!DOCTYPE html>
<html>
    <head>
        <script src="../js/javascript.js"></script>
        
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
    </head>
    <body>
        <?php include("../common/navbar_ristorante.php"); ?>
        <h1>Crea un Menu</h1>
        <section class="page-content">
        <form action="../backend/inserisci_menu.php" method="POST">
            
            
            <p><label for="nome">Nome del Menu:</label>
            <input type="text" id="nome" name="nome" required><br><br>
            </p>
            

            
            <p>
            <label for="nome">Descrizione del Menu:</label>
            <input type="text" id="descrizione" name="descrizione" required>
            <br><br>
            </p>

           <p>
            <label for="prezzo">prezzo del Menu:</label>
            <input type="float" id="prezzo" name="prezzo" required><br><br>
            </p>

            <h3 class="section-heading">Lista dei Piatti</h3>
            <div class="plate-list">


            <?php
            include("../common/connessione.php");
            session_start();
            if (isset($_SESSION['utente'])) {
                $mail = $_SESSION['utente'];

                // select da pietanza in base alla mail e il tipo
                $stmt = $conn->prepare("SELECT nome,prezzo,descrizione,tipo FROM pietanza WHERE mail = ? and tipo = 'piatto'");
                $stmt->bind_param("s", $mail);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='menu-item'>";
                        echo "<label>";
                        echo "<span>{$row['nome']} - {$row['prezzo']}- {$row['descrizione']} - {$row['tipo']}</span>";
                        echo "<input type='checkbox' name='selectedPlates[]' value='{$row['nome']}'<br>";
                        echo "<label>";
                        echo "<div>";
                    }
                } else {
                    echo "Nessun piatto trovato.";
                }
                $conn->close();
            } else {
                
                header("Location: ../login.php");
                exit();
            }
        
            
            ?>
            </div>
            
            
            <input type="submit" value="Inserisci">
        </form>
    </section>
    <?php include("../common/footer.html"); ?>
    </body>
</html>