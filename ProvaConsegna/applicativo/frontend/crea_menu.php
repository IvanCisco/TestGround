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
                <a href="profilo_ristorante.php">Profilo</a>
                <a href="modificaprofilo_ristorante.php">Modifica Profilo</a>
                <a href="inserisci_piatto.html">Inserire nuovo piatto</a>
                <a href="crea_menu.php">Crea menu</a>
                <a href="ordini_ristorante.php">Ordini</a>
                <a href="../common/logout.php">Logout</a>
            </div>
        </div>
        <h1>Crea un Menu</h1>
        <section class="page-content">
        <form action="../backend/inserisci_menu.php" method="POST">
            
            <div class="form-group">
            <label for="nome">Nome del Menu:</label>
            <input type="text" id="nome" name="nome" required><br><br>
            </div>
            
            <div class="form-group">
            <label for="nome">Descrizione del Menu:</label>
            <input type="text" id="descrizione" name="descrizione" required>
            <br><br>
            </div>

            <div class="form-group">
            <label for="prezzo">prezzo del Menu:</label>
            <input type="float" id="prezzo" name="prezzo" required><br><br>
            </div>

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