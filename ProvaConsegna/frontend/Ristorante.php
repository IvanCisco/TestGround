<?php
    include("../common/connessione.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Menu del Ristorante</title>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
        <script src="../js/navbar.js"></script>
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <div class="navbar">
            <li><img src="../images/MainIcon.png" height="40px"></li>
            <div class="menu-toggle" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="menu-items" id="menuItems">
                <a href="profilo_ristorante.php">Profilo</a>
                <a href="modificaprofilo_ristorante.php">Modifica Profilo</a>
                <a href="inserisci_piatto.html">Inserire nuovo piatto</a>
                <a href="crea_menu.php">Crea menu</a>
                <a href="ordini_ristorante.php">Ordini</a>
                <a href="../common/logout.php">Logout</a>
            </div>
            <div class="welcome-user"></div>
        </div>
        <h2>Il tuo menu</h2>
        <?php
        if (isset($_SESSION['utente'])) {
            $mail = $_SESSION['utente'];
            //visualizzo il menu del ristorante
            $stmt = $conn->prepare("SELECT nome,prezzo,descrizione,tipo,elenco,immagine FROM pietanza WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $mailmod = str_replace(['@', '.'], '', $mail);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //stampo le pietanze di quel ristorante
                    echo "<div class='menu-item'>";
                    echo "<p>{$row['nome']} - {$row['prezzo']}- {$row['descrizione']} - {$row['tipo']} - {$row['elenco']}";
                    echo "<img src='{$row['immagine']}' style='max-width: 150px; max-height: 150px; margin-left: auto; margin-right: auto;display: inline-block; vertical-align: middle;'>";
                    echo "<img src='../immagini/delete-icon2.png' onclick=\"confirmDelete('{$row['nome']}', '{$row['prezzo']}', '{$row['descrizione']}')\" alt='Delete'></img></p>";
        ?>
                    <div class="modal" id="myModal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <p id="modalMessage"></p>
                        </div>
                    </div>
                    <?php
                    echo "</div>";
                }
            } else {
                echo "No menu items found.";
            }
            $conn->close();
        } else {
            // Reindirizzo al login
            header("Location: ../login.php");
            exit();
        }
        ?>
        <?php include("../common/footer.html"); ?>
    </body>
</html>
